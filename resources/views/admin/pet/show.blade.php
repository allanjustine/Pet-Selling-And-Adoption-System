@extends('layouts.admin.app')

@section('title', 'Admin | Pet Info')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.pets.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $pet->name }}
                </li>
            </ol>
        </nav>

        @include('layouts.includes.alert')
        <div class="row">
            <div class="col-md-4 d-flex align-self-stretch">
                <div class="card w-100">
                    <div class="card-body d-flex and flex-column">
                        <img class="img-fluid rounded-circle" src="{{ handleNullAvatarForPet($pet->avatar_profile) }}"
                            width="150" alt="avatar">
                        <br>
                        <h3 class="font-weight-normal">Name: {{ $pet->name }}</h3>
                        <h3 class="font-weight-normal">Breed: {{ $pet->breed->name }}</h3>
                        <h3 class="font-weight-normal">Type: {{ $pet->type }}</h3>
                        <h3 class="font-weight-normal">Sex: {{ $pet->sex }}</h3>
                        <h3 class="font-weight-normal">Color: {{ $pet->color }}</h3>
                        <h3 class="font-weight-normal">Birth Date: {{ formatDate($pet->birth_date) }}</h3>
                        <h3 class="font-weight-normal">Age: {{ getPetAge($pet->birth_date) }}</h3>
                        <h3 class="font-weight-normal">Category: {{ $pet->category->name }}</h3>
                        <h3 class="font-weight-normal">Selling Price: ₱{{ number_format($pet->price, 2) }}</h3>
                        <h3 class="font-weight-normal">Seller:
                            <a class="text-primary" href="">
                                <img class="img-fluid rounded-circle mr-1"
                                    src="{{ handleNullAvatar($pet->user->avatar_thumbnail) }}" width="30"
                                    title="{{ $pet->user->seller_account->business_name }}" alt="avatar">
                                {{ $pet->user->seller_account->business_name }}
                            </a>
                        </h3>
                        <h3 class="font-weight-normal">Status: {!! isApproved($pet->status) !!}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-8 d-flex align-self-stretch">
                <div class="card card-body">
                    {{-- Start Carousel --}}
                    <div id="featured_photos" class="carousel slide" data-bs-ride="carousel">
                        <div id="petIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#petIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#petIndicators" data-slide-to="1"></li>
                                <li data-target="#petIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <!--Display pet images !-->
                                @forelse ($pet->getMedia('featured_photos') as $img)
                                    @if ($loop->first)
                                        <div class="carousel-item active">
                                            <img src="{{ handleNullImage($img->getUrl('card')) }}" class="d-block mx-auto"
                                                width='400' alt="pet_image">
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img src="{{ handleNullImage($img->getUrl('card')) }}" class="d-block mx-auto"
                                                width='400' alt="pet_image">
                                        </div>
                                    @endif
                                @empty
                                    <div class="carousel-item active">
                                        <img src="{{ asset('img/img_not_found.svg') }}" class="d-block mx-auto"
                                            width='400' alt="no_images">
                                    </div>
                                @endforelse
                            </div>
                            <button class="carousel-control-prev" type="button" data-target="#petIndicators"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"> <i
                                        class="fas fa-chevron-left text-dark"></i></span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#petIndicators"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"> <i
                                        class="fas fa-chevron-right text-dark"></i></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>
                    </div>
                    {{-- End Carousel --}}
                </div>

            </div>

            <div class="col-md-12">

                <div class="row">
                    {{-- Start Vaccination History --}}
                    <div class="col-md-4 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header bg-gray text-white">
                                <small>
                                    Vaccination History <i class="fas fa-syringe ml-1"></i>
                                </small>
                            </div>

                            <div class="card-body">
                                {{-- Start Carousel --}}
                                <div id="featured_photos" class="carousel slide" data-bs-ride="carousel">
                                    <div id="vaccination_history_indicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#vaccination_history_indicators" data-slide-to="0"
                                                class="active"></li>
                                            <li data-target="#vaccination_history_indicators" data-slide-to="1"></li>
                                            <li data-target="#vaccination_history_indicators" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <!--Display pet images !-->
                                            @forelse ($pet->getMedia('vaccination_history') as $vaccination_history)
                                                @if ($loop->first)
                                                    <div class="carousel-item active">
                                                        <img src="{{ handleNullImage($vaccination_history->getUrl('card')) }}"
                                                            class="d-block mx-auto" width='400' alt="pet_image">
                                                    </div>
                                                @else
                                                    <div class="carousel-item">
                                                        <img src="{{ handleNullImage($vaccination_history->getUrl('card')) }}"
                                                            class="d-block mx-auto" width='400' alt="pet_image">
                                                    </div>
                                                @endif
                                            @empty
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('img/img_not_found.svg') }}"
                                                        class="d-block mx-auto" width='400' alt="no_images">
                                                </div>
                                            @endforelse
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-target="#vaccination_history_indicators" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"> <i
                                                    class="fas fa-chevron-left"></i></span>
                                            <span class="sr-only">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-target="#vaccination_history_indicators" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"> <i
                                                    class="fas fa-chevron-right"></i></span>
                                            <span class="sr-only">Next</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- End Carousel --}}
                            </div>
                        </div>

                    </div>
                    {{-- End Vaccination History --}}

                    {{-- Start Deworming History --}}
                    <div class="col-md-4 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header bg-gray text-white">
                                <small>
                                    Deworming History <i class="fas fa-clipboard-list ml-1"></i>
                                </small>
                            </div>

                            <div class="card-body">
                                {{-- Start Carousel --}}
                                <div id="featured_photos" class="carousel slide" data-bs-ride="carousel">
                                    <div id="deworming_history_indicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#deworming_history_indicators" data-slide-to="0"
                                                class="active"></li>
                                            <li data-target="#deworming_history_indicators" data-slide-to="1"></li>
                                            <li data-target="#deworming_history_indicators" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <!--Display pet images !-->
                                            @forelse ($pet->getMedia('deworming_history') as $deworming_history)
                                                @if ($loop->first)
                                                    <div class="carousel-item active">
                                                        <img src="{{ handleNullImage($deworming_history->getUrl('card')) }}"
                                                            class="d-block mx-auto" width='400' alt="pet_image">
                                                    </div>
                                                @else
                                                    <div class="carousel-item">
                                                        <img src="{{ handleNullImage($deworming_history->getUrl('card')) }}"
                                                            class="d-block mx-auto" width='400' alt="pet_image">
                                                    </div>
                                                @endif
                                            @empty
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('img/img_not_found.svg') }}"
                                                        class="d-block mx-auto" width='400' alt="no_images">
                                                </div>
                                            @endforelse
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-target="#deworming_history_indicators" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"> <i
                                                    class="fas fa-chevron-left"></i></span>
                                            <span class="sr-only">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-target="#deworming_history_indicators" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"> <i
                                                    class="fas fa-chevron-right"></i></span>
                                            <span class="sr-only">Next</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- End Carousel --}}
                            </div>
                        </div>

                    </div>
                    {{-- End Deworming History --}}

                    <div class="col-md-4 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header bg-gray text-white">
                                <small>
                                    Proof of Ownership <i class="fas fa-info-circle ml-1"></i>
                                </small>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <a href="{{ handleNullImage($pet->proof_of_ownership) }}" class="glightbox">
                                    <img class="card-img-top img-fluid"
                                        src="{{ handleNullImage($pet->proof_of_ownership) }}" alt="proof_of_ownership">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>

    {{-- End CONTAINER --}}

@endsection
