<?php

namespace App\Http\Controllers;

use App\Imports\OdrDetailImport;
use App\Imports\OdrHardwareImport;
use App\Imports\OdrHeaderImport;
use App\Imports\OrgDocImport;
use App\Imports\OrgImport;
use App\Imports\OrgNotificationImport;
use App\Imports\OrgUserImport;
use App\Models\OldProductDiscountMapping;
use App\Models\Organization;
use App\Models\OrganizationHwFulfillment;
use App\Models\OrganizationSetting;
use App\Models\OrganizationSwFulfillment;
use App\Models\PriceRegion;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function index(){
        return view('import.index');
    }
    public function importProduct(Request $request)
    {
        // Validate the uploaded file
        $validated = $request->validate([
            'csv_product' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_product');
//        dd($file->getPathname());
        try {
            $fileHandle = fopen($file->getPathname(), 'r');
            if (!$fileHandle) {
                throw new \Exception('Failed to open the uploaded CSV file.');
            }

            $header = null;

            $priceRegions = PriceRegion::all()->keyBy('id');

            while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                    continue;
                }

                $record = array_combine($header, $row);
                if (!$record) {
                    continue;
                }
//                dd($record);
                // Prepare product data
                $productData = [
                    'product_code' => $record['field_product_code'],
                    'sort_order' => $record['field_sort_order'],
                    'title' => $record['field_small_title_product'],
                    'small_title' => "",
                    'description' => $record['title'],
                    'additional_information' => $record['body'],
                    'product_type' => $record['field_product_type'],
                    'product_sub_type' => $record['field_product_sub_type'],
                    'image' => null,
                    'sw_subscription_per_year_p' => $record['field_sw_subscription_per_year_p'] ?: null,
                    'sw_subscription_per_month_p' => $record['field_sw_subscription_per_month_p'] ?: null,
                    'hw_warranty_per_year_price' => $record['field_hw_warranty_per_year_price'] ?: null,
                    'assurance_renewal' => 'yes',
                    'discount_category_id' => null,
                    'vendor_id' => Vendor::firstOrCreate(['name' => $record['field_vendor']])->id,
                    'inventory_location' => $record['field_inventory_location'],
                    'inventory_count' => $record['field_inventory_count'] ?: null,
                    'shipping_cost' => $record['field_shipping_cost'] ?: null,
                    'product_unit_cost' => $record['field_product_unit_cost'] ?: null,
                ];

                $product = Product::updateOrCreate(
                    ['product_code' => $record['field_product_code']],
                    $productData
                );

                // Handle price and availability per region
                $priceFields = [
                    'field_product_price_1' => 1,
                    'field_product_price_2' => 2,
                    'field_product_price_3' => 3,
                    'field_product_price_4' => 4,
                    'field_product_price_5' => 5,
                    'field_product_price_6' => 6,
                ];
                $etaFields = [
                    'field_price_1_eta' => 1,
                    'field_price_2_eta' => 2,
                    'field_price_3_eta' => 3,
                    'field_price_4_eta' => 4,
                    'field_price_5_eta' => 5,
                    'field_price_6_eta' => 6,
                ];

                foreach ($priceFields as $priceField => $regionId) {
                    $price = isset($record[$priceField]) && $record[$priceField] !== '' ? floatval(str_replace(',', '', $record[$priceField])) : null;
                    $etaKey = array_search($regionId, $etaFields);
                    $eta = isset($record[$etaKey]) && $record[$etaKey] !== '' ? date('Y-m-d', strtotime($record[$etaKey])) : null;

                    if ($price !== null || $eta !== null) {
                        ProductPrice::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'price_region_id' => $regionId,
                            ],
                            [
                                'price' => $price,
                                'availability' => $eta,
                            ]
                        );
                    }
                }
            }

            fclose($fileHandle);

            return back()->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOrg(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'csv_org' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('csv_org');
            $fileName = 'orgs_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            Excel::import(new OrgImport(), $fullPath);
// Clean up the file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            return back()->with('success', 'Organizations imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOrgUser(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'org_user' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('org_user');
            $fileName = 'org_user_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

//            Excel::import(new OrgUserImport(), $fullPath);
            Excel::queueImport(new OrgUserImport, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);
            return back()->with('success', 'Organizations Users import is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOrgDoc(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'org_doc' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('org_doc');
            $fileName = 'org_doc_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            Excel::import(new OrgDocImport(), $fullPath);
// Clean up the file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            return back()->with('success', 'Organizations Documents imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOrgNotification(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'org_notification' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $file = $request->file('org_notification');
            $fileName = 'org_notification_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $uploadDir . '/' . $fileName;

            $file->move($uploadDir, $fileName);

            if (!file_exists($filePath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            Excel::queueImport(new OrgNotificationImport, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);

            return back()->with('success', 'File is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOrgSetting(Request $request){
        $request->validate([
            'org_setting' => 'required|file|mimes:csv', // Max 10MB
        ]);

        try {
            $file = $request->file('org_setting');
            $csvData = array_map('str_getcsv', file($file->getPathname()));
//            $fileHandle = fopen($file->getPathname(), 'r');

            $headers = array_shift($csvData);

            foreach ($csvData as $row) {
                try {
                    $data = array_combine($headers, $row);

                    // Prepare organization settings data
                    $orgData = [
                        'org_nid' => (int) $data['NID'],
                        'is_paypal' => strpos($data['Payment Options'], 'PayPal') !== false,
                        'is_stripe' => strpos($data['Payment Options'], 'Stripe') !== false,
                        'is_emtpay' => strpos($data['Payment Options'], 'EmtPay') !== false,
                        'is_term' => strpos($data['Payment Options'], 'Term') !== false,
                        'is_create_order' => strpos($data['Payment Options'], 'Create Order') !== false,
                        'is_emtpay_topup' => $data['EMTPay TopUp'] === 'Yes',
                        'save_credit_card' => $data['Save Credit Card'] === 'Yes',
                        'monthly_bill_auto_payment' => $data['Monthly bill auto credit card payment'] === 'Yes',
                        'annual_bill_auto_payment' => $data['Annual bill auto credit card payment'] === 'Yes',
                        'payment_terms_credit_limit' => $data['Payment Terms Credit Limit'] ? (float) $data['Payment Terms Credit Limit'] : null,
                    ];
//                dd($orgData);
                    // Insert or update organization settings
                    $org = OrganizationSetting::updateOrCreate(
                        ['org_nid' => $orgData['org_nid']],
                        $orgData
                    );

                    // Handle HW Fulfillment (JSON array)
                    if ($data['SW/Services Fulfillment'] && $data['SW/Services Fulfillment'] !== 'null') {
                        OrganizationSwFulfillment::create([
                            'org_nid' => $org->org_nid,
                            'sw_fulfillment_nid' => $data['SW/Services Fulfillment'] ? (int) $data['SW/Services Fulfillment'] : null,
                        ]);
                    }
                    // Handle HW Fulfillment (JSON array)
                    if ($data['HW Fulfillment'] && $data['HW Fulfillment'] !== 'null') {
                        $hwFulfillments = json_decode($data['HW Fulfillment'], true);
                        if (is_array($hwFulfillments)) {
                            foreach ($hwFulfillments as $fulfillment) {
                                if (isset($fulfillment['nid'])) {
                                    OrganizationHwFulfillment::create([
                                        'org_nid' => $org->org_nid,
                                        'hw_fulfillment_nid' => (int) $fulfillment['nid'],
                                    ]);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    dd($e->getMessage());
                    continue;
                }
            }

            return back()->with('success', 'CSV imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import CSV: ' . $e->getMessage());
        }
    }
    public function importOdrHeader(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'odr_header' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('odr_header');
            $fileName = 'odr_header_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            /*Excel::import(new OdrHeaderImport(), $fullPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }*/
            Excel::queueImport(new OdrHeaderImport, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);

            return back()->with('success', 'Order Header import is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOdrDetails(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'odr_details' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('odr_details');
            $fileName = 'odr_details_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

//            Excel::import(new OdrDetailImport(), $fullPath);
//            if (file_exists($fullPath)) {
//                unlink($fullPath);
//            }
            Excel::queueImport(new OdrDetailImport, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);

            return back()->with('success', 'Order Header import is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOdrHardware(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'odr_hardware' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('odr_hardware');
            $fileName = 'odr_hardware_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            /*Excel::import(new OdrHardwareImport(), $fullPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }*/
            Excel::queueImport(new OdrHardwareImport, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);

            return back()->with('success', 'Order Hardware import is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function importOldProductDiscount(Request $request)
    {
        $validated = $request->validate([
//            'csv_org' => 'required|file|mimes:csv,txt',
            'old_product_discount' => 'required|file|mimes:xlsx,xls', // update validation

        ]);

//        $file = $request->file('csv_org');

        try {
            $uploadDir = public_path('uploaded');

            // Create the uploaded folder if it doesn't exist
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Get the file and generate a unique filename
            $file = $request->file('old_product_discount');
            $fileName = 'old_product_discount_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploaded/' . $fileName;
            $fullPath = public_path($filePath);

            // Move the file to public/uploaded
            $file->move($uploadDir, $fileName);
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Failed to store the uploaded file.');
            }

            /*Excel::import(new OdrHardwareImport(), $fullPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }*/
            Excel::queueImport(new \App\Imports\OldProductDiscountMapping, $filePath)
                ->chain([
                    function () use ($filePath) {
                        if (file_exists($filePath)) {
                            unlink($filePath); // Clean up
                        }
                    }
                ]);

            return back()->with('success', 'Old product discount mapping import is being processed in the background.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

}
