@extends('layouts.admin.app')

@section('title', 'Admin | Create Category')

@section('content')

    {{-- CONTAINER --}}
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.categories.index') }}">
                        All Categories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create Category
                </li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        @include('layouts.includes.alert')
                        <form class="row" action="{{ route('admin.categories.store') }}" method="post"
                            id="category_form">
                            @csrf
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category *</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Has Vaccination? *</label> <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_vaccination_yes" name="has_vaccination"
                                            class="custom-control-input yes" value="1">
                                        <label class="custom-control-label" for="has_vaccination_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_vaccination_no" name="has_vaccination"
                                            class="custom-control-input no" value="0">
                                        <label class="custom-control-label" for="has_vaccination_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Has Deworming? *</label> <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_deworming_yes" name="has_deworming"
                                            class="custom-control-input yes" value="1">
                                        <label class="custom-control-label" for="has_deworming_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_deworming_no" name="has_deworming"
                                            class="custom-control-input no" value="0">
                                        <label class="custom-control-label" for="has_deworming_no">
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary"
                                        onclick="promptStore(event, '#category_form')">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End CONTAINER --}}

@endsection
