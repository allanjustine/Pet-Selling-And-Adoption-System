@extends('layouts.seller.app')

@section('title', "$app_name | Pet Management")

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="mb-3 font-weight-normal">
                    <div class="dropdown ">
                        <a class="text-muted dropdown-toggle text-small" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" data-display="static" aria-expanded="false">
                            All Filter
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($categories as $id => $category)
                                <a class="dropdown-item @if (request('category') == $id) text-primary @endif"
                                    href="{{ route('seller.pets.index') }}?category={{ $id }}">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a class="float-right btn btn-sm btn-primary me-3 text-smallest"
                        href="{{ route('seller.pets.create') }}">Create Pet +</a><br>
                </h4>

                {{-- Start ROW --}}
                <div class="row">

                    @if ($pets->isNotEmpty())
                        @foreach ($pets as $pet)
                            <div class="col-md-12" id="pet_row-{{ $pet->id }}">
                                <div class="card">

                                    <div class="card-body">

                                        {{-- Content --}}
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <img class="d-block mx-auto rounded-circle"
                                                    src="{{ handleNullAvatarForPet($pet->avatar_profile) }}" width="80"
                                                    alt="{{ $pet->name }}">
                                            </div>
                                            <div class="col-8">

                                                <div class='dropdown float-right'>
                                                    <a class='btn btn-sm btn-icon-only text-light' href='javascript:void(0)'
                                                        role='button' data-toggle='dropdown' data-display="static"
                                                        aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </a>
                                                    <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                                                        <a href="{{ route('seller.pets.show', $pet) }}"
                                                            class="dropdown-item">
                                                            View
                                                        </a>

                                                        @if ($pet->status === \App\Models\Pet::PENDING)
                                                            <a href="{{ route('seller.pets.edit', $pet) }}"
                                                                class="dropdown-item">
                                                                Edit
                                                            </a>
                                                        @endif

                                                        <a class="dropdown-item" href='javascript:void(0)'
                                                            onclick="promptDestroy(event, '#remove_pet-{{ $pet->id }}')">
                                                            Delete
                                                        </a>


                                                        <form action="{{ route('seller.pets.destroy', $pet) }}"
                                                            method="POST" id="remove_pet-{{ $pet->id }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>


                                                <div>
                                                    <h4 class="text-primary">
                                                        {{ $pet->name }} | {{ $pet->category->name }}
                                                    </h4>

                                                    <h5 class="font-weight-normal">
                                                        {{ $pet->created_at->diffForHumans() }}
                                                    </h5>


                                                    @if (!$pet->is_available)
                                                        <h5 class="font-weight-normal">
                                                            <span class="badge badge-danger">Sold <i
                                                                    class="fas fa-times-circle ml-1"> </i></span>
                                                        </h5>
                                                    @else
                                                        <h5 class="font-weight-normal">
                                                            {!! isApproved($pet->status) !!}
                                                        </h5>
                                                    @endif


                                                </div>
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
                                <p class="text-center">Oops! Record not found. Would you like to <a
                                        href="{{ route('seller.pets.create') }}">add Pet?</a></p>
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
