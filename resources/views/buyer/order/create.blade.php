@extends('layouts.buyer.app')

@section('title', "$app_name | Create Order")

@section('content')

    {{-- payment_method --}}
    <div class="modal fade" id="m_payment_method" tabindex="-1" role="dialog" aria-labelledby="m_payment_method_label"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white text-sm"><i class="fas fa-info-circle mr-1"></i> Accepting Payments
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning fade show p-3 text-white" role="alert">
                        Reminder: Payment in advance is mandatory.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account Name</th>
                                    <th>Account No.</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_methods as $payment_method)
                                    <tr>
                                        <td>{{ $payment_method->type }}</td>
                                        <td>{{ $payment_method->account_name }}</td>
                                        <td>{{ $payment_method->account_no }}</td>
                                        <td>{!! isOnline($payment_method->is_online) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End payment_method --}}

    {{-- CONTAINER --}}
    <div class="container-fluid pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('buyer.pets.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('buyer.pets.show', $pet) }}">
                        {{ $pet->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create Order
                </li>
            </ol>
        </nav>

        <div class="alert alert-warning fade show p-3 text-white" role="alert">
            Reminder: Payment in advance is mandatory.
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="font-weight-normal">Pet: {{ $pet->name }} </h4>
                        <h4 class="font-weight-normal">Breed: {{ $pet->breed->name }} </h4>
                        <h4 class="font-weight-normal">Sex: {{ $pet->sex }}</h4>
                        <h4 class="font-weight-normal">Color: {{ $pet->color }}</h4>
                        <h4 class="font-weight-normal">Birth Date: {{ formatDate($pet->birth_date) }}</h4>
                        <h4 class="font-weight-normal">Age: {{ getPetAge($pet->birth_date) }}</h4>
                        <h4 class="font-weight-normal">Seller:
                            {{ $pet->user->seller_account->business_name }} <i class="fas fa-paw ml-1"></i>
                        </h4>
                        <h4 class="font-weight-normal">Price: ₱{{ number_format($pet->price) }}</h4>

                        <hr>
                        <h4>
                            Billing Address <i class="fas fa-map-marker-alt ml-1 text-danger"></i>
                        </h4>

                        <form action="{{ route('buyer.pets.orders.store', $pet) }}" method="post"
                            enctype="multipart/form-data" id="order_form">
                            @csrf
                            @include('layouts.includes.alert')

                            <div class="form-group mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control form-control-sm" type="text"
                                    value="{{ auth()->user()->full_name }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Address</label>
                                <input class="form-control form-control-sm" type="text"
                                    value="{{ auth()->user()->address }}" readonly>
                            </div>

                            <label class="form-label">Contact*</label>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <input class="form-control form-control-sm" type="number" min="0" name="contact"
                                        placeholder="Ex. 09659312003" autocomplete="tel-local" id="contact"
                                        value="{{ auth()->user()->contact }}" readonly>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="sendOtp(event)">Send
                                            OTP</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">OTP*</label>
                                <input class="form-control form-control-sm" type="number" name="otp" min="0"
                                    placeholder="Enter 6 digits OTP Code">
                            </div>

                            <hr>
                            <h4>
                                Payments <i class="fas fa-credit-card ml-1"></i>
                            </h4>

                            <a href="javascript:void(0)" onclick="$('#m_payment_method').modal('show')">
                                <small>View Payment Options
                                    <i class="fas fa-info-circle ms-1"></i>
                                </small>
                            </a>
                            <br>
                            <br>
                            <h4>
                                Or Scan this QR code
                            </h4>
                            <div class="col-3 col-md-3">
                            <img class="img-fluid" src="{{ asset('img/auth/qr.jpg') }}" alt="qr">
                        </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Select Payment Type *</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="half" name="payment_type" class="custom-control-input"
                                        onchange="$('#amount_to_pay').val({{ $pet->price / 2 }})" value="half">
                                    <label class="custom-control-label" for="half">
                                        Half Payment (50%)
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="full" name="payment_type"
                                        class="custom-control-input"
                                        onchange="$('#amount_to_pay').val({{ $pet->price }})" value="full">
                                    <label class="custom-control-label" for="full">Full Payment</label>
                                </div>
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label">Amount to Pay (₱)</label>
                                <input class="form-control form-control-sm" type="text" name="amount_to_pay"
                                    id="amount_to_pay" value="" readonly>
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label">Select Payment Method *</label>
                                <select class="form-control form-control-sm" name="payment_method_id">
                                    <option value=""></option>
                                    @foreach ($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">
                                            {{ $payment_method->type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Reference No. *</label>
                                <input class="form-control form-control-sm" type="text" name="reference_no"
                                    placeholder="Enter the reference / control no." required>
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label">Add Note (Optional)</label>
                                <input class="form-control form-control-sm" type="text" name="note">
                            </div>


                            <div class="form-group mb-3">
                                <input class="payment_receipt" type="file" name="image">
                            </div>

                            <div class="form-text text-smaller">Note* Attach a screenshot of your Payment
                                Transaction</div>

                            <input type="hidden" name="pet_id" value="{{ $pet->id }}">

                            <button type="button" class="btn btn-primary d-block w-100 mt-3"
                                onclick="promptStore(event,'#order_form', 'Do you want to order?', 'Note: Please double check the uploaded screenshot of your payment receipt', 'Yes')">Submit</button>
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
        initiateFilePond('.payment_receipt',
            ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            `Drag & Drop or <span class="filepond--label-action">  Browse Receipt </span>`
        )
    </script>
@endsection
