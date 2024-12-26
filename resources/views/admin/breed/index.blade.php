@extends('layouts.admin.app')

@section('title', 'Admin | Manage Breed')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="float-right btn btn-sm btn-primary me-3" href="javascript:void(0)"
                            onclick="toggle_modal('#m_breed', '.breed_form', ['#m_breed_title','Add breed'], ['.btn_add_breed','.btn_update_breed'], {rname:'admin.breeds.create', column:'name', target:['#d_categories']})">Create
                            Breed +</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover breed_dt">
                                <caption>List of Breed</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Breed</th>
                                        <th>Category</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display Breeds --}}
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
