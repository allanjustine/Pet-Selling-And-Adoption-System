@extends('layouts.seller.app')

@section('title', "$app_name | Order Invoice")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet">
    <style>
        .active .bs-stepper-circle {
            background-color: #C66930;
        }
    </style>
@endsection

@section('content')
    {{-- CONTAINER --}}
    <div class="container pt-3">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('seller.orders.index') }}">All Orders</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->transaction_no }}</li>
                    </ol>
                </nav>


                @if ($order->status === \App\Models\Order::APPROVED && $order->payment_type === 'half')

                    {{-- If the order doesnt have an additional payment --}}
                    @if (!$order->additional_payment)
                        <div class="alert alert-danger fade show p-3 text-white text-left" role="alert">

                            Note: To prioritize your order
                            and ensure a smooth transaction, we kindly request you to settle the
                            remaining balance of ₱{{ number_format($order->pet->price / 2) }}. Once
                            the
                            payment is completed, the pet owner
                            can prioritize your meet-up to bring home your newly purchased puppy.

                            <a class="text-warning"
                                href="{{ route('seller.orders.additional_payments.create', $order) }}">Pay
                                Here</a>
                        </div>
                    @else
                        {{-- If the order has additional payment then we post the status --}}
                        @if ($order->additional_payment->status === \App\Models\AdditionalPayment::PENDING)
                            <div class="alert alert-primary fade show p-3 text-white text-left" role="alert">

                                Thank you for submitting your payment! Your payment is now being reviewed.
                                In a short while, you will receive an email and an SMS with updates about the progress of
                                your purchase. These notifications will contain all the necessary information regarding your
                                order.
                                <br>

                                <a class="text-sm text-warning"
                                    href="{{ route('seller.additional_payments.show', $order->additional_payment) }}">
                                    View <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @elseif($order->additional_payment->status === \App\Models\AdditionalPayment::APPROVED)
                            <div class="alert alert-success fade show p-3 text-white text-left alert-dismissible "
                                role="alert">
                                Thank you for completing your payment! We are delighted to have you as our valued customer
                                and want to assure you that we are taking good care of your order.
                                In a short while, you will receive an email and an SMS with updates about the progress of
                                your purchase. These notifications will contain all the necessary information regarding your
                                order.
                                <br>

                                <a class="text-sm text-warning"
                                    href="{{ route('seller.additional_payments.show', $order->additional_payment) }}">
                                    View <i class="fas fa-arrow-right ml-1"></i>
                                </a>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @else
                            <div class="alert alert-danger fade show p-3 text-white text-left" role="alert">

                                Your requested additional payment has unfortunately been declined. We apologize for any
                                inconvenience caused. Please review your payment method details and ensure accuracy and
                                sufficient funds. If you have any concerns or need assistance, our customer support team is
                                available to help. Thank you for your understanding and cooperation.

                                {{ $order->additional_payment->remark }}
                                <br>

                                <a class="text-sm text-warning"
                                    href="{{ route('seller.additional_payments.show', $order->additional_payment) }}">
                                    View <i class="fas fa-arrow-right ml-1"></i>
                                </a>

                            </div>
                        @endif
                    @endif

                @endif

                {{-- Proggress --}}
                <div class="card card-body px-1">
                    <div class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step @if ($order->status == \App\Models\Order::PENDING) active @endif"
                                data-target="#first-{{ $order->id }}">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="first-{{ $order->id }}" id="first-{{ $order->id }}-trigger">
                                    <span class="bs-stepper-circle">
                                        <span class="fas fa-spinner" aria-hidden="true"></span>
                                    </span>
                                    <span class="bs-stepper-label text-smallest"> Pending
                                    </span>
                                </button>
                            </div>

                            @if ($order->status == \App\Models\Order::DECLINED)
                                <div class="line"></div>
                                <div class="step @if ($order->status == \App\Models\Order::DECLINED) active @endif"
                                    data-target="#second-{{ $order->id }}">
                                    <button type="button" class="step-trigger" role="tab"
                                        aria-controls="second-{{ $order->id }}"
                                        id="second-{{ $order->id }}-trigger">
                                        <span class="bs-stepper-circle">
                                            <span class="fas fa-times-circle" aria-hidden="true"></span>
                                        </span>
                                        <span class="bs-stepper-label text-smallest">Declined</span>
                                    </button>
                                </div>
                            @else
                                <div class="line"></div>
                                <div class="step @if ($order->status == \App\Models\Order::APPROVED) active @endif"
                                    data-target="#second-{{ $order->id }}">
                                    <button type="button" class="step-trigger" role="tab"
                                        aria-controls="second-{{ $order->id }}"
                                        id="second-{{ $order->id }}-trigger">
                                        <span class="bs-stepper-circle">
                                            <span class="fas fa-check-circle" aria-hidden="true"></span>
                                        </span>
                                        <span class="bs-stepper-label text-smallest">Approved</span>
                                    </button>
                                </div>
                            @endif

                            <div class="line"></div>
                            <div class="step @if ($order->status == \App\Models\Order::TO_BE_DELIVERED) active @endif"
                                data-target="#third-{{ $order->id }}">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="third-{{ $order->id }}" id="third-{{ $order->id }}-trigger">
                                    <span class="bs-stepper-circle">
                                        <span class="fas fa-shipping-fast" aria-hidden="true"></span>
                                    </span>
                                    <span class="bs-stepper-label text-smallest">To be delivered</span>
                                </button>
                            </div>

                            <div class="line"></div>
                            <div class="step @if ($order->status == \App\Models\Order::DELIVERED) active @endif"
                                data-target="#fourth-{{ $order->id }}">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="fourth-{{ $order->id }}" id="fourth-{{ $order->id }}-trigger">
                                    <span class="bs-stepper-circle">
                                        <span class="fas fa-check" aria-hidden="true"></span>
                                    </span>
                                    <span class="bs-stepper-label text-smallest">Delivered</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <!-- your steps content here -->
                            <div id="first-{{ $order->id }}" class="content" role="tabpanel"
                                aria-labelledby="first-{{ $order->id }}-trigger"></div>
                            <div id="second-{{ $order->id }}" class="content" role="tabpanel"
                                aria-labelledby="second-{{ $order->id }}-trigger"></div>
                            <div id="third-{{ $order->id }}" class="content" role="tabpanel"
                                aria-labelledby="third-{{ $order->id }}-trigger"></div>
                            <div id="fourth-{{ $order->id }}" class="content" role="tabpanel"
                                aria-labelledby="fourth-{{ $order->id }}-trigger"></div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- Content --}}
                                <div class="row align-items-center">
                                    {{-- Logo --}}
                                    <div class="col-3">
                                        <img class="d-block mx-auto rounded-circle"
                                            src="{{ handleNUllAvatarForPet($order->pet->avatar_profile) }}"
                                            width="60" alt="{{ $order->pet->name }}">
                                    </div>

                                    {{-- pet Info --}}
                                    <div class="col-9">

                                        <h3 class="font-weight-normal">
                                            <a href="{{ route('seller.pets.show', $order->pet) }}">
                                                {{ $order->pet->name }}
                                                |
                                                {{ $order->pet->breed->name }}
                                                | {{ $order->pet->category->name }}
                                            </a>
                                        </h3>

                                        <h5 class="font-weight-normal">
                                            Delivered To: {{ $order->user->full_name }}
                                        </h5>

                                        <h4 class="text-dark pet_price">
                                            ₱{{ number_format($order->pet->price, 2) }}
                                        </h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Display Credentials --}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <h3 class="font-weight-normal">Billing Address <i
                                        class="fas fa-map-marker-alt ml-1 text-danger"></i>
                                </h3> <br>

                                <h4 class="font-weight-normal">
                                    Customer: {{ $order->user->full_name }}
                                </h4>

                                <h4 class="font-weight-normal">
                                    Address: {{ $order->user->address }}
                                </h4>

                                <h4 class="font-weight-normal">
                                    Barangay: {{ $order->user->barangay->name }}
                                </h4>

                                <h4 class="font-weight-normal">
                                    Contact: {{ $order->user->contact }}
                                </h4>

                                <h4 class="font-weight-normal">
                                    Email: <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                                </h4>

                            </div>
                        </div>
                    </div>

                    {{-- Payment Details --}}
                    <div class="col-md-12">

                        <div class="row">

                            {{-- Invoice --}}
                            <div class="col-md-6 d-flex align-self-stretch">

                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        <h3 class="font-weight-normal">Order Summary <i
                                                class="fas fa-credit-card ml-1 text-primary"></i>
                                        </h3>
                                        <br>

                                        <h4 class="font-weight-normal">
                                            Grand Total (₱): {{ number_format($order->pet->price, 2) }}
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Transaction No. {{ $order->transaction_no }}
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Payment Type: <span class="badge badge-success">
                                                {{ $order->payment_type }}
                                            </span>
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Paid Via: <span class="badge badge-success">
                                                {{ $order->payment_method->type }} <i
                                                    class="fas fa-check-circle ml-1"></i></span>
                                        </h4>

                                        <h4 class="font-weight-normal">
                                            Order Status: {!! handleOrderStatus($order->status) !!}
                                        </h4>

                                        <a class="text-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            View Payment Receipt
                                        </a>

                                        <div class="collapse mt-3" id="collapseExample">
                                            <a class="glightbox" href="{{ handleNullImage($order->payment_receipt) }}">
                                                <img class="img-thumbnail"
                                                    src="{{ handleNullImage($order->payment_receipt) }}" width="100"
                                                    alt="payment receipt">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            {{-- Display Image By Order Status --}}
                            <div class="col-md-6 text-center d-flex align-self-stretch">
                                <div class="card w-100">
                                    <div class="card-body d-flex and flex-column">
                                        {{-- If the order in to be delivered --}}
                                        @if ($order->status == \App\Models\Order::PENDING)
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ asset('img/order/pending.svg') }}" alt="pending">
                                            <h4>Your order waiting to being processed ...</h4>
                                        @elseif($order->status == \App\Models\Order::APPROVED)
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ asset('img/order/approved.svg') }}" alt="approved">
                                            <h4>Your order has been approved it is now being processed ...</h4>
                                        @elseif($order->status == \App\Models\Order::DECLINED)
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ asset('img/order/rejected.png') }}" alt="declined">
                                            <h4>Your order has been declined ...</h4>
                                        @elseif($order->status == \App\Models\Order::TO_BE_DELIVERED)
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ asset('img/order/on_delivery.svg') }}" alt="on_delivery">
                                            <h4>Your order now is to be delivered ...</h4>
                                        @else($order->status == \App\Models\Order::DELIVERED)
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ asset('img/order/delivered.svg') }}" alt="delivered">

                                            @if (!$order->has_been_delivered_by_seller)
                                                <h4 class="font-weight-normal">
                                                    Thank you for choosing Furfect! We are delighted to inform you that your
                                                    transaction has been successfully completed. To finalize the process,
                                                    kindly mark your transaction as DELIVERED. We kindly request you to
                                                    upload a proof of delivery as a verification of your recent activities.
                                                    Your cooperation is highly appreciated.
                                                </h4>
                                                <br>
                                                <form action="{{ route('seller.orders.mark_as_delivered', $order) }}"
                                                    method="POST" id="order_mark_as_delivered_form"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <div class="form-group mb-3">
                                                        <input class="proof_of_delivery" type="file" name="image">
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="promptStore(event,'#order_mark_as_delivered_form')">Mark
                                                        as
                                                        Delivered
                                                    </button>
                                                </form>
                                            @else
                                                <h4 class="font-weight-normal">
                                                    Thank you for choosing Furfect! We are delighted to inform you that your
                                                    transaction has been successfully completed.
                                                </h4>
                                            @endif
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    {{-- if the order has has proof of delivery --}}
                    <div class="col-md-12">
                        @if ($order->has_been_delivered_by_seller && $order->proof_of_delivery)
                            <div class="card mt-3">
                                <div class="card-header">
                                    Proof of Delivery <i class="fas fa-image ml-1"></i>
                                </div>
                                <div class="card-body">
                                    <a class="glightbox" href="{{ $order->proof_of_delivery }}">
                                        <img class="img-fluid" src="{{ handleNullImage($order->proof_of_delivery) }}"
                                            alt="proof of delivery">
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        initiateFilePond('.proof_of_delivery',
            ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            `Drag & Drop or Upload <span class="filepond--label-action">  Proof of Delivery </span>`
        )
    </script>
@endsection
