@extends('layouts.buyer.app')

@section('title', "$app_name | $seller->business_name")

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        @include('layouts.includes.alert')

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('buyer.pets.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Pet Store
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $seller->business_name }}
                </li>
            </ol>
        </nav>


        {{-- Start Row 1 --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body text-left">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/petshop/petshop.png') }}" alt="petshop">
                    <br>
                    <h3 class="font-weight-normal text-primary text-center">{{ $seller->business_name }} <i
                            class="fas fa-paw ml-1"></i>
                    </h3>
                    <h4 class="font-weight-normal">Address:
                        <a href="https://www.google.com/maps?q={{ urlencode($seller->address) }}"
                            target="_blank">{{ $seller->address }}</a>
                    </h4>
                    <h4 class="font-weight-normal">Contact: {{ $seller->contact }}</h4>
                    <h4 class="font-weight-normal">Email: {{ $seller->email }}</h4>
                    <h4 class="font-weight-normal">Owner:
                        {{ $seller->user->full_name }}
                    </h4>
                    <div>
                        Ratings:
                        @if ($seller->user->avg_ratings)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i > $seller->user->avg_ratings)
                                    <i class="far fa-star text-warning"></i>
                                @else
                                    <i class="fas fa-star text-warning"></i>
                                @endif
                            @endfor
                        @else
                            <i class="far fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                        @endif
                    </div>
                    <br>
                    <div class="float-right">
                        <a class="btn btn-sm btn-success" data-toggle="collapse" href="#show_reviews">
                            View Feedback <i class="fas fa-comment ml-1"></i>
                        </a>
                        <a class="btn btn-sm btn-success" target="_blank"
                                    href="https://api.whatsapp.com/send?phone={{ $seller->contact }}">
                                    Message Me: <i class="fab fa-whatsapp ml-1"></i>
                        </a>
                        {{-- <a class="btn btn-sm btn-success" href="tel:{{ $seller->contact }}">
                            Message <i class="fas fa-comments ml-1"></i>
                        </a> --}}
                    </div>

                </div>

                <div class="collapse mt-3" id="show_reviews">
                    <div class="card card-body">
                        @forelse ($seller->user->ratings as $rating)
                            <div class="d-flex justify-content-start align-items-center p-2 mt-2">
                                <img class="rounded-circle" src="{{ handleNullAvatar($rating->sender->avatar_profile) }}"
                                    width="40">
                                <div class="mx-3 w-100">
                                    <div>
                                        <h5 class="font-weight-normal mb-0">{{ $rating->sender->full_name }} <span
                                                class="text-muted ml-1">
                                                -
                                                {{ formatDate($rating->created_at) }}</span>

                                        </h5>
                                        <h4 class="font-weight-normal">
                                            {{ $rating->comment }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @empty
                            No Reviews Found!
                        @endforelse
                    </div>
                </div>
            </div>
        </div>


        {{-- Start Pet --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">Pet for Sale <i class="fas fa-paw ml-1"> </i> </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($pets as $pet)
                                <div class="col-6 col-md-4 col-lg-2 d-flex align-self-stretch px-1">
                                    <div class="card w-100 card-shadow-none hoverable">
                                        <img class="card-img-top" src="{{ handleNullAvatarForPet($pet->avatar_profile) }}"
                                            width="120" alt="pet">
                                        <div class="card-body d-flex flex-column text-small">
                                            <a class="card-text mb-2 text-primary"
                                                href="{{ route('buyer.pets.show', $pet) }}">
                                                {{ $pet->name }}
                                            </a>
                                            <h5 class="font-weight-normal">Breed: {{ $pet->breed->name }}</h5>
                                            <span>
                                                ₱ {{ number_format($pet->price) }}
                                            </span><br>
                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <img class="img-fluid rounded-circle"
                                                    src="{{ handleNullAvatar($pet->user->avatar_thumbnail) }}"
                                                    width="30" title="{{ $pet->user->full_name }}" alt="avatar">
                                                <div>
                                                    <span class="mr-1">
                                                        <i class="far fa-thumbs-up text-muted"></i>
                                                        {{ $pet->likes->count() }}
                                                    </span>
                                                    <span class="mr-1">
                                                        <i class="far fa-comment text-muted"></i>
                                                        {{ $pet->comments->count() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $pets->links() }}
                    </div>
                </div>
                {{-- End ROW --}}
            </div>
        </div>
        {{-- End Pet --}}

        {{-- Start Adoption --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">Pet for Adoption <i class="fas fa-paw ml-1"> </i> </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($adoptions as $adoption)
                                <div class="col-6 col-md-4 col-lg-2 d-flex align-self-stretch px-1">
                                    <div class="card w-100 card-shadow-none hoverable">
                                        <img class="card-img-top"
                                            src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}" width="120"
                                            alt="pet">
                                        <div class="card-body d-flex flex-column text-small">
                                            <a class="card-text mb-2 text-primary"
                                                href="{{ route('buyer.adoptions.show', $adoption) }}">
                                                {{ $adoption->pet_name }}
                                            </a>
                                            <h5 class="font-weight-normal">Breed: {{ $adoption->breed->name }}</h5>
                                            <span>
                                                Free
                                            </span><br>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $adoptions->links() }}
                    </div>
                </div>
                {{-- End ROW --}}
            </div>
        </div>
        {{-- End Adoption --}}

    </div>
    {{-- End CONTAINER --}}

@endsection
