@extends('layouts.admin')

@section('content')
    @include('org.header')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('org.header_tabs')
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12  mb-3">
                                            <div class="row row-cards">
                                                <div class="col-6">
                                                    <form action="{{ route('org.document', $org->id) }}" id="filterForm" method="get">
                                                        <div class="mb-3">
                                                            <label class="form-label">Type</label>
                                                            <select  name="type" id="type"
                                                                     class="form-control form-select select2" >
                                                                <option value="" selected="selected">All</option>
                                                                <option value="Exemption Certificate" {{ isset($request) && $request->type == 'Exemption Certificate' ? 'selected' : '' }}>Exemption Certificate</option>
                                                                <option value="Proposal" {{ isset($request) && $request->type == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                                                                <option value="Terms & Conditions" {{ isset($request) && $request->type == 'Terms & Conditions' ? 'selected' : '' }}>Terms & Conditions</option>
                                                                <option value="Other" {{ isset($request) && $request->type == 'Other' ? 'selected' : '' }}>Other</option>

                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Upload Document</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>Document Type</th>
                                                        <th>Status</th>
                                                        <th class="w-1">Uploaded</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($documents as $document)
                                                        <tr>
                                                            <td> @if($document->file) <a href="{{asset($document->file)}}" target="_blank">{{basename($document->file)}}</a> @endif </td>
                                                            <td>{{$document->type}}</td>
                                                            <td>
                                                            <div >
                                                                <label class="form-control">
                                                                    <input type="radio" name="radio_{{$document->id}}" value="Pending" {{$document->status=="Pending"?"checked":""}}  data-id="{{ $document->id }}">
                                                                    Pending
                                                                </label>
                                                                <label class="form-control">
                                                                    <input type="radio" name="radio_{{$document->id}}" value="Completed" {{$document->status=="Completed"?"checked":""}} data-id="{{ $document->id }}">
                                                                    Completed
                                                                </label>
                                                                <label class="form-control">
                                                                    <input type="radio" name="radio_{{$document->id}}" value="Rejected" {{$document->status=="Rejected"?"checked":""}} data-id="{{ $document->id }}">
                                                                    Rejected
                                                                </label></div>

                                                            </td>
                                                            <td >{{$document->created_at->format('m-d-Y')}}</td>
                                                        </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="20">
                                                            <div class="empty">
                                                                <div class="empty-img">
                                                                    <img src="{{ asset('') }}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
                                                                </div>
                                                                <p class="empty-title">No document available</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    @if ($documents->hasPages())
                                        <div class="card-footer d-flex align-items-center">
                                            {{ $documents->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="doc-form" method="post" action="{{ route('org.document.save', $org->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="mb-3">
                                    <label class="form-label required">Document Type</label>
                                    <select  name="type"
                                             class="form-control form-select" required>
                                        <option value="" selected="selected">All</option>
                                        <option value="Exemption Certificate">Exemption Certificate</option>
                                        <option value="Proposal">Proposal</option>
                                        <option value="Terms & Conditions">Terms & Conditions</option>
                                        <option value="Other">Other</option>

                                    </select>
                                    @error('name', 'createData')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Select Document</label>
                                    <input type="file"
                                           class="form-control"
                                           name="file"
                                           accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                           required>
                                    <small class="text-muted">Allowed extensions: .pdf, .doc, .docx, .png, .jpg — Max size: 2MB</small>
                                    @error('file', 'createData')
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

@endsection
@section('scripts')
    @if (session('open_modal') === 'create')
        <script>
            $(document).ready(function () {
                $('#addModal').modal('show');
            });
        </script>
    @endif
    <script>
        $(document).ready(function () {
            if (window.location.search) {
                window.history.replaceState(null, "", window.location.pathname);
            }
            $('#type').on('change',function(){
                $('#filterForm').submit();
            });
            $('input[type=radio]').on('change', function () {
                const documentId = $(this).data('id');
                const newStatus = $(this).val();

                $.ajax({
                    url: '{{ route("org.document.updateStatus") }}', // define this route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: documentId,
                        status: newStatus
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
