@extends('layouts.buyer.app')

@section('title', "$app_name | Pet Shop")

@section('styles')
    <style>
        /* Add a custom class for scrollable dropdown */
        .scrollable-dropdown {
            max-height: 300px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <h4 class="mb-3 font-weight-normal">
                    <div class="dropdown ">
                        <a class="text-muted dropdown-toggle text-small" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" data-display="static" aria-expanded="false">
                            All Filter
                        </a>

                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow scrollable-dropdown"
                            aria-labelledby="dropdownMenuLink">

                            <a class="dropdown-item" href="{{ route('buyer.pets.index') }}">
                                All Pets
                            </a>

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Categories</h6>
                            </div>

                            @foreach ($categories as $id => $category)
                                <a class="dropdown-item @if (request('category') == $id) text-primary @endif"
                                    href="{{ route('buyer.pets.index') }}?category={{ $id }}">
                                    {{ $category }}
                                </a>
                            @endforeach

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Breed</h6>
                            </div>

                            @foreach ($breeds as $breed_id => $breed)
                                <a class="dropdown-item @if (request('breed') == $breed_id) text-primary @endif"
                                    href="{{ route('buyer.pets.index') }}?breed={{ $breed_id }}">
                                    {{ $breed }}
                                </a>
                            @endforeach


                        </div>
                    </div>

                </h4> --}}

                <a class="h5" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                    aria-controls="collapseExample">
                    Toggle to Advanced Search <i class="fas fa-list ml-1"></i>
                </a>
                <div class="collapse mt-2" id="collapseExample">
                    <div class="card card-body">

                        <form method="get" id="search_form">
                            <div class="row">
                                <div class="col-5 px-1">
                                    <div class="form-group mb-1">
                                        <select class="form-control form-control-sm" name="category_id"
                                            onchange="getBreedByCategory(this)">
                                            <option value="" selected>--- All Category ---
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" data-breeds="{{ $category->breeds }}"
                                                    @if (request('category_id') == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5 px-1">
                                    <div class="form-group mb-1">
                                        @if (filled(request('breed_id')))
                                            <select class="form-control form-control-sm" name="breed_id" disabled
                                                id="breed">
                                                <option value="{{ request('breed_id') }}">
                                                    {{ \App\Models\Breed::find(request('breed_id'))->name }}</option>
                                            </select>
                                        @else
                                            <select class="form-control form-control-sm" name="breed_id" disabled
                                                id="breed">
                                                <option value="" selected>--- All Breed ---
                                                </option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div>
                                        <button type="button" onclick="promptStore(event, '#search_form')"
                                            class="btn btn-sm btn-primary d-block w-100">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Start ROW --}}
                <div class="row mt-3">
                    @forelse ($pets as $pet)
                        <div class="col-6 col-md-4 col-lg-2 d-flex align-self-stretch px-1">
                            <div class="card w-100 card-shadow-none hoverable">
                                <img class="card-img-top" src="{{ handleNullAvatarForPet($pet->avatar_profile) }}"
                                    width="120" alt="pet">
                                <div class="card-body d-flex flex-column text-small">
                                    <a class="card-text mb-2 text-primary" href="{{ route('buyer.pets.show', $pet) }}">
                                        {{ $pet->name }}
                                    </a>
                                    <h5 class="font-weight-normal">Breed: {{ $pet->breed->name }}</h5>
                                    <span>
                                        ₱ {{ number_format($pet->price) }}
                                    </span><br>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <a href="{{ route('buyer.sellers.show', $pet->user->seller_account) }}">
                                            <img class="img-fluid rounded-circle"
                                                src="{{ handleNullAvatar($pet->user->avatar_thumbnail) }}" width="30"
                                                title="{{ $pet->user->full_name }}" alt="avatar">
                                        </a>
                                        <div>
                                            <span class="mr-1">
                                                <i class="far fa-thumbs-up text-muted"></i> {{ $pet->likes->count() }}
                                            </span>
                                            <span class="mr-1">
                                                <i class="far fa-comment text-muted"></i> {{ $pet->comments->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $pets->links() }}
                        </div>
                    @empty
                        <div>
                            <img class="img-fluid d-block mx-auto" src="{{ asset('img/nodata.svg') }}"
                                alt="record not found">
                        </div>
                    @endforelse
                </div>


                {{-- End ROW --}}
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection

@section('script')
    <script>
        function getBreedByCategory(category) {

            if (category.value !== "") {
                // Display Breeds By Selected Category
                const breeds = JSON.parse($(category).find(":selected").attr('data-breeds'));

                if (breeds.length > 0) {

                    let output = '<option></option>';

                    breeds.forEach(breed => {
                        output += `<option value='${breed.id}'>${breed.name}</option>`
                    })

                    $("#breed").attr('disabled', false).html(output);

                } else {
                    $("#breed").attr('disabled', true).html(``);

                }
            } else {
                $("#breed").attr('disabled', true).html(``);
            }

        }
    </script>
@endsection
