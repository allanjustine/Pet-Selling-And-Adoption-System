@extends('layouts.admin.admindashboard')

@section('title', 'Admin | Manage Roles')

@section('content')

{{-- CONTAINER --}}
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
              
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover role_dt">
                            <caption>List of User Role <i class="fas fa-users ms-1"></i> </caption>
                            <thead>
                                <tr>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--Display List of User's Role --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--End CONTAINER--}}

@endsection