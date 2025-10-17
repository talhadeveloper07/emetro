<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvisioningInfinity3065;
use App\Models\ProductSerial;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use App\Helpers\XmlHelper;
use Illuminate\Support\Facades\Storage;

class ProvisioningInfinity3065Controller extends Controller
{
    public function index(Request $request)
    {
        $organizations = DB::table('organizations')->get();
        return view('provisioning.infinity3065.index', compact('organizations'));
    }

    public function getData(Request $request)
    {
        $query = ProvisioningInfinity3065::query();
    
        // Total records before filtering
        $totalRecords = ProvisioningInfinity3065::count();
    
        // Filters
        if ($request->filled('org_id')) {
            $query->where('reseller_id', $request->org_id);
        }
        if ($request->filled('phone_type')) {
            $query->where('device_type', 'like', "%{$request->phone_type}%");
        }
        if ($request->filled('phone_serial_number')) {
            $query->where('slno', 'like', "%{$request->phone_serial_number}%");
        }
        if ($request->filled('device_id')) {
            $query->where('device_id', 'like', "%{$request->device_id}%");
        }
        if ($request->filled('s1_ip')) {
            $query->where('s1_ip', 'like', "%{$request->s1_ip}%");
        }
        if ($request->filled('s2_ip')) {
            $query->where('s2_ip', 'like', "%{$request->s2_ip}%");
        }
        if ($request->filled('slno')) {
            $query->where('slno', 'like', "%{$request->slno}%");
        }
        if ($request->filled('status')) {
            $query->where('device_current_status', $request->status);
        }
    
        // Filtered count
        $filteredRecords = $query->count();
    
        // Sorting
        $columns = [
            'checkbox',
            'device_id',
            'first_name',
            'last_name',
            'slno',
            'device_type',
            's1_info',
            'reseller_id',
            'device_current_status',
            'updated_at',
        ];
        
        if ($request->has('order.0.column')) {
            $orderColIndex = $request->order[0]['column'];
            $orderCol = $columns[$orderColIndex] ?? 'updated_at';
            $orderDir = $request->order[0]['dir'] ?? 'desc';
            
            if (!in_array($orderCol, ['checkbox', 's1_info'])) {
                $query->orderBy($orderCol, $orderDir);
            }
        } else {
            $query->orderBy('updated_at', 'desc');
        }
    
        // Pagination
        $limit = $request->length ?? 10;
        $offset = $request->start ?? 0;
    
        // ✅ Join organizations to get organization name for reseller_id
        $table = (new ProvisioningInfinity3065)->getTable();
    
        $records = $query
            ->leftJoin('organizations', 'organizations.id', '=', $table.'.reseller_id')
            ->select($table.'.*', 'organizations.name as organization_name')
            ->skip($offset)
            ->take($limit)
            ->get();

        // Map data
        $data = $records->map(function ($row) {
            return [
                'checkbox' => '<input type="checkbox" class="single-select" value="'.$row->slno.'">',
                'device_id' => $row->device_id,
                'full_name' => $row->first_name .' '.$row->last_name,
                'serial_number' => '<a href="'.route('provisioning.infinity3065.show', $row->slno).'">'.$row->slno.'</a>',
                'device_type' => $row->device_type ?? '',
                's1_info' => ($row->s1_ip ?? '').':'.($row->s1_port ?? ''),
                'reseller_id' => $row->organization_name ?? '',
                'device_current_status' => $row->device_current_status,
                'updated' => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '',
                'actions' => '<button type="button" class="btn btn-sm btn-primary editBtn" data-id="'.$row->slno.'">Edit</button>
                              <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->slno.'">Delete</button>'
            ];
        });
    
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }
    

 public function store(Request $request)
{
    $validated = $request->validate([
        'device_id' => 'nullable|string|max:50|unique:soft_phone_provisioning,device_id',
        'slno' => 'required|string|unique:soft_phone_provisioning,slno',
        'first_name' => 'nullable|string|max:50',
        'last_name' => 'nullable|string|max:50',
        'extension' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:100',
        'mobile' => 'nullable|string|max:20',
        'notification_method' => 'nullable|string|max:50',

        's1_ip' => 'nullable',
        's1_port' => 'nullable|integer|min:0',
        's1_retry_number' => 'nullable|integer|min:0',

        's2_ip' => 'nullable',
        's2_port' => 'nullable|integer|min:0',
        's2_retry_number' => 'nullable|integer|min:0',

        'allow_multiple_profile' => 'nullable|boolean',
        'allow_changes_default_profile' => 'nullable|boolean',
        'profile_update_frequency' => 'nullable|string|max:50',
        'infinityone_url' => 'nullable|url',
        'sms_did_1' => 'nullable|string|max:20',
        'sms_did_2' => 'nullable|string|max:20',

        'reseller_name' => 'nullable|string|max:100',
        'device_type' => 'nullable|string|max:50',
        'device_current_status' => 'nullable|string|max:50',
    ]);


    if (!$request->filled('slno')) {
        $validated['slno'] = uniqid('SLNO_');
    }

    if (empty($validated['device_id'])) {
        do {
            $validated['device_id'] = Str::random(12);
        } while (ProvisioningInfinity3065::where('device_id', $validated['device_id'])->exists());
    }

    $record = ProvisioningInfinity3065::create($validated);

    // XmlHelper::saveXml($record);


    return response()->json(['success' => true, 'message' => 'Record created successfully']);
}


    public function show($slno)
    {
        $phone = ProvisioningInfinity3065::where('slno', $slno)->firstOrFail();
        return view('provisioning.infinity3065.details', compact('phone'));
    }

    public function edit($slno)
    {
        $phone = ProvisioningInfinity3065::where('slno', $slno)->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $phone->toArray()
        ]);
    }

    // public function update(Request $request, $slno)
    // {
    //     $phone = ProvisioningInfinity3065::where('slno', $slno)->firstOrFail();

    //     $validated = $request->validate([
    //         'device_id' => 'string|max:50',
    //         'slno' => 'string|unique:provisioning_infinity3065,slno,'.$phone->id,
    //         'first_name' => 'nullable|string|max:50',
    //         'last_name' => 'nullable|string|max:50',
    //         'extension' => 'nullable|string|max:20',
    //         'email' => 'nullable|email|max:100',
    //         'mobile' => 'nullable|string|max:20',
    //         'notification_method' => 'nullable|string|max:50',

    //         's1_ip' => 'nullable|ip',
    //         's1_port' => 'nullable|integer|min:0',
    //         's1_retry_number' => 'nullable|integer|min:0',

    //         's2_ip' => 'nullable|ip',
    //         's2_port' => 'nullable|integer|min:0',
    //         's2_retry_number' => 'nullable|integer|min:0',

    //         'allow_multiple_profile' => 'nullable|boolean',
    //         'allow_changes_default_profile' => 'nullable|boolean',
    //         'profile_update_frequency' => 'nullable|string|max:50',
    //         'infinityone_url' => 'nullable|url',
    //         'sms_did_1' => 'nullable|string|max:20',
    //         'sms_did_2' => 'nullable|string|max:20',

    //         'reseller_name' => 'nullable|string|max:100',
    //         'device_type' => 'nullable|string|max:50',
    //         'device_current_status' => 'nullable|string|max:50',
    //     ]);

    //     $phone->update($validated);

    //     return response()->json(['success' => true, 'message' => 'Record updated successfully']);
    // }

    public function update(Request $request, $slno)
{
    $record = ProvisioningInfinity3065::where('slno', $slno)->firstOrFail();

    $validated = $request->validate([
        'device_id' => 'nullable|string|max:50',
        'slno' => 'required|string|unique:soft_phone_provisioning,slno,' . $record->slno . ',slno',
        'first_name' => 'nullable|string|max:50',
        'last_name' => 'nullable|string|max:50',
        'extension' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:100',
        'mobile' => 'nullable|string|max:20',
        'notification_method' => 'nullable|string|max:50',

        's1_ip' => 'nullable',
        's1_port' => 'nullable|integer|min:0',
        's1_retry_number' => 'nullable|integer|min:0',

        's2_ip' => 'nullable',
        's2_port' => 'nullable|integer|min:0',
        's2_retry_number' => 'nullable|integer|min:0',

        'allow_multiple_profile' => 'nullable|boolean',
        'allow_changes_default_profile' => 'nullable|boolean',
        'profile_update_frequency' => 'nullable|string|max:50',
        'infinityone_url' => 'nullable|url',
        'sms_did_1' => 'nullable|string|max:20',
        'sms_did_2' => 'nullable|string|max:20',

        'reseller_name' => 'nullable|string|max:100',
        'device_type' => 'nullable|string|max:50',
        'device_current_status' => 'nullable|string|max:50',
    ]);

    

    $validated = $request->except('slno'); 
    $record->update($validated);

    return response()->json(['success' => true, 'message' => 'Record updated successfully']);
}


    public function destroy(Request $request)
    {
        $id = $request->id;
        if(!$id){
            return response()->json(['message'=>'No record specified'], 400);
        }

        ProvisioningInfinity3065::where('slno', $id)->delete();

        return response()->json(['message'=>'Record deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if(!$ids || count($ids) == 0){
            return response()->json(['message'=>'No records selected'], 400);
        }

        ProvisioningInfinity3065::whereIn('slno', $ids)->delete();

        return response()->json(['message'=>'Selected records deleted successfully']);
    }

    public function export(Request $request)
    {
        $fileName = 'provisioning_infinity3065_export.csv';
        $records = ProvisioningInfinity3065::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'device_id', 'slno', 'first_name', 'last_name', 'extension', 'email',
            'mobile', 'notification_method', 
            's1_ip', 's1_port', 's1_retry_number',
            's2_ip', 's2_port', 's2_retry_number',
            'allow_multiple_profile', 'allow_changes_default_profile', 'profile_update_frequency',
            'infinityone_url', 'sms_did_1', 'sms_did_2',
            'reseller_name', 'device_type', 'device_current_status',
            'updated_at', 'created_at'
        ];

        $callback = function() use ($records, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            foreach ($records as $record) {
                $row = [];
                foreach ($columns as $col) {
                    $row[] = $record->$col ?? '';
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function getSerials(Request $request)
    {
        $search = $request->q;
    
        $serials = ProductSerial::query()
            ->when($search, function ($query) use ($search) {
                $query->where('product_serial.slno', 'like', "%$search%");
            })
            ->leftJoin('product_serial_access as psa', 'psa.slno', '=', 'product_serial.slno')
            ->select(
                'product_serial.slno as id',
                'product_serial.slno as text',
                'psa.hostname',
                'psa.public_ip',
            )
            ->where('product_serial.type', 'Parent')
            ->limit(20)
            ->get();
    
        return response()->json($serials);
    }
    

    public function getHostIps(Request $request)
    {

    }

    public function downloadXml($slno)
    {
        $filePath = "provisioning_xml/softphone_{$slno}.xml";

        if (!Storage::exists($filePath)) {
            abort(404, "File not found");
        }

        return Storage::download($filePath);
    }

    public function xmlFeed(Request $request)
    {
        $records = ProvisioningInfinity3065::all();

        // Build simple XML using DOMDocument for pretty printing
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('softphones');
        $dom->appendChild($root);

        foreach ($records as $record) {
            $phone = $dom->createElement('softphone');

            // Add child helper
            $add = function ($name, $value) use ($dom, $phone) {
                $child = $dom->createElement($name);
                // ensure it's string and avoid null node issues
                $child->appendChild($dom->createTextNode((string) $value));
                $phone->appendChild($child);
            };

            $add('slno', $record->slno);
            $add('device_id', $record->device_id);
            $add('first_name', $record->first_name);
            $add('last_name', $record->last_name);
            $add('extension', $record->extension);
            $add('email', $record->email);
            $add('mobile', $record->mobile);
            $add('s1_ip', $record->s1_ip);
            $add('s1_port', $record->s1_port);
            $add('s1_retry_number', $record->s1_retry_number);
            $add('s2_ip', $record->s2_ip);
            $add('s2_port', $record->s2_port);
            $add('s2_retry_number', $record->s2_retry_number);
            $add('reseller_name', $record->reseller_name);
            $add('device_type', $record->device_type);
            $add('device_current_status', $record->device_current_status);
            $add('org_id', $record->org_id);

            $root->appendChild($phone);
        }

        $xmlString = $dom->saveXML(); // pretty formatted XML string

        // If download requested, return as attachment
        if ($request->query('download') == '1') {
            $fileName = 'soft_phone_provisioning.xml';
            return response($xmlString, 200, [
                'Content-Type' => 'application/xml; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            ]);
        }

        // Otherwise show pretty HTML view
        return view('provisioning.xml_feed', [
            'xml' => $xmlString,
        ]);
    }

}
