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
    
        // -------------------------
        // Apply Filters
        // -------------------------
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
    
        // -------------------------
        // Fetch Records
        // -------------------------
        $records = $query
            ->select($columns)
            ->orderBy($orderColumnName, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();
    
        // -------------------------
        // Format for DataTables
        // -------------------------
        $data = [];
        foreach ($records as $row) {
            $assignedParent = DB::table('product_serial_child')
                ->where('slno', $row->slno)
                ->value('assigned_to_parent');
    
            $nested = [];
            $nested['checkbox'] = "<input type='checkbox' value='{$row->slno}'>";
            $nested['slno'] = $row->slno;
            $nested['status'] = $row->status === "Activated" ? "Registered" : $row->status;
            $nested['re_seller'] = $row->re_seller;
            $nested['product_code'] = $row->product_code;
            $nested['site_name'] = $row->site_name;
            $nested['installed_by'] = $row->installed_by;
            $nested['mac_address_0'] = $row->mac_address_0;
            $nested['updated'] = $row->updated ? date("m/d/Y", $row->updated) : null;
    
            // ✅ Show parent SLNO if exists
            $nested['parent_slno'] = $assignedParent ?? null;
    
            $data[] = $nested;
        }
    
        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        ]);
    }
    
    
}
