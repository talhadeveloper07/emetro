<?php

namespace App\Http\Controllers;

use App\Models\AssuranceNotification;
use App\Models\Discount;
use App\Models\Organization;
use App\Models\OrganizationDocument;
use App\Models\OrganizationHwFulfillment;
use App\Models\OrganizationLog;
use App\Models\OrganizationNote;
use App\Models\OrganizationSetting;
use App\Models\OrganizationSwFulfillment;
use App\Models\PaymentTerm;
use App\Models\ProductSerialParentChild;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::select(
            'id', 'name', 'billing_address_1', 'billing_address_2', 'billing_state',
            'billing_city', 'billing_country', 'email', 'phone', 'org_type', 'status'
        );
        $states=[];
        // Apply filters
        if ($request->filled('org_id')) {
            $query->where('id', $request->org_id);
        }

        if ($request->filled('org_email')) {
            $query->where('email', 'like', '%' . $request->org_email . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('org_type')) {
            // Multiple select -> use whereIn
            $query->whereIn('org_type', (array) $request->org_type);
        }

        if ($request->filled('country')) {
            $states=DB::table('states')
                ->select('id', 'state_code', 'name')
                ->where('country_code', $request->country)
                ->orderBy('name')
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
            $query->where('billing_country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('billing_state', $request->state);
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        // Paginate results
        $orgs = $query->paginate(env('APP_PAGINATION'))->appends($request->all());

        $all_orgs = Organization::select('id', 'name')->get();
        $countries = Cache::rememberForever('countries_list', function () {
            return DB::table('countries')
                ->select('id', 'iso2', 'name')
                ->orderByRaw("
            CASE
                WHEN iso2 = 'US' THEN 0
                WHEN iso2 = 'CA' THEN 1
                ELSE 2
            END, name
        ")
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        });
        return view('org.index', compact('orgs','countries','states','all_orgs'));
    }

    public function summary($id)
    {
        $org = Organization::with('hwFulfillments','swFulfillments')->findOrFail($id);
        $discounts = Discount::all();
        $orgs=Organization::whereNotNull('nid')->get();
        $countries = Cache::rememberForever('countries_list', function () {
            return DB::table('countries')
                ->select('id', 'iso2', 'name')
                ->orderByRaw("
            CASE
                WHEN iso2 = 'US' THEN 0
                WHEN iso2 = 'CA' THEN 1
                ELSE 2
            END, name
        ")
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        });
        $states=DB::table('states')
            ->select('id', 'state_code', 'name')
            ->where('country_code', $org->billing_country)
            ->orderBy('name')
            ->get()
            ->map(fn($row) => (array) $row)
            ->all();
        return view('org.summary', compact('discounts', 'org','orgs','countries','states'));
    }
    public function summary_update(Request $request, $id)
    {
        $org = Organization::findOrFail($id);
        $originalData = $org->getOriginal();

        // Define fillable fields
        $fillable = [
            'org_type', 'status', 'billing_country', 'billing_state', 'email',
            'phone', 'website', 'emt_contact', 'price_type', 'agent_name',
            'agent_start'
        ];

        // Validate request data
        $validated = $request->validate([
            'org_type' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:Active,Prospect,Hold,Deactivated',
            'billing_country' => 'nullable|string|max:2',
            'billing_state' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'emt_contact' => 'nullable|string|max:255',
            'price_type' => 'nullable|string|max:255',
            'agent_name' => 'nullable|string|max:255',
            'agent_start' => 'nullable|date',
            'hw_fulfilment' => 'nullable|array',
            'sw_fulfilment' => 'nullable|array',
        ]);

        // Prepare changes array for logging
        $changes = [];
        foreach ($fillable as $field) {
            if ($request->has($field) && $originalData[$field] != $request->$field) {
                $changes[$field] = [
                    'old' => $originalData[$field],
                    'new' => $request->$field
                ];
            }
        }

        // Update organization
        $org->update(array_intersect_key($validated, array_flip($fillable)));

        // Handle HW fulfillments (HasMany relationship)
        if ($request->has('hw_fulfilment')) {
            $newHwFulfillments = $request->hw_fulfilment ?? [];
            $originalHwFulfillments = $org->hwFulfillments->pluck('hw_fulfillment_nid')->toArray();

            // Only log if there are actual changes
            if (array_diff($originalHwFulfillments, $newHwFulfillments) || array_diff($newHwFulfillments, $originalHwFulfillments)) {
                $changes['hw_fulfilment'] = [
                    'old' => $originalHwFulfillments,
                    'new' => $newHwFulfillments
                ];
            }

            // Delete existing HW fulfillments
            $org->hwFulfillments()->delete();

            // Create new HW fulfillments
            foreach ($newHwFulfillments as $hwNid) {
                OrganizationHwFulfillment::create([
                    'org_nid' => $org->nid,
                    'hw_fulfillment_nid' => $hwNid
                ]);
            }
        }

        // Handle SW fulfillments (HasMany relationship)
        if ($request->has('sw_fulfilment')) {
            $newSwFulfillments = $request->sw_fulfilment ?? [];
            $originalSwFulfillments = $org->swFulfillments->pluck('sw_fulfillment_nid')->toArray();

            // Only log if there are actual changes
            if (array_diff($originalSwFulfillments, $newSwFulfillments) || array_diff($newSwFulfillments, $originalSwFulfillments)) {
                $changes['sw_fulfilment'] = [
                    'old' => $originalSwFulfillments,
                    'new' => $newSwFulfillments
                ];
            }

            // Delete existing SW fulfillments
            $org->swFulfillments()->delete();

            // Create new SW fulfillments
            foreach ($newSwFulfillments as $swNid) {
                OrganizationSwFulfillment::create([
                    'org_nid' => $org->nid,
                    'sw_fulfillment_nid' => $swNid
                ]);
            }
        }

        // Log changes if any
        if (!empty($changes)) {
            $messageParts = [];
            foreach ($changes as $field => $change) {
                if ($field === 'hw_fulfilment' || $field === 'sw_fulfilment') {
                    $newValue = implode(', ', $change['new']);
                    $messageParts[] = ucfirst(str_replace('_', ' ', $field)) . ": $newValue";
                } else {
                    $newValue = $change['new'] ?? 'null';
                    $messageParts[] = ucfirst(str_replace('_', ' ', $field)) . ": $newValue";
                }
            }
            $message = !empty($messageParts) ? 'Updated fields: ' . implode(', ', $messageParts) : null;
            OrganizationLog::create([
                'organization_id' => $org->id,
                'user_id' => Auth::id(),
                'action' => 'update summary',
                'message' => $message,
                'changes' => json_encode($changes),
            ]);
        }

        return redirect()->route('org.summary', $id)->with('success', 'Organization summary updated successfully');
    }

    public function details($id)
    {
        $org = Organization::with('setting','paymentTerms','discounts')->findOrFail($id);
        $discounts = Discount::all();
        $paymentTerms = PaymentTerm::all();
        $countries = DB::table('countries')
            ->select('id', 'iso2', 'name')
            ->orderByRaw("
                    CASE
                        WHEN iso2 = 'US' THEN 0
                        WHEN iso2 = 'CA' THEN 1
                        ELSE 2
                    END, name
                ")
            ->get()
            ->map(fn($row) => (array) $row)
            ->all();
        $billingStates = DB::table('states')
            ->select('id', 'state_code', 'name')
            ->where('country_code', $org->billing_country)
            ->orderBy('name')
            ->get()
            ->map(fn($row) => (array) $row)
            ->all();
        $shippingStates = DB::table('states')
            ->select('id', 'state_code', 'name')
            ->where('country_code', $org->shipping_country)
            ->orderBy('name')
            ->get()
            ->map(fn($row) => (array) $row)
            ->all();
        return view('org.details', compact('discounts', 'org', 'paymentTerms', 'countries', 'billingStates', 'shippingStates'));    }
    public function details_update(Request $request, $id)
    {
        $org = Organization::findOrFail($id);
        $originalData = $org->getOriginal();
        $originalSetting = $org->setting ? $org->setting->getOriginal() : [];
        $originalDiscounts = $org->discounts->pluck('pivot.custom_amount', 'id')->toArray();
        $originalPaymentTerms = $org->paymentTerms->pluck('id')->toArray();

        // Define fillable fields for Organization
        $orgFillable = [
            'billing_address_1', 'billing_address_2', 'billing_city', 'billing_country',
            'billing_state', 'billing_zip', 'billing_county', 'shipping_address_1',
            'shipping_address_2', 'shipping_city', 'shipping_country', 'shipping_state',
            'shipping_zip', 'shipping_county', 'no_of_emp', 'tax_exemption'
        ];

        // Define fillable fields for OrganizationSetting
        $settingFillable = [
            'is_paypal', 'is_emtpay', 'is_stripe', 'is_ach', 'is_emtpay_topup',
            'save_credit_card', 'monthly_bill_auto_payment', 'annual_bill_auto_payment',
            'payment_terms_credit_limit', 'force_direct_customer_billing'
        ];
        // Define boolean fields that need default false (0) when not in request
        $booleanFields = [
            'is_paypal', 'is_emtpay', 'is_stripe', 'is_ach', 'is_emtpay_topup',
            'save_credit_card', 'monthly_bill_auto_payment', 'annual_bill_auto_payment',
            'force_direct_customer_billing'
        ];

        // Validate request data
        $validated = $request->validate([
            'billing_address_1' => 'nullable|string|max:255',
            'billing_address_2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:2',
            'billing_state' => 'nullable|string|max:255',
            'billing_zip' => 'nullable|string|max:255',
            'billing_county' => 'nullable|string|max:255',
            'shipping_address_1' => 'nullable|string|max:255',
            'shipping_address_2' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_country' => 'nullable|string|max:2',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_zip' => 'nullable|string|max:255',
            'shipping_county' => 'nullable|string|max:255',
            'no_of_emp' => 'nullable|string|max:255',
            'tax_exemption' => 'nullable|string|max:255',
            'discounts' => 'nullable|array',
            'discounts.*' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|array',
            'payment_terms.*' => 'exists:payment_terms,id',
            'is_paypal' => 'nullable|boolean',
            'is_emtpay' => 'nullable|boolean',
            'is_stripe' => 'nullable|boolean',
            'is_ach' => 'nullable|boolean',
            'is_emtpay_topup' => 'nullable|boolean',
            'save_credit_card' => 'nullable|boolean',
            'monthly_bill_auto_payment' => 'nullable|boolean',
            'annual_bill_auto_payment' => 'nullable|boolean',
            'payment_terms_credit_limit' => 'nullable|numeric|min:0',
            'force_direct_customer_billing' => 'nullable|boolean'
        ]);
// Set default false (0) for unchecked boolean fields
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? (bool) $request->input($field) : false;
        }
        // Prepare changes array for logging
        $changes = [];

        // Track Organization changes
        foreach ($orgFillable as $field) {
            if ($request->has($field) && $originalData[$field] != $request->$field) {
                $changes[$field] = [
                    'old' => $originalData[$field],
                    'new' => $request->$field
                ];
            }
        }

        // Track OrganizationSetting changes
        foreach ($settingFillable as $field) {
            if ($request->has($field) && ($originalSetting[$field] ?? null) != $request->$field) {
                $changes[$field] = [
                    'old' => $originalSetting[$field] ?? null,
                    'new' => $request->$field
                ];
            }
        }

        // Handle Discounts
        $newDiscounts = $request->discounts ?? [];
        $discounts = Discount::whereIn('id', array_keys($newDiscounts))->pluck('amount', 'id')->toArray();
        $syncData = [];

        // Check if org_type is or was Customer
        $isCustomer = $originalData['org_type'] === 'Customer';

        foreach ($newDiscounts as $discountId => $customAmount) {
            $originalAmount = $originalDiscounts[$discountId] ?? null;
            $discountDefaultAmount = $discounts[$discountId] ?? null;

            if ($isCustomer) {
                // For Customer org_type, set custom_amount to 0 and is_custom to true
                $customAmount = 0;
                $isCustom = true;
            } else {
                // Otherwise, compare with default amount
                $isCustom = ($customAmount !== null && $discountDefaultAmount !== null && $customAmount != $discountDefaultAmount);
            }

            if ($originalAmount != $customAmount || ($originalDiscounts[$discountId] ?? null) !== ($isCustom ? $customAmount : $discountDefaultAmount)) {
                $changes["discount_{$discountId}"] = [
                    'old' => $originalAmount,
                    'new' => $customAmount
                ];
            }

            $syncData[$discountId] = [
                'custom_amount' => $customAmount,
                'is_custom' => $isCustom
            ];
        }

        // Track Payment Terms changes
        $newPaymentTerms = $request->payment_terms ?? [];
        if (array_diff($originalPaymentTerms, $newPaymentTerms) || array_diff($newPaymentTerms, $originalPaymentTerms)) {
            $changes['payment_terms'] = [
                'old' => $originalPaymentTerms,
                'new' => $newPaymentTerms
            ];
        }

        // Generate message for updated fields
        $messageParts = [];
        foreach ($changes as $field => $change) {
            if ($field === 'payment_terms') {
                $newValue = implode(', ', $change['new']);
                $messageParts[] = ucfirst(str_replace('_', ' ', $field)) . ": $newValue";
            } elseif (strpos($field, 'discount_') === 0) {
                $discountId = str_replace('discount_', '', $field);
                $discountName = Discount::find($discountId)?->name ?? "Discount $discountId";
                $newValue = $change['new'] ?? 'null';
                $messageParts[] = "$discountName: $newValue";
            } else {
                $newValue = $change['new'] ?? 'null';
                $messageParts[] = ucfirst(str_replace('_', ' ', $field)) . ": $newValue";
            }
        }
        $message = !empty($messageParts) ? 'Updated fields: ' . implode(', ', $messageParts) : null;

        // Log changes if any
        if (!empty($changes)) {
            OrganizationLog::create([
                'organization_id' => $org->id,
                'user_id' => Auth::id(),
                'action' => 'update details',
                'message' => $message,
                'changes' => json_encode($changes),
            ]);
        }

        // Update Organization
        $org->update(array_intersect_key($validated, array_flip($orgFillable)));

        // Update or create OrganizationSetting
        $settingData = array_intersect_key($validated, array_flip($settingFillable));
        if ($org->setting) {
            $org->setting->update($settingData);
        } else {
            $settingData['org_nid'] = $org->nid;
            OrganizationSetting::create($settingData);
        }

        // Update Discounts
        if ($request->has('discounts')) {
            $org->discounts()->sync($syncData);
        }

        // Update Payment Terms
        if ($request->has('payment_terms')) {
            $org->paymentTerms()->sync($newPaymentTerms);
        }

        return redirect()->route('org.details', $id)->with('success', 'Organization details updated successfully');
    }

    public function contacts($id)
    {
        $org = Organization::findOrFail($id);
        $users= User::where('org_id',$org->id)->get();
        return view('org.contacts', compact('org','users'));
    }

    public function document(Request $request,$id)
    {
        $org = Organization::findOrFail($id);
        $type = $request->type;

        $query = OrganizationDocument::where('org_id', $id);

        if (!empty($type)) {
            $query->where('type', $type);
        }
        $documents = $query->paginate(env('APP_PAGINATION'))->appends($request->all());
        return view('org.document', compact('org','documents','request'));
    }
    public function documentSave(Request $request,$id)
    {
        $request->validate([
            'type' => 'required|string',
            'file' => 'required|file|max:2048|mimes:pdf,doc,docx,png,jpg,jpeg',
        ], [
            'file.max' => 'The file may not be greater than 2MB.',
            'file.mimes' => 'Allowed file types are: pdf, doc, docx, png, jpg.',
        ]);


        $file = $request->file('file');
        $originalName = $file->getClientOriginalName(); // original filename with extension
        $filename = str_replace(['#', '/', '\\'], '-', $originalName); // sanitize
        $destinationPath = public_path('org_document');
        $file->move($destinationPath, $filename);
        $filePath='org_document/'.$filename;
        OrganizationDocument::create([
            'org_id' => $id,
            'type' => $request->type,
            'file' => $filePath,
            'status' => 'Pending',
            'added_by' => auth()->id(),
        ]);

        return back()->with('success','Document uploaded successfully');
    }
    public function documentUpdateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:organization_documents,id',
            'status' => 'required|in:Pending,Completed,Rejected',
        ]);

        $document = OrganizationDocument::findOrFail($request->id);
        $document->status = $request->status;
        $document->updated_by = auth()->id();
        $document->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function notes($id)
    {
        $org = Organization::with('notes')->findOrFail($id);
        return view('org.notes', compact('org'));
    }
    public function saveNotes(Request $request, $orgId)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:10000',
            'note_type' => 'required|in:public,private',
        ]);

        OrganizationNote::create([
            'org_id' => $orgId,
            'note' => $validated['note'],
            'note_type' => $validated['note_type'],
            'user_id' => Auth::id(), // assumes auth is enabled
        ]);

        return back()->with('success', 'Note saved successfully.');
    }
    public function notifications(Request $request,$id)
    {

        $org = Organization::findOrFail($id);
        $slnos = ProductSerialParentChild::select('slno')
            ->where('installed_by', $org->nid)
            ->pluck('slno')
            ->toArray();

        $query = AssuranceNotification::whereIn('slno', $slnos);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', Carbon::parse($request->start_date)->toDateString());
//            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());

        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', Carbon::parse($request->end_date)->toDateString());
//            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());

        }
        if ($request->filled('to')) {
            $query->where('to', 'LIKE', '%' . $request->to . '%');
        }
        $notifications = $query->orderBy('id', 'desc')
            ->paginate(env('APP_PAGINATION'))
            ->appends($request->all());
        return view('org.notifications', compact('org','notifications'));
    }


}
