<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvisioningController extends Controller
{
    public function index()
    {
        return view('provisioning.index');
    }
    public function infinity7()
    {
        return view('provisioning.infinity7xxx.index');
    }
    public function infinity7_details($slno)
    {
        return view('provisioning.infinity7xxx.details');
    }
}
