@extends('layouts.admin.app')

@section('title', 'Admin | Manage Pet Adoption')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')


        <div class="row justify-content-center">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <select class="form-control form-control-sm" onchange="filterPetForAdoptionByCategory(this)">>
                            <option>--- All Category --- </option>
                            @foreach ($categories as $id => $category)
                                <option value="{{ $id }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <div class="float-right mb-3">
                            <a href="{{ route('admin.print.handle') }}?records=adoption"
                                class="btn btn-sm btn-primary">Print
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover adoption_dt">
                                <caption>List of Registered Pet for Adoption</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Avatar</th>
                                        <th>Pet Name</th>
                                        <th>Breed</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Seller</th>
                                        {{-- <th>Price(₱)</th> --}}
                                        <th>Proof Of Ownership</th>
                                        <th>Availability</th>
                                        <th>Is Approved</th>
                                        <th>Registered At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display pet adoptions --}}
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
