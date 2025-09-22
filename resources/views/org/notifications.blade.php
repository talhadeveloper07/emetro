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
                                            <form action="{{ route('org.notifications', $org->id) }}" method="GET">
                                                <div class="">
                                                    <div class="row row-cards">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date Range Start</label>
                                                                <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date Range End</label>
                                                                <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">To</label>
                                                                <input type="text" name="to" class="form-control" value="{{ request('to') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row row-cards">
                                                        <div class="col-sm-12 col-md-12 text-end">
                                                            <button type="submit" class="btn btn-primary">Filter</button>
                                                            @php
                                                                $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                                            @endphp
                                                            @if($hasFilters)
                                                                <a href="{{ route('org.notifications', $org->id) }}" class="btn btn-secondary">Clear Filter</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>To</th>
                                                        <th>Type</th>
                                                        <th>Subject</th>
                                                        <th>View</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($notifications as $notification)
                                                        <tr>
                                                            <td>{{ $notification->created_at->format('m-d-Y H:i:s') }}</td>
                                                            <td><span class="text-wrap">{!! str_replace(',', ',<br>', $notification->to) !!}</span></td>
                                                            <td><span class="text-wrap">{{ucfirst($notification->message_type)}}</span></td>
                                                            <td><span class="text-wrap">{{$notification->subject}}</span></td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#detailModal-{{$notification->id}}">View</button>
                                                                <div class="modal modal-blur fade" id="detailModal-{{$notification->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">{{$notification->subject}}</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto; overflow-x: auto; word-wrap: break-word; white-space: normal;">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12" style="overflow-wrap: break-word; word-break: break-word;">
                                                                                        {!! $notification->mail_message !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <td colspan="20">
                                                                <div class="empty">
                                                                    <div class="empty-img">
                                                                        <img src="{{ asset('') }}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
                                                                    </div>
                                                                    <p class="empty-title">No Notification available</p>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($notifications->hasPages())
                                        <div class="card-footer d-flex align-items-center">
                                            {{ $notifications->links() }}
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
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
