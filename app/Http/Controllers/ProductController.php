<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Discount;
use App\Models\PriceRegion;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(){
        return view('admin.product_management.index');
    }
    public function productIndex(Request $request){
//        dd($request->all());
        $discounts=Discount::all();
        $vendors=Vendor::all();
        $products=$this->productFilters($request)->paginate(env('APP_PAGINATION'))->appends($request->all());
        return view('admin.product_management.products.index',compact('products','discounts','vendors','request'));
    }
    public function downloadProduct(Request $request)
    {
        $format = $request->input('download_format');
        $products = $this->productFilters($request)->get();
        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'No product found for the selected filters.');
        }
        if ($format === 'excel') {
            return Excel::download(new ProductExport($products), 'products_' . now()->format('Ymd_His') . '.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.products', compact('products')) ->setPaper('a4', 'landscape');;
            return $pdf->download('products_' . now()->format('Ymd_His') . '.pdf');
        }
        return redirect()->back()->with('error', 'Invalid download format selected.');



    }
    protected function productFilters(Request $request)
    {
        $query = Product::with('vendor', 'discount');

        // Apply filters only if present
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('product_code')) {
            $query->where('product_code', 'like', '%' . $request->product_code . '%');
        }

        if ($request->filled('product_type')) {
            $query->where('product_type', $request->product_type);
        }

        if ($request->filled('product_sub_type')) {
            $query->where('product_sub_type', $request->product_sub_type);
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('discount_category_id')) {
            $query->where('discount_category_id', $request->discount_category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $query=$query->latest();
        return $query;
    }

    public function createProduct(){
        $discounts=Discount::all();
        $vendors=Vendor::all();
        $priceRegions = PriceRegion::all();
        return view('admin.product_management.products.create',compact('discounts','vendors','priceRegions'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|unique:products',
            'product_type' => 'required|in:Hardware,Software,Service',
            'product_sub_type' => 'nullable',
            'linked_product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image',
            'title' => 'required|string|max:20',
            'small_title' => 'nullable|string|max:20',
            'sort_order' => 'required|integer',
            'description' => 'nullable|string|max:120',
            'additional_information' => 'nullable|string|max:1024',
            'product_prices.*.price' => 'nullable|numeric',
            'product_prices.*.availability' => 'nullable|date',
            'sw_subscription_per_year_p' => 'nullable|string',
            'sw_subscription_per_month_p' => 'nullable|string',
            'hw_warranty_per_year_price' => 'nullable|string',
            'assurance_renewal' => 'nullable|in:yes,no',
            'discount_category_id' => 'nullable|exists:discounts,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'inventory_location' => 'nullable|string',
            'inventory_count' => 'nullable|integer',
            'shipping_cost' => 'nullable|numeric',
            'product_unit_cost' => 'nullable|numeric',
            'dimension_length' => 'nullable|numeric',
            'dimension_width' => 'nullable|numeric',
            'dimension_height' => 'nullable|numeric',
            'dimension_unit' => 'nullable|in:cm,in',
            'net_weight' => 'nullable|numeric',
            'gross_weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|in:lb,kg',
            'weight' => 'nullable|numeric',
            'status' => 'nullable',
            'bom.*.name' => 'nullable|string',
            'bom.*.cost' => 'nullable|numeric',
            'bom.*.tariff' => 'nullable|numeric',
            'bom.*.shipping' => 'nullable|numeric',
            'bom.*.vendor' => 'nullable|string',
            'bom.*.hts' => 'nullable|string',
            'bom.*.eccn' => 'nullable|string',
        ]);
        if (in_array($validated['product_type'], ['Hardware', 'Software'])) {
            $validated['linked_product_id'] = null;
        }
        $productPrices = $validated['product_prices'] ?? [];
        unset($validated['product_prices']);
        $boms = $validated['bom'] ?? [];
        unset($validated['bom']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $productCode = $validated['product_code'];
            $extension = $file->getClientOriginalExtension();
            $filename = str_replace(' ', '',$productCode). '-' . time() . "." . $extension;
            $file->move(public_path() . '/products/', $filename);
            // Save the path or filename in DB
            $validated['image'] = asset('products/'.$filename);
        }

        $product = Product::create($validated);

        if (!empty($productPrices)) {
            foreach ($productPrices as $priceRegionId => $priceData) {
                if (!empty($priceData['price']) || !empty($priceData['availability'])) {
                    $product->productPrices()->create([
                        'price_region_id' => $priceRegionId,
                        'price' => $priceData['price'] ?? null,
                        'availability' => $priceData['availability'] ?? null,
                    ]);
                }
            }
        }
        if (!empty($boms)) {
            foreach ($boms as $bomData) {
                if (empty($bomData['name']) && (empty($bomData['cost']) || $bomData['cost'] === null)) {
                    continue;
                }
                $product->boms()->create([
                    'name' => $bomData['name'],
                    'cost' => $bomData['cost'],
                    'tariff' => $bomData['tariff'] ?? 0,
                    'shipping' => $bomData['shipping'] ?? 0,
                    'vendor' => $bomData['vendor'] ?? null,
                    'hts' => $bomData['hts'] ?? null,
                    'eccn' => $bomData['eccn'] ?? null,
                    'total' => ($bomData['cost'] ?? 0)
                        + ((($bomData['cost'] ?? 0) * ($bomData['tariff'] ?? 0)) / 100)
                        + ($bomData['shipping'] ?? 0),
                    ]);
            }
        }

        return redirect()->route('e_admin.product_management.product.index')->with('success', 'Product created successfully.');
    }

    public function editProduct($id){
        $product = Product::with('productPrices', 'discount', 'vendor','boms','linkedServices')->findOrFail($id);
        $discounts = Discount::all();
        $vendors = Vendor::all();
        $priceRegions = PriceRegion::all();
        return view('admin.product_management.products.edit',compact('product','discounts','vendors','priceRegions'));

    }
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_code' => 'required|string|unique:products,product_code,' . $product->id,
            'product_type' => 'required|in:Hardware,Software,Service',
            'product_sub_type' => 'nullable',
            'linked_product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image',
            'title' => 'nullable|string|max:20',
            'small_title' => 'nullable|string|max:20',
            'sort_order' => 'required|integer',
            'description' => 'nullable|string|max:120',
            'additional_information' => 'nullable|string|max:1024',
            'product_prices.*.price' => 'nullable|numeric',
            'product_prices.*.availability' => 'nullable|date',
            'sw_subscription_per_year_p' => 'nullable|string',
            'sw_subscription_per_month_p' => 'nullable|string',
            'hw_warranty_per_year_price' => 'nullable|string',
            'assurance_renewal' => 'nullable|in:yes,no',
            'discount_category_id' => 'nullable|exists:discounts,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'inventory_location' => 'nullable|string',
            'inventory_count' => 'nullable|integer',
            'shipping_cost' => 'nullable|numeric',
            'product_unit_cost' => 'nullable|numeric',
            'dimension_length' => 'nullable|numeric',
            'dimension_width' => 'nullable|numeric',
            'dimension_height' => 'nullable|numeric',
            'dimension_unit' => 'nullable|in:cm,in',
            'net_weight' => 'nullable|numeric',
            'gross_weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|in:lb,kg',
            'weight' => 'nullable|numeric',
            'status' => 'nullable',
            'bom.*.name' => 'nullable|string',
            'bom.*.cost' => 'nullable|numeric',
            'bom.*.tariff' => 'nullable|numeric',
            'bom.*.shipping' => 'nullable|numeric',
            'bom.*.vendor' => 'nullable|string',
            'bom.*.hts' => 'nullable|string',
            'bom.*.eccn' => 'nullable|string',
        ]);
        if (in_array($validated['product_type'], ['Hardware', 'Software'])) {
            $validated['linked_product_id'] = null;
        }
        $productPrices = $validated['product_prices'] ?? [];
        unset($validated['product_prices']);
        $boms = $validated['bom'] ?? [];
        unset($validated['bom']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $productCode = $validated['product_code'];
            $extension = $file->getClientOriginalExtension();
            $filename = str_replace(' ', '',$productCode). '-' . time() . "." . $extension;
            $file->move(public_path() . '/products/', $filename);
            // Save the path or filename in DB
            $validated['image'] = asset('products/'.$filename);
        }

        $product->update($validated);

        if (!empty($productPrices)) {
            foreach ($productPrices as $priceRegionId => $priceData) {
                $price = $product->productPrices()->where('price_region_id', $priceRegionId)->first();
                if ($price) {
                    if (!empty($priceData['price']) || !empty($priceData['availability'])) {
                        $price->update([
                            'price' => $priceData['price'] ?? $price->price,
                            'availability' => $priceData['availability'] ?? $price->availability,
                        ]);
                    } else {
                        $price->delete();
                    }
                } elseif (!empty($priceData['price']) || !empty($priceData['availability'])) {
                    $product->productPrices()->create([
                        'price_region_id' => $priceRegionId,
                        'price' => $priceData['price'] ?? null,
                        'availability' => $priceData['availability'] ?? null,
                    ]);
                }
            }
        }

        $product->boms()->delete(); // Clear existing BOMs
        if (!empty($boms)) {
            foreach ($boms as $bomData) {
                if (empty($bomData['name']) && (empty($bomData['cost']) || $bomData['cost'] === null)) {
                    continue;
                }
                $product->boms()->create([
                    'name' => $bomData['name'],
                    'cost' => $bomData['cost'],
                    'tariff' => $bomData['tariff'] ?? 0,
                    'shipping' => $bomData['shipping'] ?? 0,
                    'vendor' => $bomData['vendor'] ?? null,
                    'hts' => $bomData['hts'] ?? null,
                    'eccn' => $bomData['eccn'] ?? null,
                    'total' => ($bomData['cost'] ?? 0)
                        + ((($bomData['cost'] ?? 0) * ($bomData['tariff'] ?? 0)) / 100)
                        + ($bomData['shipping'] ?? 0),
                    ]);
            }
        }

        return redirect()->route('e_admin.product_management.product.index')->with('success', 'Product updated successfully.');
    }
    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->productPrices()->delete();
            $product->boms()->delete();
            $product->delete();
            return redirect()->route('e_admin.product_management.product.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('e_admin.product_management.product.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    public function getLinkableProducts(Request $req)
    {
        $req->validate([
            'subtype' => 'required|string',
            'current_linked_product_id' => 'nullable|integer',
        ]);

        $prefix = Str::startsWith($req->subtype, 'software') ? 'Software' :
            (Str::startsWith($req->subtype, 'hardware') ? 'Hardware' : null);

        if (!$prefix) return response()->json([]);

        $query = Product::query()->select('id', 'title', 'product_code');

        if ($prefix === 'Software') {
            // Get both software and hardware products
            $query->whereIn('product_type', ['Software', 'Hardware']);
        } elseif ($prefix === 'Hardware') {
            // Only hardware products
            $query->where('product_type', 'Hardware');
        }

        // Optional: include currently linked product in results (for edit page)
        if ($req->filled('current_linked_product_id')) {
            $query->orWhere('id', $req->current_linked_product_id);
        }

        // Exclude products already linked to a service — except the currently linked one
        /*$query->where(function ($q) use ($req) {
            $q->whereDoesntHave('linkedServices');
            if ($req->filled('current_linked_product_id')) {
                $q->orWhere('id', $req->current_linked_product_id);
            }
        });*/

        $products = $query->get();

        return response()->json($products);
    }


    public function vendorIndex()
    {
        $vendors = Vendor::paginate(env('APP_PAGINATION'));

        return view('admin.product_management.vendors.index', compact('vendors'));
    }
    public function vendorStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vendors,name',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'createData') // use a custom error bag
                ->withInput()
                ->with('open_modal', 'create');
        }
        Vendor::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'payment_detail' => $request->input('payment_detail'),
            'currency' => $request->input('currency'),
            'point_of_contact' => $request->input('point_of_contact'),
        ]);
        return back()->with('success', 'Vendor created successfully.');
    }
    public function vendorUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vendors,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'updateData') // use a different error bag
                ->withInput()
                ->with('open_modal', 'update-' . $id); // or just 'update'
        }

        $vendor= Vendor::findOrFail($id);
        $vendor->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'payment_detail' => $request->input('payment_detail'),
            'currency' => $request->input('currency'),
            'point_of_contact' => $request->input('point_of_contact'),
        ]);

        return back()->with('success', 'Vendor updated successfully.');
    }
    public function vendorDelete($id)
    {
        Vendor::where('id',$id)->delete();
        return back()->with('success', 'Vendor deleted successfully.');
    }
}
