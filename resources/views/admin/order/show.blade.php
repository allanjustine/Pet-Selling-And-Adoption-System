@extends('layouts.admin.app')

@section('title', 'Admin | Order Invoice')

@section('content')
    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">All Orders</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->transaction_no }}</li>
            </ol>
        </nav>
        <div class="nav-wrapper">
            <ul class="nav nav-pills nav-fill flex-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                        href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i
                            class="fas fa-info-circle mr-2"></i>Order Invoice</a>
                </li>

                @if (
                    $order->status == \App\Models\Order::PENDING ||
                        $order->status == \App\Models\Order::APPROVED ||
                        $order->status == \App\Models\Order::TO_BE_DELIVERED)
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                            href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                            aria-selected="false"><i class="fas fa-cog mr-2"></i>Manage Order</a>
                    </li>
                @endif

                {{-- Only show if the order has additional payment --}}
                @if ($order->additional_payment)
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                            href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                            aria-selected="false"><i class="fas fa-cog mr-2"></i>
                            Manage Additional Payment
                        </a>
                    </li>
                @endif

                @if ($order->status == \App\Models\Order::DELIVERED)
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                            href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                            aria-selected="false"><i class="fas fa-eye mr-2"></i>More Info</a>
                    </li>
                @endif

            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                aria-labelledby="tabs-icons-text-1-tab">
                <div class="row justify-content-center">
                    <div class="col-md-4 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- Pet Info --}}

                                        <img class="img-fluid rounded-circle "
                                            src="{{ handleNullAvatarForPet($order->pet->avatar_profile) }}" width="150"
                                            alt="{{ $order->pet->name }}">
                                        <br><br>

                                        <h4 class="font-weight-normal"> Name:
                                            <a href="{{ route('admin.pets.show', $order->pet) }}">
                                                {{ $order->pet->name }}
                                            </a>
                                        </h4>
                                        <h4 class="font-weight-normal">Breed: {{ $order->pet->breed->name }}</h4>
                                        <h4 class="font-weight-normal">Category: {{ $order->pet->category->name }}
                                        </h4>
                                        <h4 class="font-weight-normal">Sex: {{ $order->pet->sex }}</h4>
                                        <h4 class="font-weight-normal">Color: {{ $order->pet->color }}</h4>
                                        <h4 class="font-weight-normal">Birth Date:
                                            {{ formatDate($order->pet->birth_date) }}</h4>
                                        <h4 class="font-weight-normal">Age:
                                            {{ getPetAge($order->pet->birth_date) }}</h4>
                                        <h4 class="font-weight-normal">Seller:
                                            <a href="{{ route('admin.sellers.show', $order->pet->user->seller_account) }}">
                                                {{ $order->pet->user->seller_account->business_name }} <i
                                                    class="fas fa-paw ml-1"></i>
                                            </a>
                                        </h4>
                                        <h4 class="font-weight-normal">Price:
                                            ₱{{ number_format($order->pet->price) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-body d-flex and flex-column">
                                {{-- Display Credentials --}}
                                <div>
                                    <h3 class="font-weight-normal">Billing Address <i
                                            class="fas fa-map-marker-alt text-danger ml-1"></i>
                                    </h3> <br>

                                    <h4 class="font-weight-normal">
                                        Name: {{ $order->user->full_name }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Address: {{ $order->user->address }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Barangay: {{ $order->user->barangay->name }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Contact: {{ $order->contact }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Email: <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                                    </h4>
                                </div>
                                <hr>
                                {{-- Payment Details --}}
                                <div>
                                    <h3 class="font-weight-normal">Order Summary <i
                                            class="fas fa-credit-card ml-1 text-primary"></i>
                                    </h3>

                                    <h3 class="font-weight-normal">
                                        Grand Total (₱): {{ number_format($order->pet->price, 2) }}
                                    </h3>

                                    <h4 class="font-weight-normal">
                                        Order No. {{ $order->transaction_no }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Reference No. {{ $order->reference_no }}
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Payment Type: <span class="badge badge-success">{{ $order->payment_type }}</span>
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Paid Via: <span
                                            class="badge badge-success">{{ $order->payment_method->type }}</span>
                                    </h4>

                                    <h4 class="font-weight-normal">
                                        Order Status: {!! handleOrderStatus($order->status) !!}
                                    </h4>

                                    <a class="text-primary text-small" data-toggle="collapse" href="#collapseExample"
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
                    </div>
                </div>

                {{-- Only show if there is an additional payment --}}
                @if ($order->additional_payment)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-body">
                                <h3 class="font-weight-normal">Additional Payment <i
                                        class="fas fa-credit-card ml-1 text-primary"></i>
                                </h3>

                                <h3 class="font-weight-normal">
                                    Amount Paid (₱): {{ number_format($order->pet->price / 2, 2) }}
                                </h3>

                                <h4 class="font-weight-normal">
                                    Reference No. {{ $order->additional_payment->reference_no }}
                                </h4>

                                <h4 class="font-weight-normal">
                                    Payment Type: <span
                                        class="badge badge-success">{{ $order->additional_payment->payment_type }}</span>
                                </h4>

                                <h4 class="font-weight-normal">
                                    Paid Via: <span
                                        class="badge badge-success">{{ $order->additional_payment->payment_method->type }}</span>
                                </h4>

                                <h4 class="font-weight-normal">
                                    Payment Status: {!! handleOrderStatus($order->additional_payment->status) !!}
                                </h4>

                                <a class="text-primary text-small" data-toggle="collapse"
                                    href="#additional_payment_receipt" role="button" aria-expanded="false"
                                    aria-controls="additional_payment_receipt">
                                    View Payment Receipt
                                </a>

                                <div class="collapse mt-3" id="additional_payment_receipt">
                                    <a class="glightbox"
                                        href="{{ handleNullImage($order->additional_payment->payment_receipt) }}">
                                        <img class="img-thumbnail"
                                            src="{{ handleNullImage($order->additional_payment->payment_receipt) }}"
                                            width="100" alt="payment receipt">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if (
                $order->status == \App\Models\Order::PENDING ||
                    $order->status == \App\Models\Order::APPROVED ||
                    $order->status == \App\Models\Order::TO_BE_DELIVERED)
                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                    aria-labelledby="tabs-icons-text-2-tab">
                    <div class="row justify-content-center">
                        {{-- Display only if its not delivered Options --}}


                        <div class="col-md-8">

                            <div class="card card-body">
                                <h2 class="text-primary">Manage Order *</h2>

                                <div class="text-center">
                                    @if ($order->status == \App\Models\Order::PENDING)
                                        <img class="img-fluid" src="{{ asset('img/order/pending.svg') }}" width="300"
                                            alt="pending">
                                        <h3> Status: order is waiting to
                                            being processed ...</h3>
                                    @elseif($order->status == \App\Models\Order::APPROVED)
                                        <img class="img-fluid" src="{{ asset('img/order/approved.svg') }}"
                                            width="300" alt="approved">
                                        <h3> Status: order has been approved it is now being processed ...</h3>
                                    @elseif($order->status == \App\Models\Order::DECLINED)
                                        <img class="img-fluid" src="{{ asset('img/order/rejected.png') }}"
                                            width="300" alt="rejected">
                                        <h3 class="text-center"> order has been declined ...</h3>
                                    @elseif($order->status == \App\Models\Order::TO_BE_DELIVERED)
                                        <img class="img-fluid" src="{{ asset('img/order/on_delivery.svg') }}"
                                            width="300" alt="on_delivery">
                                        <h3> Status: order is now to be delivered ...</h3>
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/order/delivered.svg') }}"
                                            width="300" alt="delivered">
                                        <h3> Status: order has been delivered ...</h3>
                                    @endif
                                </div>
                                <form action="{{ route('admin.orders.update', $order) }}" method="POST"
                                    id="order_form">
                                    @csrf @method('PUT')

                                    {{-- If there is a note --}}
                                    @if ($order->note)
                                        <div class="alert alert-primary alert-dismissible fade show p-3 text-white mt-2"
                                            role="alert">
                                            Customer's Note: {{ $order->note }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="form-group mb-2">
                                        <label class="form-label">Select Status</label>
                                        <select name="status" class="form-control" onchange="manageOrder(this)">
                                            <option value=""></option>

                                            @if ($order->status == \App\Models\Order::PENDING)
                                                <option value="1">Approve Order</option>
                                                <option value="2">Reject Order</option>
                                            @endif

                                            @if ($order->status == \App\Models\Order::APPROVED)
                                                <option value="3">Mark as To be Delivered</option>
                                                <option value="4">Mark as Delivered</option>
                                            @endif

                                            @if ($order->status == \App\Models\Order::TO_BE_DELIVERED)
                                                <option value="4">Mark as Delivered</option>
                                            @endif

                                        </select>
                                    </div>


                                    <div class="form-group mb-2">
                                        <label class="form-label">Remark</label>
                                        <textarea class="form-control" name="remark" rows="6" placeholder="Add Remark (Optional). "></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2"
                                        onclick="promptUpdate(event, '#order_form', 'Do you want to Update Order Status?', '', 'Yes')">Save</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            @endif

            {{-- Only show if the order has additional payment --}}
            @if ($order->additional_payment)
                <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                    aria-labelledby="tabs-icons-text-3-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="card card-body">
                                <h2 class="text-primary">Manage Payment *</h2>

                                <div class="text-center">
                                    @if ($order->additional_payment->status == \App\Models\Order::PENDING)
                                        <img class="img-fluid" src="{{ asset('img/order/pending.svg') }}" width="300"
                                            alt="pending">
                                        <h3> Status: Pending</h3>
                                    @elseif($order->additional_payment->status == \App\Models\Order::APPROVED)
                                        <img class="img-fluid" src="{{ asset('img/order/approved.svg') }}"
                                            width="300" alt="approved">
                                        <h3> Status: Payment has been approved...</h3>
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/order/rejected.png') }}"
                                            width="300" alt="rejected">
                                        <h3 class="text-center"> Payment has been declined ...</h3>
                                    @endif
                                </div>
                                <form
                                    action="{{ route('admin.orders.additional_payments.update', [$order, $order->additional_payment]) }}"
                                    method="POST" id="additional_payment_form">
                                    @csrf @method('PUT')

                                    {{-- If there is a note --}}
                                    @if ($order->additional_payment->note)
                                        <div class="alert alert-primary alert-dismissible fade show p-3 text-white mt-2"
                                            role="alert">
                                            Customer's Note: {{ $order->additional_payment->note }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="form-group mb-2">
                                        <label class="form-label">Select Status</label>
                                        <select name="status" class="form-control" onchange="manageOrder(this)">
                                            <option value=""></option>
                                            <option value="1">Approve Payment</option>
                                            <option value="2">Declined Payment</option>
                                        </select>
                                    </div>


                                    <div class="form-group mb-2">
                                        <label class="form-label">Remark</label>
                                        <textarea class="form-control" name="remark" rows="6" placeholder="Add Remark (Optional). "></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2"
                                        onclick="promptUpdate(event, '#additional_payment_form', 'Do you want to Update Payment Status?', '', 'Yes')">Save</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            @endif


            {{-- Only show if the order has been delivered --}}
            @if ($order->status == \App\Models\Order::DELIVERED)
                <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                    aria-labelledby="tabs-icons-text-4-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card card-body text-center">

                                <h3 class="font-weight-normal"> Order Received By Buyer :
                                    {{ $order->has_been_received_by_buyer ? 'Yes' : 'No' }}</h3>
                                <h3 class="font-weight-normal"> Mark as Delivered By Seller :
                                    {{ $order->has_been_delivered_by_seller ? 'Yes' : 'No' }}
                                </h3>
                                @if ($order->has_been_delivered_by_seller)
                                    <h3 class="font-weight-normal">Proof of Delivery <i class="fas fa-handshake ml-1"></i>
                                    </h3><br>
                                    <a class="glightbox" href="{{ $order->proof_of_delivery }}">
                                        <img class="img-thumbnail" src="{{ handleNullImage($order->proof_of_delivery) }}"
                                            width="350" alt="proof of delivery">
                                    </a>
                                @else
                                    <br>
                                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/nodata.svg') }}"
                                        width="350" alt="no proof of delivery">
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            @endif

        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
