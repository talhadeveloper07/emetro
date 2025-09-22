<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Log;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Description',
            'Image',
            'Type',
            'Sub Type',
            'Additional Help Information',
            'Sort Order',
            'Inventory Location',
            'Inventory Count',
            'Status',
        ];
    }

    public function map($product): array
    {
        return [
            $product->product_code ?? '',
            $product->title ?? '',
            $product->description ?? '',
            $product->image ?? '',
            $product->product_type ?? '',
            $product->product_sub_type ?? '',
            $product->additional_information ?? '',
            $product->sort_order ?? '',
            $product->inventory_location ?? '',
            $product->inventory_count ?? '',
            $product->status ? ucfirst($product->status) : '',

        ];
    }
}
