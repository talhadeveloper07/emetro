<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;
use App\Models\Dect;
use App\Models\DectExtension;

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
                    DB::raw("DATE_FORMAT(dect.last_push, '%Y-%m-%d') as last_push_date")

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
        return view('provisioning.dect.index', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reseller' => 'required|integer',
            'slno' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'mac' => 'required|string|max:255',
        ]);

        $device = Dect::create([
            're_seller' => $validated['reseller'],
            'slno' => $validated['slno'],
            'model' => $validated['model'],
            'mac' => $validated['mac'],
        ]);

        return response()->json(['success' => true, 'data' => $device]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || count($ids) == 0) {
            return response()->json(['message' => 'No records selected'], 400);
        }

        Dect::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected records deleted successfully']);
    }



    public function dect_details(Request $request, $dectId)
    {
        // Fetch DECT record
        $dectData = DB::table('dect')->where('id', $dectId)->first();

        if (!$dectData) {
            return back()->with('error', 'DECT record not found.');
        }

        $mac = $dectData->mac ?? '';
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
        $codecRowOptions = config('codec.codecRowOptions');


        return view('provisioning.dect.details', compact('dectData', 'portLimit', 'dectId', 'regionOptions', 'countryRowOptions', 'codecRowOptions'));
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

            // Decode codec priority order (JSON string from hidden input)
            $codecPriority = json_decode($request->codec_priority_order, true);

            // Ensure it’s a valid array
            if (!is_array($codecPriority)) {
                $codecPriority = [];
            }

            // Update DECT record
            $dect->update([
                'sip_mode' => $request->sip_mode,
                'model' => $request->model,
                'sip_server_address' => $request->sip_server_address,
                'sip_server_port' => $request->sip_server_port,
                'time_server' => $request->time_server,
                'country' => $request->country,
                'region' => $request->region,
                'primary_mac' => $request->s2_ip_address,
                'codec_priority' => json_encode($codecPriority), // 👈 Add this line
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

    public function pushMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
    
        if (empty($ids)) {
            return response()->json(['message' => 'No DECT IDs provided.'], 400);
        }
    
        $successCount = 0;
        $errors = [];
    
        foreach ($ids as $id) {
            try {
                $dect = Dect::findOrFail($id);
    
                $extensions = DectExtension::where('mac', $dect->mac)
                    ->orderBy('index')
                    ->get();
    
                // Ensure directory exists
                Storage::makeDirectory('provisioning/dect/config');
                $fileName = strtolower(str_replace(':', '', $dect->mac)) . '.cfg';
                $cfgPath = "provisioning/dect/config/{$fileName}";
    
                // SIP server domain (fallback if none provided)
                $sipDomain = $dect->sip_domain ?? '192.168.2.200:5078';
    
                if ($extensions->isEmpty()) {
                    // Generate minimal config if no extensions exist
                    $content = <<<CFG
    // Auto-generated configuration file
    // DECT MAC: {$dect->mac}
    // No extensions available for this device.
    
    %SRV_SIP_SERVER_ALIAS%:"UCX","","","","","","","","",""
    %SRV_SIP_UA_DATA_DOMAIN%:"{$sipDomain}","","","","","","","","",""
    %SRV_SIP_UA_CODEC_PRIORITY%:0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF
    %SRV_SIP_TRANSPORT%:0x01
    %SIP_USE_DIFFERENT_PORTS%:0x01
    
    %NETWORK_DATA_CONFIG_PRIMARY_MAC%={$dect->mac}
    %NETWORK_SNTP_SERVER%="{$dect->time_server}"
    %COUNTRY_VARIANT_ID%:{$dect->country}
    %COUNTRY_REGION_ID%:{$dect->region}
    %TIMEZONE_BY_COUNTRY_REGION%:0x01
    %AUTO_DECT_REGISTER%:0x01
    CFG;
    
                } else {
                    // Build full config content
                    $content = [];
                    $content[] = "// SIP server";
                    $content[] = '%SRV_SIP_SERVER_ALIAS%:"UCX","","","","","","","","",""';
                    $content[] = sprintf('%%SRV_SIP_UA_DATA_DOMAIN%%:"%s","","","","","","","","",""', $sipDomain);
                    $content[] = '%SRV_SIP_UA_CODEC_PRIORITY%:0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF,0x00,0x01,0x06,0x04,0xFF';
                    $content[] = '%SRV_SIP_TRANSPORT%:0x01';
                    $content[] = '%SIP_USE_DIFFERENT_PORTS%:0x01';
                    $content[] = "";
                    $content[] = "// Primary MAC";
                    $content[] = "%NETWORK_DATA_CONFIG_PRIMARY_MAC%={$dect->mac}";
                    $content[] = "";
                    $content[] = "// Time and country";
                    $content[] = "%NETWORK_SNTP_SERVER%=\"{$dect->time_server}\"";
                    $content[] = "%COUNTRY_VARIANT_ID%:{$dect->country}";
                    $content[] = "%COUNTRY_REGION_ID%:{$dect->region}";
                    $content[] = "%TIMEZONE_BY_COUNTRY_REGION%:0x01";
                    $content[] = "";
                    $content[] = "// Handsets";
    
                    $hsIndexes = implode(',', range(0, $extensions->count() - 1));
                    $content[] = "%SUBSCR_SIP_HS_ID%:{$hsIndexes}";
    
                    $configured = implode(',', array_fill(0, $extensions->count(), '0x01'));
                    $content[] = "%SUBSCR_SIP_UA_DATA_CONFIGURED%:{$configured}";
    
                    $dispNames = '"' . $extensions->pluck('display_name')->implode('","') . '"';
                    $usernames = '"' . $extensions->pluck('extension')->implode('","') . '"';
                    $secrets   = '"' . $extensions->pluck('secret')->implode('","') . '"';
    
                    $content[] = "%SUBSCR_SIP_UA_DATA_DISP_NAME%={$dispNames}";
                    $content[] = "%SUBSCR_SIP_UA_DATA_SIP_NAME%={$usernames}";
                    $content[] = "%SUBSCR_SIP_UA_DATA_AUTH_NAME%={$usernames}";
                    $content[] = "%SUBSCR_SIP_UA_DATA_AUTH_PASS%={$secrets}";
                    $content[] = "";
                    $content[] = "%AUTO_DECT_REGISTER%:0x01";
    
                    $content = implode(PHP_EOL, $content);
                }
    
                // Write config file
                Storage::disk('local')->put($cfgPath, $content);
    
                // Update last push (store as UNIX timestamp or datetime)
                $dect->update(['last_push' => now()]);
    
                $successCount++;
    
            } catch (\Exception $e) {
                $errors[] = "Error pushing DECT ID {$id}: " . $e->getMessage();
            }
        }
    
        return response()->json([
            'message' => "✅ Successfully generated configs for {$successCount} DECT(s).",
            'errors'  => $errors,
        ]);
    }
    
}