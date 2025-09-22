@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('e_admin.commercials.index') }}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>
                        Discount Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="javascript:void(0)" class="btn btn-primary  d-inline-block" data-bs-toggle="modal" data-bs-target="#addModal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Create New
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body overflow-hidden">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th class="w-1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($discounts as $discount)
                                        <tr>
                                            <td>{{ $discount->name }}</td>
                                            <td>{{ $discount->amount }}</td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal-{{$discount->id}}">Edit</a>

                                                    <form action="{{ route('e_admin.discount_management.delete', $discount->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                                    </form>
                                                </div>
                                                <div class="modal modal-blur fade" id="updateModal-{{$discount->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Discount</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form id="payment-form" method="post" action="{{route('e_admin.discount_management.update',$discount->id)}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">

                                                                            <div class="mb-3">
                                                                                <label class="form-label required">Name</label>
                                                                                <input type="text" class="form-control" name="name" value="{{ $discount->name }}" placeholder="Enter Name" required>
                                                                                @error('name', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror

                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label required">Amount</label>
                                                                                <input type="number" class="form-control" name="amount" value="{{ $discount->amount }}" min="0" step=".01" placeholder="Enter Amount" required>
                                                                                @error('amount', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                                        Cancel
                                                                    </a>
                                                                    <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="20">
                                                <div class="empty">
                                                    <div class="empty-img"><img src="{{asset('')}}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128"  alt="">
                                                    </div>
                                                    <p class="empty-title">No results found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{$discounts->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Discount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="payment-form" method="post" action="{{route('e_admin.discount_management.store')}}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                        @error('name', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Amount</label>
                                        <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" min="0" step=".01" placeholder="Enter Amount" required>
                                        @error('amount', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')
    @if (session('open_modal') === 'create')
        <script>
            $(document).ready(function () {
                $('#addModal').modal('show');
            });
        </script>
    @endif
    @if (Str::startsWith(session('open_modal'), 'update'))
        <script>
            $(document).ready(function () {
                const id = '{{ str_replace("update-", "", session("open_modal")) }}';
                $('#updateModal-' + id).modal('show');
            });
        </script>
    @endif
@endsection
