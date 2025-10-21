<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Template;
use App\Models\Mac;

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
                    <a href="' . asset(str_replace('public://', 'storage/', $item->file_location)) . '" 
                       class="btn btn-sm btn-icon btn-primary" 
                       title="Download Template" 
                       download>
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
    $macs = Mac::select(
        'id',
        'mac as mac_name',
        'vendor',
        'model',
        'template_name',
        're_seller',
        'modified_date'
    )->get();

    $data = $macs->map(function ($item) {
        return [
            'checkbox' => '<input type="checkbox" class="record-checkbox" value="'.$item->id.'">',
            'id' => $item->id,
            'mac_name' => $item->mac_name,
            'vendor' => $item->vendor,
            'model' => $item->model,
            'template_name' => $item->template_name,
            're_seller' => $item->re_seller,
            'modified_date' => $item->modified_date,
        ];
    });

    // ✅ Return correct JSON for DataTables
    return response()->json(['data' => $data]);
}

}
