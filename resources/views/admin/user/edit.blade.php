@extends('layouts.admin.app')

@section('title', "$app_name | Manage Account")

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users.index') }}">
                        All Accounts
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Manage {{ $user->full_name }}
                </li>

            </ol>
        </nav>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 order-last order-md-first">

                        @include('layouts.includes.alert')
                        <form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data"
                            id="user_form">
                            @csrf @method('PUT')

                            <div class="form-group mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $user->full_name }}" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Contact</label>
                                <input type="text" class="form-control" value="{{ $user->contact }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Status * </label>
                                <select class="form-control" name="is_activated">
                                    <option value=""></option>
                                    <option value="1" @if ($user->is_activated == true) selected @endif>
                                        Activate
                                    </option>
                                    <option value="0" @if ($user->is_activated == false) selected @endif>
                                        Deactivate
                                    </option>
                                </select>
                            </div>

                            @if ($user->is_activated)
                                <div class="form-group mb-3">
                                    <label class="form-label">Remark *</label>
                                    <input type="text" class="form-control" name="remark" placeholder="N/A">
                                </div>
                            @endif


                            <div class="form-group">
                                <button type="button" class="btn btn-primary w-100"
                                    onclick="promptUpdate(event, '#user_form')">Save</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 d-none d-md-block">
                        <img class="img-fluid" src="{{ asset('img/crud/default.svg') }}" alt="manage">
                    </div>
                </div>
            </div>


        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
