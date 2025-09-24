<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvisioningInfinity5xxxController extends Controller
{
    public function infinity5()
    {
        return view('provisioning.infinity5xxx.index');
    }

    public function getData(Request $request)
    {
        $columns = [
            'product_serial.slno',
            'product_serial.status',
            'product_serial.re_seller',
            'product_serial.product_code',
            'product_serial_parent_child.site_name',
            'product_serial_parent_child.installed_by',
            'product_serial.mac_address_0',
            'product_serial.updated',
        ];
    
        // Paging
        $limit = $request->input('length');
        $start = $request->input('start');
    
        // Ordering
        $orderColumnIndex = $request->input('order.0.column'); 
        $orderColumnName  = $columns[$orderColumnIndex] ?? 'product_serial.slno';
        $orderDir         = $request->input('order.0.dir', 'desc');
    
        $query = DB::table('product_serial')
            ->leftJoin(
                'product_serial_parent_child',
                'product_serial.slno',
                '=',
                'product_serial_parent_child.slno'
            );
    
        // Total count before filtering
        $totalData = $query->count();
    
        // Apply Filters
        if ($request->filled('org_id')) {
            $query->where('product_serial.re_seller', $request->org_id);
        }
        if ($request->filled('phone_type')) {
            $query->where('product_serial.product_code', 'like', "%" . $request->phone_type . "%");
        }
        if ($request->filled('phone_serial_number')) {
            $query->where('product_serial.slno', 'like', "%" . $request->phone_serial_number . "%");
        }
        if ($request->filled('mac_address')) {
            $query->where('product_serial.mac_address_0', 'like', "%" . $request->mac_address . "%");
        }
        if ($request->filled('s1_ip')) {
            $query->where('product_serial_parent_child.s1_ip', 'like', "%" . $request->s1_ip . "%");
        }
        if ($request->filled('s2_ip')) {
            $query->where('product_serial_parent_child.s2_ip', 'like', "%" . $request->s2_ip . "%");
        }
        if ($request->filled('ucx_serial_number')) {
            $query->where('product_serial_parent_child.parent_slno', 'like', "%" . $request->ucx_serial_number . "%");
        }
        if ($request->filled('status')) {
            $status = $request->status === "Registered" ? "Activated" : $request->status;
            $query->where('product_serial.status', $status);
        }
    
        // Count after filters
        $totalFiltered = $query->count();
    
        // Fetch Records
        $records = $query
            ->select($columns)
            ->orderBy($orderColumnName, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();
    
        // Format for DataTables
        $data = [];
        foreach ($records as $row) {
            $assignedParent = DB::table('product_serial_child')
                ->where('slno', $row->slno)
                ->value('assigned_to_parent');
    
            $nested = [];
            $nested['checkbox'] = "<input type='checkbox' class='single-select' value='{$row->slno}'>";
            $nested['slno'] = $row->slno;
            $nested['status'] = $row->status === "Activated" ? "Registered" : $row->status;
            $nested['re_seller'] = $row->re_seller;
            $nested['product_code'] = $row->product_code;
            $nested['site_name'] = $row->site_name;
            $nested['installed_by'] = $row->installed_by;
            $nested['mac_address_0'] = $row->mac_address_0;
            $nested['updated'] = $row->updated ? date("m/d/Y", $row->updated) : null;
            $nested['parent_slno'] = $assignedParent ?? null;
            
            // Action buttons
            $nested['actions'] = "
                <button class='btn btn-sm btn-primary edit-btn' data-id='{$row->slno}' title='Edit'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-edit'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1'/><path d='M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z'/><path d='M16 5l3 3'/></svg>
                </button>
                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row->slno}' title='Delete'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-trash'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M4 7l16 0'/><path d='M10 11l0 6'/><path d='M14 11l0 6'/><path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12'/><path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3'/></svg>
                </button>
            ";
    
            $data[] = $nested;
        }
    
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function getRecord($id)
    {
        try {
            $record = DB::table('product_serial')
                ->leftJoin('product_serial_parent_child', 'product_serial.slno', '=', 'product_serial_parent_child.slno')
                ->where('product_serial.slno', $id)
                ->select('product_serial.*', 'product_serial_parent_child.*')
                ->first();

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function updateRecord(Request $request, $id)
    {
        return $this->updateInfinityRecord($request, $id);
    }

public function updateMultipleRecords(Request $request)
{
    try {
        $ids = $request->input('selected_rows', []);
        $data = $request->except(['_token', 'selected_rows']);
        
        if (empty($ids)) {
            return response()->json(['error' => 'No records selected'], 400);
        }

        $count = 0;
        $errors = [];

        foreach ($ids as $id) {
            try {
                // FIXED: Create proper request data
                $requestData = new Request();
                $requestData->replace($data); // Set the data properly
                
                $result = $this->updateInfinityRecord($requestData, $id, false);
                if ($result['success']) {
                    $count++;
                }
            } catch (\Exception $e) {
                $errors[] = "Failed to update record {$id}: " . $e->getMessage();
                \Log::error("Failed to update record {$id}: " . $e->getMessage());
            }
        }

        // Update timestamp for all affected records
        if ($count > 0) {
            DB::table('product_serial')->whereIn('slno', $ids)->update(['updated' => time()]);
        }

        $message = "{$count} phones updated successfully";
        if (!empty($errors)) {
            $message .= ". Errors: " . implode(', ', array_slice($errors, 0, 3)); // Show first 3 errors only
        }

        \Log::info('Bulk update completed: ' . $message);
        return response()->json(['success' => $message]);

    } catch (\Exception $e) {
        \Log::error('Bulk update failed: ' . $e->getMessage());
        return response()->json(['error' => 'Update failed: ' . $e->getMessage()], 500);
    }
}

    // MISSING METHOD - ADD THIS
   private function updateInfinityRecord(Request $request, $id, $updateTimestamp = true)
{
    try {
        DB::beginTransaction();

        // Get all data from request
        $data = $request->all();

        // Debug: Log the incoming data
        \Log::info('Updating record for ID: ' . $id);
        \Log::info('Request data: ', $data);

        // Update product_serial table - FIXED: Convert to array properly
        $productSerialData = [
            'status' => isset($data['status']) && $data['status'] === 'Registered' ? 'Activated' : ($data['status'] ?? null),
            're_seller' => $data['re_seller'] ?? null,
            'product_code' => $data['product_code'] ?? null,
            'mac_address_0' => $data['mac_address_0'] ?? null,
        ];

        if ($updateTimestamp) {
            $productSerialData['updated'] = time();
        }

        // Remove null values but keep empty strings - FIXED: Use proper filtering
        $productSerialData = array_filter($productSerialData, function($value) {
            return $value !== null;
        });

        // FIXED: Ensure we have data to update
        if (!empty($productSerialData)) {
            DB::table('product_serial')
                ->where('slno', $id)
                ->update($productSerialData);
        }

        // Update or insert into product_serial_parent_child - FIXED: Convert to array properly
        $parentChildData = [
            'site_name' => $data['site_name'] ?? null,
            'installed_by' => $data['installed_by'] ?? null,
            'parent_slno' => $data['parent_slno'] ?? null,
            's1_ip' => $data['s1_ip'] ?? null,
            's2_ip' => $data['s2_ip'] ?? null,
        ];

        if ($updateTimestamp) {
            $parentChildData['updated'] = time();
        }

        // Remove null values but keep empty strings
        $parentChildData = array_filter($parentChildData, function($value) {
            return $value !== null;
        });

        // FIXED: Ensure we have data to update/insert
        if (!empty($parentChildData)) {
            $exists = DB::table('product_serial_parent_child')->where('slno', $id)->exists();
            
            if ($exists) {
                DB::table('product_serial_parent_child')
                    ->where('slno', $id)
                    ->update($parentChildData);
            } else {
                $parentChildData['slno'] = $id;
                DB::table('product_serial_parent_child')->insert($parentChildData);
            }
        }

        // CRITICAL: Update infinity_list table with ALL required fields
        $infinityDetails = DB::table('infinity_list')->where('slnoc', $id)->first();
        
        // Prepare data for infinity_list with proper default values
        $infinityData = [
            'uid' => auth()->id() ?? 1,
            'reseller' => $data['re_seller'] ?? '',
            'slnoc' => $id,
            'mac_address' => $data['mac_address_0'] ?? '',
            's1_ip_address' => $data['s1_ip'] ?? '',
            's1_default_port' => 7000, // Default value
            's1_retry_port' => 1, // Default value
            's2_default_port' => 7000, // Default value
            's2_retry_port' => 1, // Default value
            's2_ip_address' => $data['s2_ip'] ?? '',
            'phone_type' => $data['product_code'] ?? '',
            'parent_slnoc' => $data['parent_slno'] ?? '',
            
            // Required fields with default values
            'firmware_upgrade' => 'Monthly',
            'firmware_server_path' => '',
            'configuration_server_path' => '',
            'admin_pass' => '',
            'wan_port_active' => 'OFF',
            'wan_port_vid' => '',
            'wan_port_priority' => '',
            'pc_port_active' => 'OFF',
            'pc_port_vid' => '',
            'dhcp_vlan_active' => 'OFF',
            'auto_upgrade' => 'OFF',
            'upgrade_exp_rom' => 'OFF',
            'check_upgrade_times' => 1,
            'screansaver_server_url' => '',
            'wallpaper_server_url' => '',
            'wifi_node' => 'OFF',
            'wifi_active' => 'OFF',
            'wifi_security_mode' => '',
            'wifi_ssid' => '',
            'wifi_password' => '',
            'activation_date' => '',
            'expiry_date' => '',
            'firmware_server_path_enable' => 0,
            'configuration_server_path_enable' => 0,
            'screansaver_server_url_enable' => 0,
            'wallpaper_server_url_enable' => 0,
            'auto_upgrade_enable' => 0,
            'wifi_password_enable' => 0,
            'updated' => time(),
        ];

        // If record exists in infinity_list, update it
        if ($infinityDetails) {
            \Log::info('Updating existing infinity_list record for: ' . $id);
            DB::table('infinity_list')
                ->where('slnoc', $id)
                ->update($infinityData);
        } else {
            // Insert new record in infinity_list
            \Log::info('Inserting new infinity_list record for: ' . $id);
            $infinityData['created'] = time();
            
            // Try to get additional data from product_serial if available
            $productSerial = DB::table('product_serial')->where('slno', $id)->first();
            if ($productSerial) {
                if (empty($infinityData['mac_address'])) {
                    $infinityData['mac_address'] = $productSerial->mac_address_0;
                }
                if (empty($infinityData['phone_type'])) {
                    $infinityData['phone_type'] = $productSerial->product_code;
                }
                if (empty($infinityData['reseller'])) {
                    $infinityData['reseller'] = $productSerial->re_seller;
                }
            }

            // Get parent serial number if available
            $productSerialChild = DB::table('product_serial_child')->where('slno', $id)->first();
            if ($productSerialChild && empty($infinityData['parent_slnoc'])) {
                $infinityData['parent_slnoc'] = $productSerialChild->assigned_to_parent ?? '';
            }

            DB::table('infinity_list')->insert($infinityData);
        }

        DB::commit();

        \Log::info('Successfully updated record for: ' . $id);
        return ['success' => true, 'message' => 'Record updated successfully'];

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Update failed for ID ' . $id . ': ' . $e->getMessage());
        \Log::error('Stack trace: ', ['exception' => $e]);
        throw $e;
    }
}

    public function deleteRecord($id)
    {
        try {
            DB::beginTransaction();

            DB::table('product_serial_parent_child')->where('slno', $id)->delete();
            DB::table('product_serial_child')->where('slno', $id)->delete();
            DB::table('infinity_list')->where('slnoc', $id)->delete();

            $deleted = DB::table('product_serial')->where('slno', $id)->delete();

            if (!$deleted) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            DB::commit();

            return response()->json(['success' => 'Record deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Delete failed: ' . $e->getMessage()], 500);
        }
    }

    public function deleteMultiple(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json(['error' => 'No records selected'], 400);
            }

            DB::beginTransaction();

            DB::table('product_serial_parent_child')->whereIn('slno', $ids)->delete();
            DB::table('product_serial_child')->whereIn('slno', $ids)->delete();
            DB::table('infinity_list')->whereIn('slnoc', $ids)->delete();

            $deletedCount = DB::table('product_serial')->whereIn('slno', $ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} records deleted successfully"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Delete failed: ' . $e->getMessage()], 500);
        }
    }
}