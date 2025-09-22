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
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Role</th>
                                                        <th>E-Mail</th>
                                                        <th class="w-1">Edit</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($users as $user)
                                                    <tr>
                                                        <td>{{$user->name}}</td>
                                                        <td>{{$user->first_name}}</td>
                                                        <td>{{$user->last_name}}</td>
                                                        <td>{{$user->cell}}</td>
                                                        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                                                        <td>{{$user->email}}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
