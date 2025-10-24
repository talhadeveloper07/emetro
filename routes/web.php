<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvisioningController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SerialRecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ProvisioningInfinity3065Controller;
use App\Http\Controllers\ProvisioningInfinity5xxxController;
use App\Models\ProvisioningInfinity3065;
use App\Http\Controllers\VariableController;
use App\Http\Controllers\DectProvisioningController;
use App\Http\Controllers\DectExtensionController;
use App\Http\Controllers\SipPhoneController;


Route::get('test', function () {
    dd(123);

});

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/import-discount-data', function () {
    $organizations = \App\Models\Organization::all();
    $discounts = \App\Models\Discount::all();
    foreach ($organizations as $organization) {
        foreach ($discounts as $discount) {
            $exists = \Illuminate\Support\Facades\DB::table('discount_organization')
                ->where('organization_id', $organization->id)
                ->where('discount_id', $discount->id)
                ->exists();

            if (!$exists) {

                $discount_amount = $discount->amount;
                $is_custom = false;
                if (in_array($organization->org_type, ['Customer', 'End Customer', 'End Customer 2'])) {
                    $discount_amount=0;
                    $is_custom=true;
                }
                \Illuminate\Support\Facades\DB::table('discount_organization')->insert([
                    'discount_id' => $discount->id,
                    'organization_id' => $organization->id,
                    'custom_amount' => $discount_amount,
                    'is_custom'=>$is_custom,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    dd('Discount Data imported Successfully');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => true, // Email Verification Routes...
]);
Route::get('/clear-session', function () {
    \Illuminate\Support\Facades\Session::flush(); // Clears all session data
    return back()->with('success', 'Session cleared successfully!');
});
Route::group(['prefix' => '2fa', 'as' => '2fa.'], function () {
    Route::get('/', [TwoFactorController::class, 'show'])->name('verify');
    Route::post('/', [TwoFactorController::class, 'verify'])->name('verify.post');
    Route::post('/resend', [TwoFactorController::class, 'resend'])->name('resend')->middleware('throttle:3,10,2fa_resend');
});

Route::middleware(['auth','2fa'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
        Route::get('/', [ImportDataController::class, 'index'])->name('index');
        Route::post('/product', [ImportDataController::class, 'importProduct'])->name('product');
        Route::post('/org', [ImportDataController::class, 'importOrg'])->name('org');
        Route::post('/org_user', [ImportDataController::class, 'importOrgUser'])->name('org_user');
        Route::post('/org_doc', [ImportDataController::class, 'importOrgDoc'])->name('org_doc');
        Route::post('/org_notification', [ImportDataController::class, 'importOrgNotification'])->name('org_notification');
        Route::post('/org_setting', [ImportDataController::class, 'importOrgSetting'])->name('org_setting');
        Route::post('/odr_header', [ImportDataController::class, 'importOdrHeader'])->name('odr_header');
        Route::post('/odr_details', [ImportDataController::class, 'importOdrDetails'])->name('odr_details');
        Route::post('/odr_hardware', [ImportDataController::class, 'importOdrHardware'])->name('odr_hardware');
        Route::post('/old_product_discount', [ImportDataController::class, 'importOldProductDiscount'])->name('old_product_discount');
    });


    Route::group(['prefix' => 'records', 'as' => 'records.'], function () {
        Route::get('/', [SerialRecordController::class, 'index'])->name('index');
        Route::get('/details/{slno}', [SerialRecordController::class, 'details'])->name('details');
        Route::post('/details/{slno}', [SerialRecordController::class, 'saveDetails'])->name('save_details');
        Route::get('/customer-information/{slno}', [SerialRecordController::class, 'customerInformation'])->name('customer_information');
        Route::post('/customer-information/{slno}', [SerialRecordController::class, 'saveCustomerInformation'])->name('save_customer_information');
        Route::get('/sip-trunks/{slno}', [SerialRecordController::class, 'sipTrunks'])->name('sip_trunks');
        Route::get('/inventory/{slno}', [SerialRecordController::class, 'inventory'])->name('inventory');
        Route::get('/history/{slno}', [SerialRecordController::class, 'history'])->name('history');
        Route::get('/notes/{slno}', [SerialRecordController::class, 'notes'])->name('notes');
        Route::post('/records/{slno}/retired-hosts', [SerialRecordController::class, 'saveRetiredHosts'])->name('save_retired_hosts');
        Route::post('/records/{slno}/notes', [SerialRecordController::class, 'saveNote'])->name('save_note');
        Route::delete('/records/{slno}/notes/{note}', [SerialRecordController::class, 'deleteNote'])->name('delete_note');

        Route::get('/backup/{slno}', [SerialRecordController::class, 'backup'])->name('backup');
    });
    Route::group(['prefix' => 'order-status', 'as' => 'order_status.'], function () {
        Route::get('/', [AdminController::class, 'orderStatus'])->name('index');
        Route::get('/details/{id}', [AdminController::class, 'orderStatusDetails'])->name('details');
    });
    Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/details/{id}', [InvoiceController::class, 'details'])->name('details');
        Route::get('/order_details/{id}', [InvoiceController::class, 'order_details'])->name('order_details');
        Route::get('/thankyou/{id}', [InvoiceController::class, 'thankyou'])->name('thankyou');
    });
    Route::group(['prefix' => 'organizations', 'as' => 'org.'], function () {
        Route::get('/', [OrganizationController::class, 'index'])->name('index');
        Route::get('/{id}/summary', [OrganizationController::class, 'summary'])->name('summary');
        Route::post('/{id}/summary_update', [OrganizationController::class, 'summary_update'])->name('summary_update');
        Route::get('/{id}/details', [OrganizationController::class, 'details'])->name('details');
        Route::post('/{id}/details_update', [OrganizationController::class, 'details_update'])->name('details_update');
        Route::get('/{id}/contacts', [OrganizationController::class, 'contacts'])->name('contacts');
        Route::get('/{id}/document', [OrganizationController::class, 'document'])->name('document');
        Route::post('/{id}/document/upload', [OrganizationController::class, 'documentSave'])->name('document.save');
        Route::post('/document/update-status', [OrganizationController::class, 'documentUpdateStatus'])->name('document.updateStatus');
        Route::get('/{id}/notes', [OrganizationController::class, 'notes'])->name('notes');
        Route::get('/{id}/notifications', [OrganizationController::class, 'notifications'])->name('notifications');
        Route::post('/save-notes/{id}', [OrganizationController::class, 'saveNotes'])->name('notes.save');
    });

    Route::group(['prefix' => 'emetrotel-admin', 'as' => 'e_admin.'], function () {
        Route::get('/', [AdminController::class, 'eMetroTelAdmin'])->name('index');
        //Commercials Routes
        Route::get('/commercials', [AdminController::class, 'commercialsIndex'])->name('commercials.index');
        Route::group(['prefix' => 'payment-terms', 'as' => 'payment_terms.'], function () {
            Route::get('/', [AdminController::class, 'paymentTerms'])->name('index');
            Route::post('/store', [AdminController::class, 'paymentTermsStore'])->name('store');
            Route::delete('/delete/{id}', [AdminController::class, 'paymentTermsDelete'])->name('delete');
        });
        Route::group(['prefix' => 'discount-management', 'as' => 'discount_management.'], function () {
            Route::get('/', [AdminController::class, 'discountManagement'])->name('index');
            Route::post('/store', [AdminController::class, 'discountManagementStore'])->name('store');
            Route::post('/update/{id}', [AdminController::class, 'discountManagementUpdate'])->name('update');
            Route::delete('/delete/{id}', [AdminController::class, 'discountManagementDelete'])->name('delete');
        });
        Route::group(['prefix' => 'product-management', 'as' => 'product_management.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
                Route::get('/', [ProductController::class, 'productIndex'])->name('index');
                Route::get('/create', [ProductController::class, 'createProduct'])->name('create');
                Route::get('/edit/{id}', [ProductController::class, 'editProduct'])->name('edit');
                Route::post('/store', [ProductController::class, 'storeProduct'])->name('store');
                Route::put('/update/{id}', [ProductController::class, 'updateProduct'])->name('update');
                Route::delete('/{id}/delete', [ProductController::class, 'deleteProduct'])->name('delete');
                Route::get('/linkable', [ProductController::class, 'getLinkableProducts'])->name('linkable');
                Route::get('/download', [ProductController::class, 'downloadProduct'])->name('download');

            });
            Route::group(['prefix' => 'vendors', 'as' => 'vendors.'], function () {
                Route::get('/', [ProductController::class, 'vendorIndex'])->name('index');
                Route::post('/store', [ProductController::class, 'vendorStore'])->name('store');
                Route::post('/update/{id}', [ProductController::class, 'vendorUpdate'])->name('update');
                Route::delete('/delete/{id}', [ProductController::class, 'vendorDelete'])->name('delete');
            });
        });
        //Sales Routes
        Route::get('/sales', [AdminController::class, 'salesIndex'])->name('sales.index');

        //Marketing Routes
        Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing.index');
        Route::get('/marketing/create', [MarketingController::class, 'create'])->name('marketing.create');
        Route::post('/marketing', [MarketingController::class, 'store'])->name('marketing.store');
        Route::get('/marketing/{id}/edit', [MarketingController::class, 'edit'])->name('marketing.edit');
        Route::put('/marketing/{id}', [MarketingController::class, 'update'])->name('marketing.update');
        Route::delete('/marketing/{id}', [MarketingController::class, 'destroy'])->name('marketing.destroy');
        // Individual type pages
        Route::get('/marketing/logos', [MarketingController::class, 'logos'])->name('marketing.logos');
        Route::get('/marketing/brochures', [MarketingController::class, 'brochures'])->name('marketing.brochures');
        Route::get('/marketing/images', [MarketingController::class, 'images'])->name('marketing.images');
        Route::get('/marketing/videos', [MarketingController::class, 'videos'])->name('marketing.videos');
        Route::get('/marketing/product-presentations', [MarketingController::class, 'presentations'])->name('marketing.presentations');

        //Inventory Routes
        Route::get('/inventory', [AdminController::class, 'inventoryIndex'])->name('inventory.index');
        //Admin Routes
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('/', [AdminController::class, 'adminIndex'])->name('index');
            Route::get('/settings', [AdminController::class, 'adminSettingIndex'])->name('settings');
        });

    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
    });
    Route::group(['prefix' => 'registration', 'as' => 'registration.'], function () {
        Route::get('/', [AdminController::class, 'registrationIndex'])->name('index');
    });
    Route::group(['prefix' => 'service_change', 'as' => 'service_change.'], function () {
        Route::get('/', [AdminController::class, 'serviceChangeIndex'])->name('index');
    });
    Route::group(['prefix' => 'provisioning', 'as' => 'provisioning.'], function () {



        // // Infinity 5xxx Routes
        // Route::get('/infinity5xxx', [ProvisioningInfinity5xxxController::class, 'infinity5'])->name('infinity5');
        // Route::get('/infinity5xxx/data', [ProvisioningInfinity5xxxController::class, 'getData'])->name('infinity5xxx.data');

          Route::get('/infinity5xxx', [ProvisioningInfinity5xxxController::class, 'infinity5'])->name('infinity5');
    Route::get('/infinity5xxx/data', [ProvisioningInfinity5xxxController::class, 'getData'])->name('infinity5xxx.data');
    
    // New routes for edit/delete functionality
    Route::get('/infinity5xxx/{id}/get', [ProvisioningInfinity5xxxController::class, 'getRecord'])->name('infinity5xxx.get');
    Route::put('/infinity5xxx/{id}/update', [ProvisioningInfinity5xxxController::class, 'updateRecord'])->name('infinity5xxx.update');
    Route::delete('/infinity5xxx/{id}/delete', [ProvisioningInfinity5xxxController::class, 'deleteRecord'])->name('infinity5xxx.delete');
    // Multiple records operations
    Route::get('/infinity5xxx/get-multiple', [ProvisioningInfinity5xxxController::class, 'getMultipleRecords'])->name('infinity5xxx.get.multiple');
    Route::put('/infinity5xxx/update-multiple', [ProvisioningInfinity5xxxController::class, 'updateMultipleRecords'])->name('infinity5xxx.update.multiple');
    Route::delete('/infinity5xxx/delete-multiple', [ProvisioningInfinity5xxxController::class, 'deleteMultiple'])->name('infinity5xxx.delete.multiple');
    Route::get('/', [ProvisioningController::class, 'index'])->name('index');

    Route::get('/provisioning/infinity5xxx/child/{id}', [ProvisioningInfinity5xxxController::class, 'show_details'])
    ->name('infinity5xxx.show');

    Route::get('provisioning/infinity5xxx/download/{slno}', [ProvisioningInfinity5xxxController::class, 'download'])
     ->name('infinity5xxx.download');




    Route::get('/infinity7xxx', [ProvisioningController::class, 'infinity7'])->name('infinity7');
    Route::get('/infinity7xxx/details/{slno}', [ProvisioningController::class, 'infinity7_details'])->name('infinity7_details');

    Route::get('/infinity3065', [ProvisioningInfinity3065Controller::class, 'index'])->name('infinity3065');
    Route::get('/infinity3065/data', [ProvisioningInfinity3065Controller::class, 'getData'])->name('infinity3065.data');
    Route::post('/infinity3065/store', [ProvisioningInfinity3065Controller::class, 'store'])->name('infinity3065.store');

    Route::get('/infinity3065/{slno}', [ProvisioningInfinity3065Controller::class, 'show'])->name('infinity3065.show');
    Route::get('/infinity3065/edit/{slno}', [ProvisioningInfinity3065Controller::class, 'edit'])->name('infinity3065.edit');
    Route::post('/infinity3065/update/{id}', [ProvisioningInfinity3065Controller::class, 'update'])->name('infinity3065.update');
    Route::post('/infinity3065/delete', [ProvisioningInfinity3065Controller::class, 'destroy'])->name('infinity3065.delete');
    Route::post('/infinity3065/bulk-delete', [ProvisioningInfinity3065Controller::class, 'bulkDelete'])->name('infinity3065.bulkDelete');
    Route::get('/infinity3065/export', [ProvisioningInfinity3065Controller::class, 'export'])->name('infinity3065.export');
    Route::get('/get-serials', [ProvisioningInfinity3065Controller::class, 'getSerials'])->name('serials.get');

    // Dect Provisioning

    Route::get('/dect',[DectProvisioningController::class,'index'])->name('dect');
    Route::post('/dect/push-multiple', [DectProvisioningController::class, 'pushMultiple'])->name('dect.pushMultiple');
    Route::post('/dect/store', [DectProvisioningController::class, 'store'])->name('dect.store');
    Route::post('/dect/bulk-delete', [DectProvisioningController::class, 'bulkDelete'])->name('dect.bulkDelete');
    Route::get('/dect/dect-details/{id}', [DectProvisioningController::class, 'dect_details'])->name('dect.details');
    Route::post('/dect/update/{id}', [DectProvisioningController::class, 'update'])->name('dect.update');
    Route::post('/import-extensions', [DectExtensionController::class, 'import'])->name('extensions.import');
    Route::post('/dect/update-extension-index', [DectProvisioningController::class, 'updateDectExtensionIndex'])
    ->name('dect.updateExtensionIndex');
    Route::post('/dect/delete-extensions', [DectProvisioningController::class, 'deleteExtensions'])
    ->name('dect.deleteExtensions');

     // SIP Phones

     Route::get('/templates',[SipPhoneController::class,'index'])->name('templates');
     Route::get('/templates/data', [SipPhoneController::class, 'getTemplatesData'])->name('templates.data');
     Route::post('/templates/store', [SipPhoneController::class, 'template_store'])->name('templates.store');
     Route::post('/templates/bulk-delete', [SipPhoneController::class, 'bulk_template_delete'])->name('templates.bulkDelete');
     Route::get('/templates/download/{id}', [SipPhoneController::class, 'download_template'])->name('templates.download');
     Route::get('/get-models/{vendor}', [SipPhoneController::class, 'getModelsByVendor']);
     Route::get('/mac',[SipPhoneController::class,'mac_index'])->name('mac');
     Route::get('/mac/data', [SipPhoneController::class, 'getMacData'])->name('mac.data');
     Route::post('/mac/update-template', [SipPhoneController::class, 'update_mac_template'])
    ->name('mac.updateTemplate');
    Route::post('/mac/bulk-delete', [SipPhoneController::class, 'mac_bulk_delete'])->name('mac.bulkDelete');
    Route::post('/mac/store', [SipPhoneController::class, 'store_mac'])->name('mac.store');
     Route::get('/extensions',[SipPhoneController::class,'extension_index'])->name('extensions');
     Route::get('/extensions/data', [SipPhoneController::class, 'getExtensions'])->name('extensions.data');
     Route::get('/extensions/mac-details/{macId}', [SipPhoneController::class, 'getMacDetails'])
    ->name('extensions.macDetails');
    Route::post('/extensions/update-mac', [SipPhoneController::class, 'update_mac'])
    ->name('extensions.updateMac');









    // ✅ Live XML Route
    Route::get('/softphones-xml', function () {
        $records = ProvisioningInfinity3065::all();

        $xml = new \SimpleXMLElement('<softphones/>');

        foreach ($records as $record) {
            $phone = $xml->addChild('softphone');
            $phone->addChild('slno', $record->slno);
            $phone->addChild('device_id', $record->device_id);
            $phone->addChild('first_name', $record->first_name);
            $phone->addChild('last_name', $record->last_name);
            $phone->addChild('extension', $record->extension);
            $phone->addChild('email', $record->email);
            $phone->addChild('mobile', $record->mobile);
            $phone->addChild('device_type', $record->device_type);
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    })->name('softphones.xml');
        Route::get('/softphones-xml', [ProvisioningInfinity3065Controller::class, 'xmlFeed'])->name('softphones.xml');


Route::get('/provisioning/download-xml/{slno}', [ProvisioningInfinity3065Controller::class, 'downloadXml'])->name('provisioning.download.xml');


});
    Route::get('/countries', [LocationController::class, 'getCountries'])->name('getCountries');
    Route::get('/states/{countryCode}', [LocationController::class, 'getStates'])->name('getStates');
    Route::get('/currencies/{countryCode}', [LocationController::class, 'getCurrencies'])->name('getCurrencies');
    Route::get('/cities/{countryCode}/{stateCode}', [LocationController::class, 'getCities'])->name('getCities');

    Route::get('/variables/create', [VariableController::class, 'create'])->name('variables.create');
    Route::post('/variables', [VariableController::class, 'store'])->name('variables.store');

});