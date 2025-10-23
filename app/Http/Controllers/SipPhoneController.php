<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Template;
use App\Models\Mac;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SipPhoneController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('provisioning.sip_phones.templates.index', compact('organizations'));
    }

    public function getModelsByVendor($vendor)
    {
        $options = [
            'Yealink' => [
                'T4x_Series' => 'T4x_Series',
                'T5x_Series' => 'T5x_Series',
                'Conference_Phones' => 'Conference_Phones',
            ],
            'Fanvil' => [
                'X_and_XU' => 'X_and_XU',
            ],
            'Grandstream' => [
                'GXP_IP_Phones' => 'GXP_IP_Phones',
                'GRP_IP_Phones' => 'GRP_IP_Phones',
                'GDS_Door_Phones' => 'GDS_Door_Phones',
                'GSC_Speaker_Intercom' => 'GSC_Speaker_Intercom',
            ],
            'Snom' => [
                'D713' => 'D713',
                'D717' => 'D717',
                'D735' => 'D735',
                'D785' => 'D785',
                'M400' => 'M400',
                'M500' => 'M500',
                'M900' => 'M900',
            ],
            'Polycom' => [
                'VVX_Series' => 'VVX_Series',
            ],
        ];

        return response()->json($options[$vendor] ?? []);
    }


    public function mac_index()
    {
        $organizations = Organization::all();
        return view('provisioning.sip_phones.mac.index', compact('organizations'));
    }

    public function extension_index()
    {
        $organizations = Organization::all();
        return view('provisioning.sip_phones.extensions.index', compact('organizations'));
    }

    public function getTemplatesData(Request $request)
    {
        // Build base query
        $query = Template::query();
    
        // Optional filters if you add search fields later
        if ($request->vendor) {
            $query->where('vendor', 'like', "%{$request->vendor}%");
        }
        if ($request->model) {
            $query->where('model', 'like', "%{$request->model}%");
        }
        if ($request->organization) {
            $query->where('re_seller', 'like', "%{$request->organization}%");
        }
    
        // Get all records
        $templates = $query->get();
    
        // Return formatted JSON for DataTables
        return response()->json([
            'data' => $templates->map(function ($item) {
                return [
                    'checkbox' => '<input type="checkbox" class="record-checkbox" value="'.$item->id.'">',
                    'id' => $item->id,
                    'template_name' => $item->template_name,
                    'vendor' => $item->vendor,
                    'model' => $item->model,
                    're_seller' => $item->re_seller,
                    'modified_date' => $item->modified_date,
                    'file_location' => $item->file_location,
                    'is_default' => $item->is_default ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>',
                    'actions' => '
                    <a href="' . route('provisioning.templates.download', $item->id) . '" 
                    class="btn btn-sm btn-icon btn-primary" 
                    title="Download Template">
                     <svg xmlns="http://www.w3.org/2000/svg" 
                          width="16" height="16" 
                          viewBox="0 0 24 24" 
                          fill="none" 
                          stroke="currentColor" 
                          stroke-width="2" 
                          stroke-linecap="round" 
                          stroke-linejoin="round" 
                          class="icon icon-tabler icon-tabler-download">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                         <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                         <path d="M7 11l5 5l5 -5"/>
                         <path d="M12 4l0 12"/>
                     </svg>
                 </a>
                ',
                
                ];
            }),
        ]);
    }

    public function getMacData()
    {
        $macs = DB::table('mac')
            ->select('id', 'mac as mac_name', 'vendor', 'model', 'template_name', 're_seller', 'modified_date')
            ->get();
    
        $data = $macs->map(function ($item) {
            $templates = $this->getTemplates($item->vendor, $item->model);
    
            // Build dropdown HTML
            $templateSelect = '<select name="template_name" class="form-select form-select-sm template-select" data-mac-id="' . $item->id . '" style="width:100%;">';
            $templateSelect .= '<option value="">Select Template</option>';
    
            foreach ($templates as $template) {
                $selected = ($item->template_name === $template->template_name) ? 'selected' : '';
                $templateSelect .= '<option value="' . e($template->template_name) . '" ' . $selected . '>' . e($template->template_name) . '</option>';
            }
    
            $templateSelect .= '</select>';
    
            return [
                'checkbox' => '<input type="checkbox" class="record-checkbox" value="'.$item->id.'">',
                'id' => $item->id,
                'mac_name' => e($item->mac_name),
                'vendor' => e($item->vendor),
                'model' => e($item->model),
                'template_name' => $templateSelect, // 👈 dropdown instead of plain text
                're_seller' => e($item->re_seller),
                'modified_date' => $item->modified_date ? date('Y-m-d', strtotime($item->modified_date)) : '-',
            ];
        });
    
        return response()->json(['data' => $data]);
    }

    private function getTemplates($vendor, $model)
    {
        return Template::where('vendor', $vendor)
            ->where('model', $model)
            ->select('template_name')
            ->get();
    }

    public function update_mac_template(Request $request)
{
    $request->validate([
        'mac_id' => 'required|integer',
        'template_name' => 'nullable|string',
    ]);

    DB::table('mac')
        ->where('id', $request->mac_id)
        ->update([
            'template_name' => $request->template_name,
            'modified_date' => now(),
        ]);

    return response()->json(['success' => true]);
}

    
    public function template_store(Request $request)
        {
            $request->validate([
                'reseller' => 'nullable|exists:organizations,id',
                'vendor' => 'required|string',
                'model' => 'required|string',
                'template_name' => [
                    'required',
                    'regex:/^[a-zA-Z0-9_]+$/', // only letters, numbers, and underscore
                ],
                'template_file' => 'required|file|mimes:xml,txt,json,cfg',
            ]);
        
            $templateName = strtolower($request->template_name);
            $uploadedFile = $request->file('template_file');
        
            // Path and file name
            $path = "private/provisioning/template/default/";
            $fileName = "{$templateName}.{$uploadedFile->getClientOriginalExtension()}";
        
            // Store file using putFileAs (saves directly in storage/app)
            $storedPath = $uploadedFile->storeAs($path, $fileName, 'local');
        
            // Save to database
            Template::create([
                're_seller' => $request->reseller,
                'vendor' => $request->vendor,
                'model' => $request->model,
                'template_name' => $templateName,
                'file_location' => $storedPath,
                'is_default' => false,
                'modified_date' => now(),
            ]);
        
            return response()->json([
                'success' => true,
                'message' => 'Template uploaded successfully.',
            ]);
        }

    public function bulk_template_delete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No templates selected.'], 400);
        }

        // Delete records and files if needed
        $templates = Template::whereIn('id', $ids)->get();

        foreach ($templates as $template) {
            if ($template->template_file && \Storage::disk('public')->exists($template->template_file)) {
                \Storage::disk('public')->delete($template->template_file);
            }

            $template->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Selected templates deleted successfully.'
        ]);
    }
    public function download_template($id)
    {
        $template = Template::findOrFail($id);

        if (!$template->file_location || !Storage::disk('local')->exists($template->file_location)) {
            abort(404, 'File not found');
        }

        $filename = basename($template->file_location);
        return Storage::disk('local')->download($template->file_location, $filename);
    }

    public function getExtensions(Request $request)
    {
        $query = DB::table('extension')
            ->leftJoin('product_serial', 'extension.slno', '=', 'product_serial.slno')
            ->leftJoin('product_serial_parent_child', 'product_serial.slno', '=', 'product_serial_parent_child.slno')
            ->leftJoin('mac', 'mac.id', '=', 'extension.mac')
            ->select(
                'extension.id as extension_id',
                'extension.extension',
                'extension.mac as mac_selected_id',
                'mac.id as mac_id',
                'mac.vendor',
                'mac.model',
                'mac.template_name',
                'extension.slno as ucx_sn',
                'product_serial_parent_child.site_name',
                'extension.server_address',
                'extension.port',
                'extension.last_push'
            )
            ->orderBy('extension.id', 'desc')
            ->get();
    
        return response()->json([
            'data' => $query->map(function ($item) {
                return [
                    'checkbox' => '<input type="checkbox" class="record-checkbox" value="' . $item->extension_id . '">',
                    'extension' => e($item->extension),
                    'mac_id' => $this->macSelect($item->mac_selected_id, $item->extension_id),
                    'vendor' => e($item->vendor ?? ''),
                    'model' => e($item->model ?? ''),
                    'template_name' => e($item->template_name ?? ''),
                    'ucx_sn' => e($item->ucx_sn ?? ''),
                    'site_name' => e($item->site_name ?? 'N/A'),
                    'server_address' => e($item->server_address ?? ''),
                    'last_push' => $item->last_push ? date('Y-m-d', strtotime($item->last_push)) : '-',
                ];
            }),
        ]);
    }
    
    private function macSelect($selectedMacId = null, $extensionId)
    {
        $macs = DB::table('mac')->select('id', 'mac')->get();
        $html = '<select name="mac" id="mac_select_' . $extensionId . '" 
                         class="form-select form-select-sm mac-select" 
                         data-extension="' . $extensionId . '" style="width:100%;">';
        $html .= '<option value=""></option>';
    
        foreach ($macs as $mac) {
            $selected = ($selectedMacId == $mac->id) ? 'selected' : '';
            $html .= '<option value="' . $mac->id . '" ' . $selected . '>' . e($mac->mac) . '</option>';
        }
    
        $html .= '</select>';
    
        return $html;
    }
    public function getMacDetails($macId)
    {
        $mac = DB::table('mac')
            ->select('vendor', 'model', 'template_name')
            ->where('id', $macId)
            ->first();

        if (!$mac) {
            return response()->json(['error' => 'MAC not found'], 404);
        }

        return response()->json([
            'vendor' => $mac->vendor ?? '',
            'model' => $mac->model ?? '',
            'template_name' => $mac->template_name ?? '',
        ]);
    }

    public function update_mac(Request $request)
    {
        $request->validate([
            'extension_id' => 'required|integer',
            'mac_id' => 'nullable|integer',
        ]);

        try {
            DB::table('extension')
                ->where('id', $request->extension_id)
                ->update([
                    'mac' => $request->mac_id,
                    'updated_at' => now(),
                ]);

            // Fetch MAC info to return to JS
            $mac = DB::table('mac')
                ->where('id', $request->mac_id)
                ->select('vendor', 'model', 'template_name')
                ->first();

            return response()->json([
                'success' => true,
                'vendor' => $mac->vendor ?? '',
                'model' => $mac->model ?? '',
                'template_name' => $mac->template_name ?? '',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    



}
