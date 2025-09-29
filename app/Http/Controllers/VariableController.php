<?php

namespace App\Http\Controllers;

use App\Models\Variable;
use Illuminate\Http\Request;
use App\Traits\PhoneCodesTrait;


class VariableController extends Controller
{
    use PhoneCodesTrait;

    public function create()
    {
        return view('variable.create');
    }

    public function store(Request $request)
    {
        // Convert comma-separated input into array
        $value = explode(',', $request->value);

        Variable::create([
            'name' => $request->name,
            'value' => $value, // will be automatically serialized
        ]);
    
        return redirect()->back()->with('success', 'Variable saved!');
    }
    
}
