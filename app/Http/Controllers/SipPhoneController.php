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
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;



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

    
  public function getMacData(Request $request)
{
    $query = Mac::query()
        ->leftJoin('organizations', 'organizations.id', '=', 'mac.re_seller') // 👈 Join reseller name
        ->select(
            'mac.id',
            'mac.mac as mac_name',
            'mac.vendor',
            'mac.model',
            'mac.template_name',
            'mac.re_seller',
            'organizations.name as reseller_name', // 👈 Get readable org name
            'mac.modified_date'
        );

    // ✅ Filters
    if ($request->vendor) {
        $query->where('mac.vendor', $request->vendor);
    }

    if ($request->model) {
        $query->where('mac.model', $request->model);
    }

    if ($request->template_name) {
        $query->where('mac.template_name', 'like', "%{$request->template_name}%");
    }

    $macs = $query->get();

    $data = $macs->map(function ($item) {
        $templates = $this->getTemplates($item->vendor, $item->model);

        // Build dropdown HTML for Template select
        $templateSelect = '<select name="template_name" class="form-select form-select-sm template-select" data-mac-id="' . $item->id . '" style="width:100%;">';
        $templateSelect .= '<option value="">Select Template</option>';

        foreach ($templates as $template) {
            $selected = ($item->template_name === $template->template_name) ? 'selected' : '';
            $templateSelect .= '<option value="' . e($template->template_name) . '" ' . $selected . '>' . e($template->template_name) . '</option>';
        }

        $templateSelect .= '</select>';

        return [
            'checkbox' => '<input type="checkbox" class="record-checkbox" value="' . $item->id . '">',
            'id' => $item->id,
            'mac_name' => e($item->mac_name),
            'vendor' => e($item->vendor),
            'model' => e($item->model),
            'template_name' => $templateSelect,
            're_seller' => e($item->reseller_name ?? 'N/A'), // 👈 Show org name instead of ID
            'modified_date' => $item->modified_date ? date('Y-m-d', strtotime($item->modified_date)) : '-',
        ];
    });

    return response()->json(['data' => $data]);
}

    public function store_mac(Request $request)
    {

        $validated = $request->validate([
            'reseller' => 'nullable|integer',
            'mac' => 'required|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'template_name' => 'nullable|string|max:255',
        ]);


        Mac::create([
            'mac' => $validated['mac'],
            'vendor' => $validated['vendor'] ?? null,
            'model' => $validated['model'] ?? null,
            'template_name' => $validated['template_name'] ?? null,
            're_seller' => $validated['reseller'] ?? null,
            'modified_date' => now(),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'MAC address added successfully!'
        ]);
    }


public function import_mac(Request $request)
{
    $validator = Validator::make($request->all(), [
        'reseller' => 'nullable|integer',
        'mac_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    $file = $request->file('mac_file');
    $handle = fopen($file->getRealPath(), 'r');
    $header = fgetcsv($handle);

    // Required columns
    $required = ['mac', 'vendor', 'model', 'template_name'];
    $header = array_map('strtolower', $header);

    // Check header match
    foreach ($required as $column) {
        if (!in_array($column, $header)) {
            return response()->json([
                'success' => false,
                'message' => "Invalid CSV header. Required columns: mac, vendor, model, template_name"
            ], 422);
        }
    }

    $count = 0;

    while (($row = fgetcsv($handle)) !== false) {
        $data = array_combine($header, $row);

        if (!empty($data['mac'])) {
            Mac::create([
                'mac' => $data['mac'],
                'vendor' => $data['vendor'] ?? null,
                'model' => $data['model'] ?? null,
                'template_name' => $data['template_name'] ?? null,
                're_seller' => $request->reseller ?? null,
                'modified_date' => now(),
            ]);
            $count++;
        }
    }

    fclose($handle);

    return response()->json([
        'success' => true,
        'message' => "Successfully imported {$count} MAC addresses."
    ]);
}


    public function mac_bulk_delete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No items selected'], 400);
        }

        Mac::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected records deleted successfully.']);
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
        );

    // ✅ Filters (added all possible form fields)
    if ($request->filled('reseller')) {
        $query->where('product_serial.reseller', 'like', "%{$request->reseller}%");
    }

    if ($request->filled('extension')) {
        $query->where('extension.extension', 'like', "%{$request->extension}%");
    }

    if ($request->filled('mac')) {
        $query->where('mac.id', $request->mac);
    }

    if ($request->filled('site_name')) {
        $query->where('product_serial_parent_child.site_name', 'like', "%{$request->site_name}%");
    }

    if ($request->filled('port')) {
        $query->where('extension.port', 'like', "%{$request->port}%");
    }

    if ($request->filled('server_address')) {
        $query->where('extension.server_address', 'like', "%{$request->server_address}%");
    }

    if ($request->filled('ucx_slno')) {
        $query->where('extension.slno', 'like', "%{$request->ucx_slno}%");
    }

    if ($request->filled('vendor')) {
        $query->where('mac.vendor', 'like', "%{$request->vendor}%");
    }

    if ($request->filled('model')) {
        $query->where('mac.model', 'like', "%{$request->model}%");
    }

    if ($request->filled('template_name')) {
        $query->where('mac.template_name', 'like', "%{$request->template_name}%");
    }

    // ✅ Get results
    $extensions = $query->orderBy('extension.id', 'desc')->get();

    // ✅ Response
    return response()->json([
        'data' => $extensions->map(function ($item) {
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
                'actions' => '
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $item->extension_id . '">
                        <i class="fas fa-trash"></i>
                    </button>'
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

    


public function exportSelected(Request $request)
{
    $ids = explode(',', $request->query('ids', ''));

    if (empty($ids)) {
        return redirect()->back()->with('error', 'No records selected');
    }

    $extensions = DB::table('extension')
        ->leftJoin('product_serial', 'extension.slno', '=', 'product_serial.slno')
        ->leftJoin('product_serial_parent_child', 'product_serial.slno', '=', 'product_serial_parent_child.slno')
        ->leftJoin('mac', 'mac.id', '=', 'extension.mac')
        ->whereIn('extension.id', $ids)
        ->select(
            'extension.extension',
            'mac.vendor',
            'mac.model',
            'mac.template_name',
            'extension.slno as ucx_sn',
            'product_serial_parent_child.site_name',
            'extension.server_address',
            'extension.last_push'
        )
        ->get();

    $response = new StreamedResponse(function() use ($extensions) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Extension', 'Vendor', 'Model', 'Template', 'UCX SN', 'Site Name', 'Server Address', 'Last Push']);
        foreach ($extensions as $row) {
            fputcsv($handle, [
                $row->extension,
                $row->vendor,
                $row->model,
                $row->template_name,
                $row->ucx_sn,
                $row->site_name,
                $row->server_address,
                $row->last_push
            ]);
        }
        fclose($handle);
    });

    $filename = 'selected_extensions_' . date('Y_m_d_H_i_s') . '.csv';
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

    return $response;
}

public function bulkDelete(Request $request)
{
    $ids = $request->input('ids', []);
    if (empty($ids)) {
        return response()->json(['message' => 'No records selected.'], 400);
    }

    DB::table('extension')->whereIn('id', $ids)->delete();
    return response()->json(['message' => 'Selected records deleted successfully.']);
}

public function destroy($id)
{
    $deleted = DB::table('extension')->where('id', $id)->delete();

    if ($deleted) {
        return response()->json(['message' => 'Record deleted successfully.']);
    }

    return response()->json(['message' => 'Record not found.'], 404);
}




public function exportCfg(Request $request)
{
    $ids = $request->input('ids', []);

    if (empty($ids)) {
        return response()->json(['message' => 'No records selected.'], 400);
    }

    $records = DB::table('extension')
        ->leftJoin('product_serial', 'extension.slno', '=', 'product_serial.slno')
        ->leftJoin('product_serial_parent_child', 'product_serial.slno', '=', 'product_serial_parent_child.slno')
        ->leftJoin('mac', 'mac.id', '=', 'extension.mac')
        ->select(
            'extension.extension',
            'mac.vendor',
            'mac.model',
            'mac.template_name',
            'extension.slno as ucx_sn',
            'product_serial_parent_child.site_name',
            'extension.server_address',
            'extension.port',
            'extension.last_push'
        )
        ->whereIn('extension.id', $ids)
        ->get();

    if ($records->isEmpty()) {
        return response()->json(['message' => 'No data found.'], 404);
    }

    // Create .cfg content
    $cfgContent = "# Auto-Generated Configuration File\n";
    $cfgContent .= "# Generated on: " . now()->format('Y-m-d H:i:s') . "\n\n";

    foreach ($records as $r) {
        $cfgContent .= "###########################################\n";
        $cfgContent .= "Extension={$r->extension}\n";
        $cfgContent .= "Vendor={$r->vendor}\n";
        $cfgContent .= "Model={$r->model}\n";
        $cfgContent .= "Template={$r->template_name}\n";
        $cfgContent .= "UCX_SN={$r->ucx_sn}\n";
        $cfgContent .= "SiteName={$r->site_name}\n";
        $cfgContent .= "ServerAddress={$r->server_address}\n";
        $cfgContent .= "Port={$r->port}\n";
        $cfgContent .= "LastPush={$r->last_push}\n\n";
    }

    $filename = 'extensions_' . date('Ymd_His') . '.cfg';

    // Return as file download
    return response($cfgContent)
        ->header('Content-Type', 'text/plain')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}






// 


public function importExtensions(Request $request)
{
    $request->validate([
        'reseller' => 'required',
        'ucx_slno' => 'required',
        'server_address' => 'required',
        'port' => 'required',
        'extension_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('extension_file');
    $path = $file->getRealPath();

    $rows = array_map('str_getcsv', file($path));
    $header = array_map(fn($h) => strtolower(trim($h)), array_shift($rows));

    // ✅ Normalize column headers (lowercase)
    $requiredHeaders = ['display name', 'user extension', 'secret', 'tech', 'mac'];

    foreach ($requiredHeaders as $col) {
        if (!in_array($col, $header)) {
            return response()->json([
                'message' => "Invalid CSV format. Missing column: $col"
            ], 422);
        }
    }

    $inserted = 0;

    foreach ($rows as $row) {
        // Combine header + data safely
        $data = array_combine($header, $row);

        if (!$data) continue;

        // ✅ Only process rows with Tech = sip
        if (strtolower(trim($data['tech'] ?? '')) !== 'sip') continue;

        DB::table('extension')->updateOrInsert(
            ['extension' => trim($data['user extension'])],
            [
                'slno'           => $request->ucx_slno,
                'server_address' => $request->server_address,
                'port'           => $request->port,
                'extension'      => trim($data['user extension']),
                'display_name'   => trim($data['display name']),
                'secret'         => trim($data['secret']),
                'mac'            => trim($data['mac']),
                'status'         => 'active',
                're_seller'      => $request->reseller,
                'last_push'      => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        );

        $inserted++;
    }

    return response()->json([
        'message' => "✅ Import completed successfully. ($inserted records imported)"
    ]);
}






// 



}
