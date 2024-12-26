@extends('layouts.seller.app')

@section('title', "$app_name | Order History")

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    Account
                </li>
                <li class="breadcrumb-item">
                    All Delivered Orders
                </li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- Start ROW --}}
                <div class="row">

                    @if ($orders->isNotEmpty())
                        @foreach ($orders as $order)
                            <div class="col-md-12" id="cart_row-{{ $order->id }}">
                                <div class="card">

                                    <div class="card-body">

                                        {{-- Content --}}
                                        <div class="row align-items-center mt-2">
                                            {{-- Logo --}}
                                            <div class="col-4">
                                                <img class="img-fluid rounded-circle"
                                                    src="{{ handleNullAvatarForPet($order->pet->avatar_profile) }}"
                                                    width="150" alt="{{ $order->pet->name }}">
                                            </div>

                                            {{-- pet Info --}}
                                            <div class="col-8">
                                                <h4 class="text-primary font-weight-normal">
                                                    <a href="{{ route('seller.orders.show', $order) }}">
                                                        {{ $order->pet->name }} |
                                                        {{ $order->pet->breed->name }}
                                                    </a>
                                                </h4>
                                                <h4 class="font-weight-normal">
                                                    {{ $order->pet->category->name }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-3 col-md-2">
                                                <h5 class="font-weight-normal">ORDER PLACED</h5>
                                                <h5 class="font-weight-normal"> {{ formatDate($order->created_at) }}
                                                </h5>
                                            </div>
                                            <div class="col-3 col-md-2">
                                                <h5 class="font-weight-normal">TOTAL</h5>
                                                <h5 class="font-weight-normal">
                                                    ₱{{ number_format($order->pet->price) }}
                                                </h5>
                                            </div>
                                            <div class="col-3 col-md-2">
                                                <h5 class="font-weight-normal">Buyer</h5>
                                                <h5 class="font-weight-normal">
                                                    {{ $order->user->full_name }}
                                                </h5>
                                            </div>
                                            <div class="col-3 col-md-6 text-lg-right">
                                                <h5 class="font-weight-normal">ORDER # {{ $order->transaction_no }}
                                                </h5>
                                                <h5>
                                                    <a href="{{ route('seller.orders.show', $order) }}">
                                                        View order
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <figure>
                            <img class="img-fluid d-block mx-auto" src="{{ asset('img/nodata.svg') }}" alt="empty"><br>
                            <figcaption>
                                <p class="text-center">Oops! History Not found</p>
                            </figcaption>
                        </figure>

                    @endif

                </div>

                {{-- End ROW --}}
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
