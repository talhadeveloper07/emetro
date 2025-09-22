<?php

namespace App\Http\Controllers;

use App\Models\OrderHeader;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $all_orgs = Organization::select('id', 'name')->get();
        $invoices=OrderHeader::with('org')
            ->orderBy('id', 'desc')
            ->paginate(env('APP_PAGINATION'))
            ->appends($request->all());
        return view('invoice.index', compact('all_orgs','invoices'));
    }
    public function details($id)
    {
        $invoice=OrderHeader::with('org','details.product')->findOrFail($id);
        return view('invoice.details',compact('invoice'));
    }
    public function order_details($id)
    {
        $invoice=OrderHeader::with('org','details.product')->findOrFail($id);
        return view('invoice.order_details',compact('invoice'));
    }
    public function thankyou($id)
    {
        $invoice=OrderHeader::with('org','details.product')->findOrFail($id);
        return view('invoice.thankyou_page',compact('invoice'));
    }

}
