@extends('layouts.admin.app')

@section('title', 'Admin | Create Administrator')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="font-weight-normal text-primary">
                            <a class="text-primary float-left" href="{{ route('admin.admins.index') }}">
                                <i class='fas fa-arrow-left'></i>
                            </a>
                            <span class="ml-3"> Create Administrator <i class="fas fa-user ml-1"></i></span>
                        </h2>

                        <br>
                        @include('layouts.includes.alert')
                        <form class="row" action="{{ route('admin.admins.store') }}" method="post" id="admin_form">
                            @csrf

                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Middle Name </label>
                                    <input type="text" class="form-control" name="middle_name" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-label">Sex *</label>
                                    <select class="form-control" name="sex" required>
                                        <option value=""></option>
                                        <option value="male">
                                            Male</option>
                                        <option value="female">
                                            Female</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-3">
                                    <label class="form-label">Birth Date</label>
                                    <input class="form-control" type="date" max="2012-01-01" name="birth_date">
                                </div>


                                <div class="form-group">
                                    <button type="button" class="btn btn-primary"
                                        onclick="promptStore(event, '#admin_form')">Submit</button>
                                </div>

                            </div>
                            <div class="col-md-6">


                                <div class="form-outline mb-2">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" type="text"name="address" placeholder="Complete Address">
                                </div>

                                {{-- <div class="form-group mb-2">
                                    <label class="form-label">Barangay *</label>
                                    <select class="form-control" name="barangay_id" required>
                                        <option value=""></option>
                                        @foreach ($barangays as $id => $barangay)
                                            <option value="{{ $id }}">{{ $barangay }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="form-outline mb-2">
                                    <label class="form-label">Contact</label>
                                    <input class="form-control" type="number" min="0" name="contact"
                                        placeholder="Ex. 09659312005">
                                </div>


                                <div class="form-group mb-2">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="email" required>
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
