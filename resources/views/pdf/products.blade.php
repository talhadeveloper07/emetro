@extends('pdf.layout')

@section('title')
    Products
@endsection
@section('content')
    <table>
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Type</th>
            <th>Sub Type</th>
            <th>Additional Help Information</th>
            <th>Sort Order</th>
            <th>Inventory Location</th>
            <th>Inventory Count</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><span class="text-wrap">{{ $product->product_code ?? '' }}</span></td>
                <td><span class="text-wrap">{{ $product->title ?? '' }}</span></td>
                <td><span class="text-wrap">{{ $product->description ?? '' }}</span></td>
                <td>
{{--                    <span class="text-wrap">{{ $product->image ?? '' }}</span>--}}
                    @if($product->image)
                        <img src="{{($product->image)}}" style="width: 50px;height: auto;" alt="{{$product->product_code}}">
                    @endif
                </td>
                <td><span class="text-wrap">{{ $product->product_type ?? '' }}</span></td>
                <td><span class="text-wrap">{{ $product->product_sub_type  }}</span></td>
                <td><span class="text-wrap">{{ $product->additional_information  }}</span></td>
                <td><span class="text-wrap">{{ $product->sort_order  }}</span></td>
                <td><span class="text-wrap">{{ $product->inventory_location  }}</span></td>
                <td><span class="text-wrap">{{ $product->inventory_count  }}</span></td>
                <td>{{ $product->status }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
