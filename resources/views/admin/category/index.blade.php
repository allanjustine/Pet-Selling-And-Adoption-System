@extends('layouts.admin.app')

@section('title', 'Admin | Manage Category')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="float-right btn btn-sm btn-primary me-3"
                            href="{{ route('admin.categories.create') }}">Create
                            Category +</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover category_dt">
                                <caption>List of Category</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Has Vaccination</th>
                                        <th>Has Deworming</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display Categories --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
