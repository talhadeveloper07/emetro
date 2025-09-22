@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('records.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                        </a>
                        Record
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('records.partials.top_cards')
            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('records.partials.tabs')
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                            <thead>
                                            <tr>
                                                <th>Date and Time</th>
                                                <th>Action</th>
                                                <th>Message</th>
                                                <th>Source</th>
                                                <th>User</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($logs as $log)
                                                <tr>
                                                    <td>{{ timeToDate($log->created) }}</td>
                                                    <td><span class="text-wrap">{{ $log->function_name }}</span></td>
                                                    <td><span class="text-wrap">{!! $log->message !!}</span></td>
                                                    <td>{{ $log->interface }}</td>
                                                    <td>{{ $log->uid }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="20">
                                                        <div class="empty">
                                                            <div class="empty-img"><img src="{{ asset('') }}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt=""></div>
                                                            <p class="empty-title">No history available</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($logs->hasPages())
                            <div class="card-footer d-flex align-items-center">
                                {{ $logs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
