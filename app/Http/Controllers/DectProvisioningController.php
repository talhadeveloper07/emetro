<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\Dect;

class DectProvisioningController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('dect')
            ->leftJoin('product_serial_parent_child', 'product_serial_parent_child.slno', '=', 'dect.slno')
            ->select(
                'dect.id',
                'dect.mac as mac_address',
                'dect.slno as ucx_sn',
                'product_serial_parent_child.site_name',
                'dect.model',
                'dect.extension as extensions',
                DB::raw("FROM_UNIXTIME(dect.last_push, '%Y-%m-%d') as last_push_date")
            );

        if ($request->filled('ucx_sn')) {
            $query->where('dect.slno', 'like', '%' . $request->ucx_sn . '%');
        }

        if ($request->filled('site_name')) {
            $query->where('product_serial_parent_child.site_name', 'like', '%' . $request->site_name . '%');
        }

        if ($request->filled('model')) {
            $query->where('dect.model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('reseller')) {
            $query->where('dect.re_seller', 'like', '%' . $request->reseller . '%');
        }

        if ($request->filled('mac_address')) {
            $query->where('dect.mac', 'like', '%' . $request->mac_address . '%');
        }

        $dectItems = $query->orderBy('dect.id', 'DESC')->get();

        return response()->json(['data' => $dectItems]);
        }
        
        $organizations = Organization::all();
        return view('provisioning.dect.index',compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reseller' => 'required|integer',
            'slno'     => 'required|string|max:255',
            'model'    => 'required|string|max:255',
            'mac'      => 'required|string|max:255',
        ]);

        $device = Dect::create([
            're_seller' => $validated['reseller'],
            'slno'        => $validated['slno'],
            'model'       => $validated['model'],
            'mac'         => $validated['mac'],
        ]);

        return response()->json(['success' => true, 'data' => $device]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if(!$ids || count($ids) == 0){
            return response()->json(['message'=>'No records selected'], 400);
        }

        Dect::whereIn('id', $ids)->delete();

        return response()->json(['message'=>'Selected records deleted successfully']);
    }



    public function dect_details(Request $request, $dectId)
    {
        // Fetch DECT record
        $dectData = DB::table('dect')->where('id', $dectId)->first();
    
        if (!$dectData) {
            return back()->with('error', 'DECT record not found.');
        }
    
        $mac   = $dectData->mac ?? '';
        $model = $dectData->model ?? '';
    
        // Define model-based port limits
        $portLimits = [
            'AP500D/AP510D' => 20,
            'AP500M/AP510M' => 1000,
        ];
    
        $portLimit = $portLimits[$model] ?? 0;
  
        if ($request->ajax()) {
            $dectExtData = DB::table('dect_extension')->where('mac', $mac)->get();

            $data = $dectExtData->map(function ($fxExt, $i) use ($dectId, $mac) {
                return [
                    'checkbox' => '<input type="checkbox" class="form-check-input row-select" data-id="' . e($fxExt->id) . '" />',
                    'extension' => e($fxExt->extension),
                    'secret' => e($fxExt->secret ?? ''),
                    'display_name' => e($fxExt->display_name ?? ''),
                    'port' => '<input type="number" class="dect_ports form-control form-control-sm"
                        name="dect_port[]" 
                        value="' . e($fxExt->index) . '" 
                        id="dect_port_select_' . $i . '" 
                        data-dect-extension="' . e($fxExt->id) . '" 
                        data-dect-id="' . e($dectId) . '" 
                        data-mac="' . e($mac) . '">',
                ];
            });
        
            return response()->json(['data' => $data]);
        }

        $regionOptions = config('region');
        $countryRowOptions = config('countries.codes');
    
        return view('provisioning.dect.details', compact('dectData', 'portLimit', 'dectId','regionOptions','countryRowOptions'));
    }

    public function updateDectExtensionIndex(Request $request)
    {
        $request->validate([
            'dect_extension_id' => 'required|integer|exists:dect_extension,id',
            'index' => 'required|integer|min:0',
        ]);

        try {
            DB::table('dect_extension')
                ->where('id', $request->dect_extension_id)
                ->update(['index' => $request->index]);

            return response()->json([
                'status' => 'success',
                'message' => 'Index updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update index: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dect = Dect::findOrFail($id);

            $dect->update([
                'sip_mode' => $request->sip_mode,
                'model' => $request->model,
                'sip_server_address' => $request->sip_server_address,
                'sip_server_port' => $request->sip_server_port,
                'time_server' => $request->time_server,
                'country' => $request->country,
                'region' => $request->region,
                'primary_mac' => $request->s2_ip_address,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function deleteExtensions(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return response()->json(['message' => 'No extensions selected.'], 400);
        }

        DB::table('dect_extension')->whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected extensions deleted successfully.']);
    }




}
