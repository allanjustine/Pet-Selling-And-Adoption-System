@extends('layouts.buyer.app')

@section('title', "$app_name | $pet->name")

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('buyer.pets.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $pet->name }}
                </li>
            </ol>
        </nav>

        <div class="nav-wrapper">
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
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                        href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i
                            class="fas fa-clipboard mr-2"></i>Vaccination & Deworming</a>
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
                                src="{{ handleNullAvatarForPet($pet->avatar_profile) }}" width="120" alt="avatar">
                            <br>
                            <h3 class="font-weight-normal text-primary">Pet Name: {{ $pet->name }}</h3>
                            <h4 class="font-weight-normal">Breed: {{ $pet->breed->name }}</h4>
                            <h4 class="font-weight-normal">Type: {{ $pet->type }}</h4>
                            <h4 class="font-weight-normal">Category: {{ $pet->category->name }}</h4>
                            <h4 class="font-weight-normal">Sex: {{ $pet->sex }}</h4>
                            <h4 class="font-weight-normal">Color: {{ $pet->color }}</h4>
                            <h4 class="font-weight-normal">Birth Date: {{ formatDate($pet->birth_date) }}</h4>
                            <h4 class="font-weight-normal">Age: {{ getPetAge($pet->birth_date) }}</h4>
                            <h4 class="font-weight-normal">Seller:
                                {{ $pet->user->seller_account->business_name }} <i class="fas fa-paw ml-1"></i>
                            </h4>
                            <h4 class="font-weight-normal">Price: ₱{{ number_format($pet->price) }}</h4>

                            <br>

                            <div>
                                <a class="btn btn-sm btn-primary" href="{{ route('buyer.pets.orders.create', $pet) }}">
                                    Buy Now
                                </a>

                                <a class="btn btn-sm btn-info"
                                    href="{{ route('buyer.sellers.show', $pet->user->seller_account) }}">
                                    Visit Shop
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                @if ($pet->notes)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-body">
                                <small>
                                    Note: {{ $pet->notes }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row" id="d_community_pet">
                    <div class="w-100" id="pet_row-1">
                        <div class="col-md-12 pb-3">
                            @auth
                                <div class="card card-body">
                                    <div class="d-flex justify-content-end">
                                        <div>
                                            {{-- Comments count --}}
                                            <span class="comments mr-1">
                                                <span id="comment_count-{{ $pet->id }}">
                                                    {{ $pet->comments->count() }}
                                                </span>
                                                <span class="text-primary h5 ml-1" role="button">
                                                    <i class="far fa-comment-alt fa-lg"
                                                        onclick="showComments({{ $pet->id }})"></i>
                                                </span>
                                            </span>

                                            {{-- Likes  count --}}
                                            <span class="likes mx-1">
                                                <span id="like_count-{{ $pet->id }}">
                                                    {{ $pet->likes->count() }}
                                                </span>
                                                @if (isLikedByAuthUser(auth()->id(), $pet->likes))
                                                    <span id="like_icon-{{ $pet->id }}">
                                                        <span class="text-primary h5 ml-1" role="button"
                                                            onclick="dislike({{ $pet->id }})">
                                                            <i class="fas fa-thumbs-up fa-lg"></i>
                                                        </span>
                                                    </span>
                                                @else
                                                    <span id="like_icon-{{ $pet->id }}">
                                                        <span class="text-primary h5 ml-1" role="button"
                                                            onclick="like({{ $pet->id }})">
                                                            <i class="far fa-thumbs-up fa-lg"></i>
                                                        </span>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <br>
                                        <form class="pet_form" autocomplete="off">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img class="rounded-circle avatar avatar-sm"
                                                    src="{{ handleNullAvatar(auth()->user()?->avatar_profile) }}"
                                                    alt="avatar.jpg">
                                                <div class="input-group input-group-outline mx-3 w-100 ">
                                                    <input class="form-control textarea" type="text"
                                                        id="comment_input-{{ $pet->id }}">
                                                </div>
                                            </div>
                                            <br>
                                            <button class="btn btn-sm btn-outline-primary float-right" type="button"
                                                onclick="addComment({{ $pet->id }}, event)">Comment</button>

                                        </form>
                                        <br>

                                        {{-- Comments --}}
                                        <div class="mt-2" id="d_comments-{{ $pet->id }}"
                                            style="display:none !important">
                                            @foreach ($pet->comments as $comment)
                                                {{-- Comment Wrapper --}}
                                                <div class="bg-gray-100 rounded" id="comment_row-{{ $comment->id }}">
                                                    <div class="d-flex justify-content-start align-items-center p-2 mt-2">
                                                        <img class="rounded-circle"
                                                            src="{{ handleNullAvatar($comment->user->avatar_profile) }}"
                                                            width="30" data-toggle="tooltip" data-html="true"
                                                            title="<div class='w-100 p-3 text-center">
                                                        <div class="mx-3 w-100">
                                                            {{-- Comment Settings --}}
                                                            @if (auth()->id() === $comment->user_id)
                                                                <div class="px-2 float-right">
                                                                    <div
                                                                        class="dropdown d-flex justify-content-end text-right">
                                                                        <a class='btn btn-sm btn-icon-only text-light'
                                                                            href='#' role='button'
                                                                            data-toggle='dropdown' data-display="static"
                                                                            aria-expanded='false'>
                                                                            <i class='fas fa-ellipsis-v'></i>
                                                                        </a>

                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                            aria-labelledby="dropdownMenu">
                                                                            <button class="dropdown-item" type="button"
                                                                                onclick="editComment({{ $comment }})">Edit</button>
                                                                            <button class="dropdown-item" type="button"
                                                                                onclick="removeComment({{ $pet->id }}, {{ $comment->id }})">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="comment_body">
                                                                <h4 class="font-weight-normal">
                                                                    {{ $comment->user->full_name }} <span
                                                                        class="text-muted ml-1">
                                                                        -
                                                                        {{ $comment->created_at->longAbsoluteDiffForHumans() }}</span>

                                                                </h4>
                                                                <h4 class="font-weight-normal" id="d_comment">
                                                                    {{ $comment->comment }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End Comment Wrapper --}}
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- End Comments --}}
                                </div>
                            @endauth
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
                                        @forelse ($pet->getMedia('featured_photos') as $img)
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
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                {{-- Start Vaccination History --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
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
                </div>
                {{-- End Vaccination History --}}

                {{-- Start Deworming History --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
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
                </div>
                {{-- End Deworming History --}}
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                {{-- Start ROW 4 --}}
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ handleNullImage($pet->proof_of_ownership) }}" class="glightbox">
                                    <img class="card-img-top img-fluid"
                                        src="{{ handleNullImage($pet->proof_of_ownership) }}" alt="proof_of_ownership">
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
