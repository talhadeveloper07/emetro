<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;


class SipPhoneController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('provisioning.sip_phones.index',compact('organizations'));
    }
}
