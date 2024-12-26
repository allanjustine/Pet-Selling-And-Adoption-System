@extends('layouts.buyer.app')

@section('title', "$app_name | Additional Payment")


@section('content')
    {{-- CONTAINER --}}
    <div class="container pt-3">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('buyer.orders.index') }}">All Orders</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ route('buyer.orders.show', $additional_payment->order) }}"> Order
                                #{{ $additional_payment->order->transaction_no }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            All Payments
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Transaction No
                            #{{ $additional_payment->transaction_no }}</li>

                    </ol>
                </nav>

                <div class="row">
                    {{-- Payment Details --}}
                    <div class="col-md-12">

                        <div class="row">

                            {{-- Invoice --}}
                            <div class="col-md-6 d-flex align-self-stretch">

                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <h3 class="font-weight-normal">Payment Summary <i
                                                class="fas fa-credit-card ml-1 text-primary"></i>
                                        </h3>
                                        <br>

                                        <h4 class="font-weight-normal">
                                            Amount Paid (₱): {{ number_format($additional_payment->order->pet->price / 2) }}
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Transaction No. {{ $additional_payment->transaction_no }}
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Paid Via: <span class="badge badge-success">
                                                {{ $additional_payment->payment_method->type }} <i
                                                    class="fas fa-check-circle ml-1"></i></span>
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Order Status: {!! handleAdditionalPaymentStatus($additional_payment->status) !!}
                                        </h4>

                                        <a class="text-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            View Payment Receipt
                                        </a>

                                        <div class="collapse mt-3" id="collapseExample">
                                            <a class="glightbox"
                                                href="{{ handleNullImage($additional_payment->payment_receipt) }}">
                                                <img class="img-thumbnail"
                                                    src="{{ handleNullImage($additional_payment->payment_receipt) }}"
                                                    width="100" alt="payment receipt">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
