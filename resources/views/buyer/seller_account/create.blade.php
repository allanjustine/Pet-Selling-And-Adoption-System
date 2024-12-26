@extends('layouts.buyer.app')

@section('title', "$app_name | Create Seller Account")

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('profile.index') }}">
                        Profile
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create Seller Account
                </li>
            </ol>
        </nav>

        <div class="alert alert-warning alert-dismissible fade show p-3 text-white" role="alert">
            To approve your seller account registration, we kindly request you to provide an updated business permit. Make sure that the business permit is up to date to approve.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.includes.alert')
                        <form action="{{ route('buyer.seller_accounts.store') }}" method="post" id="seller_account_form">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="form-label">Business Name *</label>
                                <input class="form-control form-control-sm" type="text" name="business_name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Business Address *</label>
                                <input class="form-control form-control-sm" type="text" name="address" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Contact *</label>
                                <input type="number" min="0" class="form-control form-control-sm"
                                    placeholder="Eg.09659312005" name="contact" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Email *</label>
                                <input type="mail" class="form-control form-control-sm" name="email"
                                    placeholder="Eg. businessname@email.com" required>
                            </div>

                            <div>
                                <label class="form-label">Business Permit *</label>
                                <input type="file" class="proof_of_ownership" name="proof_of_ownership">
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm w-100"
                                    onclick="promptStore(event, '#seller_account_form')">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection

@section('script')
    <script>
        initiateFilePond('.proof_of_ownership', ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            'Select or <span class="filepond--label-action"> Browse Business Permit</span>')
    </script>
@endsection
