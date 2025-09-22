@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <a href="{{ route('provisioning.infinity3065') }}">
                        <!-- Back Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
                    Details
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="details-container mb-3 mt-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Device ID </h5>
                    <p class="card-text">{{ $phone->device_id ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="updateInfinityForm" method='POST'>
                    @csrf
                <ul class="nav nav-tabs card-header-tabs nav-fill mb-4" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#tabs-profile" class="nav-link active" data-bs-toggle="tab">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-user" class="nav-link" data-bs-toggle="tab">User</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-services" class="nav-link" data-bs-toggle="tab">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-logs" class="nav-link" data-bs-toggle="tab">Logs</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Profile Tab -->
                    <div class="tab-pane active" id="tabs-profile">
                        <h2 class="text-lime">System Details</h2>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label required">UCX Serial Number</label>
                                <input type="text" name="slno" class="form-control" value="{{ $phone->slno }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Hostname/IP 1</label>
                                <input type="text" name="s1_ip" class="form-control" value="{{ $phone->s1_ip }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S1 Port</label>
                                <input type="number" step="1" min="0" name="s1_port" class="form-control" value="{{ $phone->s1_port ?? 7000 }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S1 Retries</label>
                                <input type="number" step="1" min="0" name="s1_retry_number" class="form-control" value="{{ $phone->s1_retry_number ?? 1 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Hostname/IP 2</label>
                                <input type="text" name="s2_ip" class="form-control" value="{{ $phone->s2_ip }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S2 Port</label>
                                <input type="number" step="1" min="0" name="s2_port" class="form-control" value="{{ $phone->s2_port ?? 7000 }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">S2 Retries</label>
                                <input type="number" step="1" min="0" name="s2_retry_number" class="form-control" value="{{ $phone->s2_retry_number ?? 1 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Allow Multiple Profile</label>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="allow_multiple_profile" value="1" {{ $phone->allow_multiple_profile ? 'checked' : '' }}>
                                        <span class="form-check-label">Yes</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="allow_multiple_profile" value="0" {{ !$phone->allow_multiple_profile ? 'checked' : '' }}>
                                        <span class="form-check-label">No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Allow Changes to Default Profile</label>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="allow_changes_to_default_profile" value="1" {{ $phone->allow_changes_to_default_profile ? 'checked' : '' }}>
                                        <span class="form-check-label">Yes</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="allow_changes_to_default_profile" value="0" {{ !$phone->allow_changes_to_default_profile ? 'checked' : '' }}>
                                        <span class="form-check-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Infinity One URL</label>
                                <input type="text" name="infinityone_url" class="form-control" value="{{ $phone->infinityone_url }}">
                            </div>
                        </div>
                    </div>

                    <!-- User Tab -->
                    <div class="tab-pane" id="tabs-user">
                        <h2 class="text-lime">User</h2>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="user_email">User Email</label>
                                <input type="email" name="user_email" class="form-control" value="{{ $phone->email ?? '' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $phone->first_name ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $phone->last_name ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ucx_extension">UCX Extension</label>
                                <input type="text" name="extension" class="form-control" value="{{ $phone->extension ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" value="{{ $phone->mobile ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="notification_method">Notification Method</label>
                                <select name="notification_method" class="form-control">
                                    <option value="email" {{ optional($phone)->notification_method === 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="phone" {{ optional($phone)->notification_method === 'phone' ? 'selected' : '' }}>Phone Number</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Services Tab -->
                    <div class="tab-pane" id="tabs-services">
                        <h2 class="text-lime">SMS</h2>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">SMS 1</label>
                                <select name="sms_did1" class="form-control">
                                    <option value="">(Select)</option>
                                    @foreach($phone->services ?? [] as $service)
                                        <option value="{{ $service->id }}" {{ $service->id == ($phone->sms_did1 ?? '') ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">SMS 2</label>
                                <select name="sms_did2" class="form-control">
                                    <option value="">(Select)</option>
                                    @foreach($phone->services ?? [] as $service)
                                        <option value="{{ $service->id }}" {{ $service->id == ($phone->sms_did2 ?? '') ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Logs Tab -->
                    <div class="tab-pane" id="tabs-logs">
                        <h2 class="text-lime">Push Server Notification Logs</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="token_id">Token ID</label>
                                <input type="text" name="token_id" class="form-control" value="{{ $phone->token_id ?? 'dc673338-7fd5-49ce-b1f5-f0092c340881' }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $phone->start_date ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $phone->end_date ?? '' }}">
                            </div>
                            <div class="col-12 mb-3">
                                <button type="button" class="btn btn-primary">Download</button>
                            </div>
                            <div class="col-12 mb-3">
                                <h5>Logs</h5>
                                <ul class="list-group">
                                    @foreach($phone->logs ?? [] as $log)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $log->file_name }}
                                            <div>
                                                <a href="{{ $log->url }}" class="text-success me-3">View</a>
                                                <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    $('#updateInfinityForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let slno = form.find('input[name="slno"]').val(); 
        let url = `/provisioning/infinity3065/update/${slno}`; 

        let formData = form.serialize();
        console.log(url);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                if(res.success){
                    $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: res.message
                    });
                } else {
                    $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to update record'
                    });
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key, value){
                        errorMsg += value[0] + '\n';
                    });
                    $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: errorMsg
                    });
                } else {
                    $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'
                    });
                }
            }
        });

    });

});
</script>

@endsection
