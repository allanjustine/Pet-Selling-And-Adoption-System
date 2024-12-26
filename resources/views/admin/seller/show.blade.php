@extends('layouts.admin.app')

@section('title', 'Admin | Seller Account Info')

@section('content')

    {{-- CONTAINER --}}
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.sellers.index') }}">
                        All Seller
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $seller->business_name }}
                </li>
            </ol>
        </nav>

        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12 d-flex align-self-stretch">
                <div class="card w-100">
                    <div class="card-body d-flex and flex-column">
                        <img class="img-fluid" src="{{ asset('img/petshop/petshop.png') }}" width="150" alt="petshop">
                        <br>
                        <h3 class="font-weight-normal">Store Name: {{ $seller->business_name }}</h3>
                        <h3 class="font-weight-normal">Owner: <img class="img-fluid avatar rounded-circle mr-1"
                                src="{{ handleNullAvatar($seller->avatar_profile) }}" width="50" alt="avatar">
                            {{ $seller->user->full_name }}
                        </h3>
                        <h3 class="font-weight-normal">Address: {{ $seller->address }}</h3>
                        <h3 class="font-weight-normal">Contact:
                            <a href="tel:{{ $seller->contact }}">{{ $seller->contact }}</a>
                        </h3>
                        <h3 class="font-weight-normal">Email:
                            <a href="mailto:{{ $seller->email }}">{{ $seller->email }}</a>
                        </h3>

                        {{-- only show this if the status is pending --}}
                        @if ($seller->status == \App\Models\SellerAccount::PENDING)
                            <hr class="w-100">
                            <h3>Manage Account</h3>
                            <form action="{{ route('admin.sellers.update', $seller) }}" method="post" id="seller_form">
                                @csrf @method('PUT')
                                {{-- @include('layouts.includes.alert') <br> --}}

                                <div class="form-group mb-3">
                                    <label class="form-label">Select Status *</label>
                                    <select class="form-control" name="status" required>
                                        <option value=""></option>
                                        <option value="1" @if ($seller->status == 1) selected @endif>Approve
                                            Request</option>
                                        <option value="2" @if ($seller->status == 2) selected @endif>Decline
                                            Request</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="remark" rows="5" placeholder="Add Remark (Optional)">{{ $seller->remark }}</textarea>
                                </div>

                                <button class="btn btn-primary float-end" type="button"
                                    onclick="event.preventDefault();confirm('Do you want to Update Seller Account Status?', '', 'Yes').then(res => res.isConfirmed ? $('#seller_form').submit() : false )">
                                    Save
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End CONTAINER --}}

@endsection
