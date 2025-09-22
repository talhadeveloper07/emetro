<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Log;
use App\Models\Organization;
use App\Models\PaymentTerm;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends HelperController
{
    public function eMetroTelAdmin()
    {
        return view('admin.index');
    }

    public function commercialsIndex()
    {
        return view('admin.commercials.index');
    }
    public function paymentTerms()
    {
        $terms = PaymentTerm::paginate(env('APP_PAGINATION'));
        return view('admin.commercials.payment_terms', compact('terms'));
    }
    public function paymentTermsStore(Request $request)
    {
        $request->validate([
            'days' => 'required',
        ]);
        $name = "Net " . $request->input('days');
        $exists = PaymentTerm::where('name', $name)->exists();
        if ($exists) {
            return back()->with('error', 'The payment term "' . $name . '" already exists.');
        }
        $term = PaymentTerm::create(['name' => $name]);
        return redirect()->route('e_admin.payment_terms.index')->with('success', 'Payment Term created successfully.');
    }
    public function paymentTermsDelete($id)
    {
        PaymentTerm::where('id',$id)->delete();
        return redirect()->route('e_admin.payment_terms.index')
            ->with('success', 'Payment Term deleted successfully.');
    }
    public function discountManagement()
    {
        $discounts = Discount::paginate(env('APP_PAGINATION'));
        return view('admin.commercials.discount_management', compact('discounts'));
    }
    public function discountManagementStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:discounts,name',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'createData') // use a custom error bag
                ->withInput()
                ->with('open_modal', 'create');
        }
        $discount=Discount::create([
            'name' => $request->input('name'),
            'amount' => $request->input('amount'),
        ]);
        $customTypes = ['Customer', 'End Customer', 'End Customer 2'];
        $organizations = Organization::select('id', 'org_type')->get();
        $attachData = $organizations->mapWithKeys(function ($org) use ($discount, $customTypes) {
            $isCustom = in_array($org->org_type, $customTypes);
            return [
                $org->id => [
                    'custom_amount' => $isCustom ? 0 : $discount->amount,
                    'is_custom' => $isCustom,
                ]
            ];
        });

        $discount->organizations()->syncWithoutDetaching($attachData->all());

        return back()->with('success', 'Discount created successfully.');
    }
    public function discountManagementUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:discounts,name,' . $id,
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'updateData') // use a different error bag
                ->withInput()
                ->with('open_modal', 'update-' . $id); // or just 'update'
        }

        $discount = Discount::findOrFail($id);
        $discount->update([
            'name' => $request->input('name'),
            'amount' => $request->input('amount'),
        ]);
        // Update all organizations where is_custom = false
        DB::table('discount_organization')
            ->where('discount_id', $discount->id)
            ->where('is_custom', false)
            ->update(['custom_amount' => $discount->amount]);

        return back()->with('success', 'Discount updated successfully.');
    }
    public function discountManagementDelete($id)
    {
        Discount::where('id',$id)->delete();
        return back()->with('success', 'Discount deleted successfully.');
    }

    public function salesIndex()
    {
        return view('admin.sales.index');
    }
    public function marketingIndex()
    {
        return view('admin.marketing.index');
    }
    public function inventoryIndex()
    {
        return view('admin.inventory.index');
    }
    public function adminIndex()
    {
        return view('admin.adminIndex');
    }
    public function adminSettingIndex()
    {
        return view('admin.settings.index');
    }

    public function registrationIndex()
    {
        return view('registration.index');
    }
    public function registrationDetail()
    {
        return view('registration.detail');
    }
    public function serviceChangeIndex()
    {
        return view('service_change.index');
    }

    public function roleIndex()
    {
        return view('role.index');
    }
    public function orderStatus()
    {
        return view('order_status.index');
    }
    public function orderStatusDetails($id)
    {
        return view('order_status.detail');
    }


}
