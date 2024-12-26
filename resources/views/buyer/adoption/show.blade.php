@extends('layouts.buyer.app')

@section('title', "$app_name | $adoption->pet_name")

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('buyer.pets.index') }}">
                        Pet Adoption
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $adoption->pet_name }}
                </li>
            </ol>
        </nav>

        <div class="nav-wrapper py-0">
            <ul class="nav nav-pills nav-fill flex-row flex-md-column" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                        href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i
                            class="fas fa-info-circle mr-2"></i>Basic Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                        href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i
                            class="fas fa-images mr-2"></i>Featured Photo</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                        href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i
                            class="fas fa-clipboard-list mr-2"></i>Proof of Ownership</a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                aria-labelledby="tabs-icons-text-1-tab">
                {{-- Start Row 1 --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body text-center">
                            <img class="img-fluid rounded-circle d-block mx-auto"
                                src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}" width="120" alt="avatar">
                            <br>
                            <h4 class="font-weight-normal">Name: {{ $adoption->pet_name }}</h4>
                            <h4 class="font-weight-normal">Breed: {{ $adoption->breed->name }}</h4>
                            <h4 class="font-weight-normal">Category: {{ $adoption->category->name }}</h4>
                            <h4 class="font-weight-normal">Sex: {{ $adoption->sex }}</h4>
                            <h4 class="font-weight-normal">Color: {{ $adoption->color }}</h4>
                            <h4 class="font-weight-normal">Birth Date: {{ formatDate($adoption->birth_date) }}</h4>
                            <h4 class="font-weight-normal">Age: {{ getPetAge($adoption->birth_date) }}</h4>
                            <h4 class="font-weight-normal">Seller:
                                {{ $adoption->user->seller_account->business_name }} <i class="fas fa-paw ml-1"></i>
                            </h4>
                            <h4 class="font-weight-normal">
                                <span class="badge badge-info">Open for Adoption <i class="fas fa-spinner ml-1"></i></span>
                            </h4>

                            <br>

                            <div>
                                <a class="btn btn-sm btn-success"
                                    href="{{ route('buyer.sellers.show', $adoption->user->seller_account) }}">
                                    Visit Shop
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                {{-- Start Row 2 --}}
                <div class="row mt-2">
                    <div class="col-md-12">
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
                                                    <img src="{{ handleNullImage($img->getUrl('card')) }}"
                                                        class="d-block mx-auto" width='400' alt="pet_image">
                                                </div>
                                            @else
                                                <div class="carousel-item">
                                                    <img src="{{ handleNullImage($img->getUrl('card')) }}"
                                                        class="d-block mx-auto" width='400' alt="pet_image">
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
                </div>
                {{-- End Row 2 --}}
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                {{-- Start ROW 4 --}}
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ handleNullImage($adoption->proof_of_ownership) }}" class="glightbox">
                                    <img class="card-img-top img-fluid"
                                        src="{{ handleNullImage($adoption->proof_of_ownership) }}"
                                        alt="proof_of_ownership">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End ROW 4 --}}
            </div>
        </div>

    </div>




    </div>
    {{-- End CONTAINER --}}

@endsection
