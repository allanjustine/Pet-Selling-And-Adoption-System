@extends('layouts.admin.app')

@section('title', 'Admin | Manage Administrator')

@section('styles')
    <style>
        td {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal !important;
            text-align: justify;
        }
    </style>
@endsection

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="float-right btn btn-sm btn-primary me-3" href="{{ route('admin.admins.create') }}">Create
                            Admin +</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover admin_dt">
                                <caption>List of Administrator <i class="fas fa-users ml-1"></i></caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>Address</th>
                                        <th>Barangay</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display Admin --}}
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
