<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\ProductSerial;
use App\Models\ProductSerialLog;
use App\Models\ProductSerialNote;
use App\Models\ProductSerialParentChild;
use App\Models\ProductSerialSipTruck;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SerialRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductSerialParentChild::query()
            ->with(['productSerial.org', 'children.productSerial', 'access']);

        // Apply filters
        if ($org_id = $request->input('org_id')) {
            $query->whereHas('productSerial.org', function ($q) use ($org_id) {
                $q->where('nid', $org_id);
            });
        }

        if ($product_code = $request->input('product_code')) {
            $query->whereHas('productSerial', function ($q) use ($product_code) {
                $q->where('product_code', 'like', '%' . $product_code . '%');
            });
        }

        if ($site_status = $request->input('site_status')) {
            $query->where('site_status', $site_status);
        }

        if ($parent_serial_number = $request->input('parent_serial_number')) {
            $query->where('slno', 'like', '%' . $parent_serial_number . '%');
        }

        if ($child_serial_number = $request->input('child_serial_number')) {
            $query->whereHas('children.productSerial', function ($q) use ($child_serial_number) {
                $q->where('slno', 'like', '%' . $child_serial_number . '%');
            });
        }

        if ($did_number = $request->input('did_number')) {
            $query->where('did_numbers', 'like', '%' . $did_number . '%');
        }

//        if ($cluster_serial_number = $request->input('cluster_serial_number')) {
//            $query->where('cluster_serial_number', 'like', '%' . $cluster_serial_number . '%');
//        }

        if ($url = $request->input('url')) {
            $query->whereHas('access', function ($q) use ($url) {
                $q->where('hostname', 'like', '%' . $url . '%');
            });
        }

        if ($host_id = $request->input('host_id')) {
            $query->whereHas('productSerial', function ($q) use ($host_id) {
                $q->where('host_id', 'like', '%' . $host_id . '%');
            });
        }

        if ($customer_name = $request->input('customer_name')) {
            $query->where('customer_name', 'like', '%' . $customer_name . '%');
        }

        if ($service_level = $request->input('service_level')) {
            $query->where('support_type', $service_level);
        }

//        if ($dsm16 = $request->input('dsm16')) {
//            $query->where('dsm16', $dsm16);
//        }

        if ($site_name = $request->input('site_name')) {
            $query->where('site_name', 'like', '%' . $site_name . '%');
        }

        if ($renewal_date_start = $request->input('renewal_date_start')) {
            $query->whereDate('support_renewal_date', '>=', $renewal_date_start);
        }

        if ($renewal_date_end = $request->input('renewal_date_end')) {
            $query->whereDate('support_renewal_date', '<=', $renewal_date_end);
        }

        if ($activation_date_start = $request->input('activation_date_start')) {
            $query->whereDate('installation_date', '>=', $activation_date_start);
        }

        if ($activation_date_end = $request->input('activation_date_end')) {
            $query->whereDate('installation_date', '<=', $activation_date_end);
        }

        // Paginate results
        $records = $query->paginate(env('APP_PAGINATION'));
        $orgs = Organization::whereNotNull('nid')->get();

        return view('records.index',compact('records','orgs'));
    }
    public function details($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg', 'access')
            ->where('slno', $slno)
            ->firstOrFail();
        $orgs = Organization::whereNotNull('nid')->get();


        return view('records.details', compact('record','orgs'));
    }
    public function saveDetails(Request $request, $slno)
    {
//        dd($request->all());
        $record = ProductSerialParentChild::with('productSerial', 'access','logs')
            ->where('slno', $slno)
            ->firstOrFail();

        $validated = $request->validate([
            'installed_by' => 'nullable',
            'secondary_org' => 'nullable',
            'dealer_email' => 'nullable|email|max:255',
            'site_status' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'support_renewal_date' => 'nullable|date',
            'warranty_renewal_date' => 'nullable|date',
            'support_type' => 'nullable|string|max:255',
            'configuration' => 'nullable|string|max:128',
            'mac_address_0' => 'nullable|string|max:128',
            'mac_address_1' => 'nullable|string|max:128',
            'sw_version' => 'nullable|string|max:128',
            'public_ip' => 'nullable|ip',
            'vpn_ip_address' => 'nullable|ip',
            'url' => 'nullable|url|max:128',
            'host_id' => 'nullable|string|max:128',
            'basic_ext' => 'nullable|integer',
            'universal_ext' => 'nullable|integer',
            'e_metrotel_ext' => 'nullable|integer',
        ]);

        $record->update([
            'site_status' => $validated['site_status'],
            'installed_by' => $validated['installed_by'],
            'dealer_email' => $validated['dealer_email'],
            'installation_date' => $validated['installation_date']
                ? Carbon::parse($validated['installation_date'])->timestamp
                : null,
            'support_renewal_date' => $validated['support_renewal_date']
                ? Carbon::parse($validated['support_renewal_date'])->timestamp
                : null,
            'warranty_renewal_date' => $validated['warranty_renewal_date']
                ? Carbon::parse($validated['warranty_renewal_date'])->timestamp
                : null,
            'support_type' => $validated['support_type'],
            'configuration' => $validated['configuration'],
            'sw_version' => $validated['sw_version'],
            'basic_ext' => $validated['basic_ext'],
            'universal_ext' => $validated['universal_ext'],
            'e_metrotel_ext' => $validated['e_metrotel_ext'],
        ]);

        if ($record->productSerial) {
            $record->productSerial->update([
                'mac_address_0' => $validated['mac_address_0'],
                'mac_address_1' => $validated['mac_address_1'],
                'host_id' => $validated['host_id'],
                're_seller' => $validated['installed_by'],
                'end_customer_id' => $validated['secondary_org'],
            ]);
        }

        if ($record->access) {
            $record->access->update([
                'public_ip' => $validated['public_ip'],
                'vpn' => $validated['vpn_ip_address'],
                'hostname' => $validated['url'] ? parse_url($validated['url'], PHP_URL_HOST) : null,
            ]);
        }
        /*if ($record->logs) {
            $record->logs->update([
                're_seller' => $validated['installed_by'],
            ]);
        }*/
        ProductSerialLog::where('parent_slno', $slno)->update([
            're_seller' => $validated['installed_by'],
        ]);

        return redirect()->route('records.details', $slno)->with('success', 'Details updated successfully.');
    }
    public function customerInformation($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg')
            ->where('slno', $slno)
            ->firstOrFail();
        return view('records.customer_information', compact('record'));
    }
    public function saveCustomerInformation(Request $request, $slno)
    {
//        dd($request->all());
        $record = ProductSerialParentChild::where('slno', $slno)
            ->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:128',
            'site_name' => 'nullable|string|max:128',
            'customer_email_address' => 'nullable|email|max:128',
            'customer_phone_number' => 'nullable|string|max:128',
        ]);

        $record->update([

            'customer_name' => $validated['customer_name'],
            'site_name' => $validated['site_name'],
            'customer_email_address' => $validated['customer_email_address'],
            'customer_phone_number' => $validated['customer_phone_number'],
        ]);



        return redirect()->route('records.customer_information', $slno)->with('success', 'Customer information updated successfully.');
    }
    public function sipTrunks($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg','sipTruncks')
            ->where('slno', $slno)
            ->firstOrFail();
        return view('records.sip_trunks', compact('record'));
    }
/*    public function saveSipTrunks(Request $request, $slno)
    {
//        dd($request->all());
        $record = ProductSerialParentChild::with('sipTruncks')
            ->where('slno', $slno)
            ->firstOrFail();

        $validated = $request->validate([
            'sip_trunks' => 'nullable|integer',
            'did_numbers' => 'nullable|integer',
            'sip_trunk.*.id' => 'nullable|exists:sip_trunks,id',
            'sip_trunk.*.customer_name' => 'nullable|string|max:255',
            'sip_trunk.*.customer_address1' => 'nullable|string|max:255',
            'sip_trunk.*.customer_city' => 'nullable|string|max:255',
            'sip_trunk.*.customer_state' => 'nullable|string|max:255',
            'sip_trunk.*.customer_zip' => 'nullable|string|max:255',
            'sip_trunk.*.customer_country' => 'nullable|string|max:255',
        ]);

        $record->update([
            'sip_trunks' => $validated['sip_trunks'],
            'did_numbers' => $validated['did_numbers'],
        ]);
        $submittedIds = collect($validated['sip_trunk'] ?? [])->pluck('id')->filter()->toArray();
        $record->sipTruncks()->whereNotIn('id', $submittedIds)->delete();

        if (isset($validated['sip_trunk'])) {
            foreach ($validated['sip_trunk'] as $index => $sipTrunkData) {
                // Check if all fields are null
                $allFieldsNull = empty(array_filter($sipTrunkData, function ($value, $key) {
                    return $key !== 'id' && !is_null($value) && $value !== '';
                }, ARRAY_FILTER_USE_BOTH));

                // Skip creating new records with all null fields
                if ($allFieldsNull && !isset($sipTrunkData['id'])) {
                    continue;
                }

                if (isset($sipTrunkData['id']) && $record->sipTruncks->contains('id', $sipTrunkData['id'])) {
                    // Update existing SipTrunk
                    $sipTrunk = $record->sipTruncks->where('id', $sipTrunkData['id'])->first();
                    $sipTrunk->update([
                        'customer_name' => $sipTrunkData['customer_name'],
                        'customer_address1' => $sipTrunkData['customer_address1'],
                        'customer_city' => $sipTrunkData['customer_city'],
                        'customer_state' => $sipTrunkData['customer_state'],
                        'customer_zip' => $sipTrunkData['customer_zip'],
                        'customer_country' => $sipTrunkData['customer_country'],
                    ]);
                } else {
                    // Create new SipTrunk
                    ProductSerialSipTruck::create([
                        'slno' => $record->slno,
                        'customer_name' => $sipTrunkData['customer_name'],
                        'customer_address1' => $sipTrunkData['customer_address1'],
                        'customer_city' => $sipTrunkData['customer_city'],
                        'customer_state' => $sipTrunkData['customer_state'],
                        'customer_zip' => $sipTrunkData['customer_zip'],
                        'customer_country' => $sipTrunkData['customer_country'],
                    ]);
                }
            }
        }

        return redirect()->route('records.sip_trunks', $slno)->with('success', 'Sip trunks updated successfully.');
    }*/
    public function inventory($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg','children.productSerial.product')
            ->where('slno', $slno)
            ->firstOrFail();
        return view('records.inventory', compact('record'));
    }

    public function history($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg')->where('slno', $slno)
            ->firstOrFail();
        $logs = ProductSerialLog::where('parent_slno', $slno)->orderBy('id', 'desc')
            ->paginate(env('APP_PAGINATION'));
        return view('records.history', compact('record','logs'));
    }

    public function notes($slno)
    {
        $record = ProductSerialParentChild::with('productSerial.org','productSerial.secondaryOrg')
        ->where('slno', $slno)->firstOrFail();
        $notes = ProductSerialNote::where('slno', $record->slno)->orderBy('id', 'desc')->paginate(env('APP_PAGINATION'));
        return view('records.notes', compact('record','notes'));
    }
    public function saveNote(Request $request, $slno)
    {
        $record = ProductSerialParentChild::where('slno', $slno)
            ->firstOrFail();

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $record->notes()->create([
            'date' => time(),
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'id' => auth()->id(),
        ]);

        return redirect()->route('records.notes', $slno)->with('success', 'Note added successfully.');
    }
    public function deleteNote(Request $request, $slno, $note)
    {
        $record = ProductSerialParentChild::where('slno', $slno)
            ->firstOrFail();
        $note = $record->notes()->findOrFail($note);
        $note->delete();

        return redirect()->route('records.notes', $slno)->with('success', 'Note deleted successfully.');
    }
    public function saveRetiredHosts(Request $request, $slno)
    {
        $record = ProductSerialParentChild::where('slno', $slno)
            ->firstOrFail();

        $validated = $request->validate([
            'retired_host_id1' => 'nullable|string|max:255',
            'retired_host_note1' => 'nullable|string|max:255',
            'retired_host_id2' => 'nullable|string|max:255',
            'retired_host_note2' => 'nullable|string|max:255',
            'retired_host_id3' => 'nullable|string|max:255',
            'retired_host_note3' => 'nullable|string|max:255',
            'retired_host_id4' => 'nullable|string|max:255',
            'retired_host_note4' => 'nullable|string|max:255',
        ]);

        $record->update([
            'retired_host_id1' => $validated['retired_host_id1'],
            'retired_host_note1' => $validated['retired_host_note1'],
            'retired_host_id2' => $validated['retired_host_id2'],
            'retired_host_note2' => $validated['retired_host_note2'],
            'retired_host_id3' => $validated['retired_host_id3'],
            'retired_host_note3' => $validated['retired_host_note3'],
            'retired_host_id4' => $validated['retired_host_id4'],
            'retired_host_note4' => $validated['retired_host_note4'],
        ]);

        return redirect()->route('records.notes', $slno)->with('success', 'Retired hosts updated successfully.');
    }

    public function backup($slno)
    {
        $record = ProductSerialParentChild::where('slno', $slno)
            ->firstOrFail();
        return view('records.backup', compact('record'));

    }
}
