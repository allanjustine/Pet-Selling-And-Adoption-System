@extends('layouts.admin.app')

@section('title', 'Admin | Pet Info')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.adoptions.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $adoption->pet_name }}
                </li>
            </ol>
        </nav>

        @include('layouts.includes.alert')
        <div class="row">
            <div class="col-md-4 d-flex align-self-stretch">
                <div class="card w-100">
                    <div class="card-body d-flex and flex-column">
                        <img class="img-fluid rounded-circle" src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}"
                            width="150" alt="avatar">
                        <br>
                        <h3 class="font-weight-normal">Name: {{ $adoption->pet_name }}</h3>
                        <h3 class="font-weight-normal">Breed: {{ $adoption->breed->name }}</h3>
                        <h3 class="font-weight-normal">Sex: {{ $adoption->sex }}</h3>
                        <h3 class="font-weight-normal">Color: {{ $adoption->color }}</h3>
                        <h3 class="font-weight-normal">Birth Date: {{ formatDate($adoption->birth_date) }}</h3>
                        <h3 class="font-weight-normal">Age: {{ getPetAge($adoption->birth_date) }}</h3>
                        <h3 class="font-weight-normal">Category: {{ $adoption->category->name }}</h3>
                        <h3 class="font-weight-normal">Seller:
                            <a class="text-primary" href="">
                                <img class="img-fluid rounded-circle mr-1"
                                    src="{{ handleNullAvatar($adoption->user->avatar_thumbnail) }}" width="30"
                                    title="{{ $adoption->user->seller_account?->business_name ?? $adoption->user->full_name }}"
                                    alt="avatar">
                                {{ $adoption->user->seller_account?->business_name ?? $adoption->user->full_name }}
                            </a>
                        </h3>
                        <h3 class="font-weight-normal">Reason: {{ $adoption->reason ?? 'N/A' }}</h3>

                        <h3 class="font-weight-normal">Status: {!! isApproved($adoption->status) !!}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-self-stretch">
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
                                @forelse ($adoption->getMedia('featured_photos') as $img)
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

            <div class="col-md-4 d-flex align-self-stretch">
                <div class="card w-100">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0 font-weight-normal">
                                    Proof of Ownership <i class="fas fa-info-circle ml-1"></i>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex and flex-column">
                        <a href="{{ handleNullImage($adoption->proof_of_ownership) }}" class="glightbox">
                            <img class="img-fluid" src="{{ handleNullImage($adoption->proof_of_ownership) }}"
                                width="450" alt="proof_of_ownership">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if ($adoption->is_adopted)
            <div class="row">

                <div class="col-md-12">
                    {{-- if its adopted show the details --}}
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-normal">Pet Adopter <i class="fas fa-paw ml-1"> </i></h3> <br>
                            @if ($adoption->adopter)
                                <img class="img-fluid rounded-circle mb-3"
                                    src="{{ handleNullAvatar($adoption->adopter->avatar_profile) }}" width="100"
                                    alt="avatar">

                                <h4 class="font-weight-normal">Name: {{ $adoption->adopter->full_name }}</h4>
                                <h4 class="font-weight-normal">Contact: {{ $adoption->adopter->contact }}</h4>
                            @else
                                <img class="img-fluid rounded-circle mb-3" src="{{ asset('img/noimg.svg') }}"
                                    width="100" alt="avatar">
                                <h4 class="font-weight-normal">Name: {{ $adoption->adopter_name }}</h4>
                                <h4 class="font-weight-normal">Contact: {{ $adoption->adopter_contact }}</h4>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>

    {{-- End CONTAINER --}}

@endsection
