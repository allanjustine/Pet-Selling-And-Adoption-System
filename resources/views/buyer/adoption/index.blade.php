@extends('layouts.buyer.app')

@section('title', "$app_name | Pet Adoption")

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

                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow"
                            aria-labelledby="dropdownMenuLink">
                            @foreach ($categories as $id => $category)
                                <a class="dropdown-item @if (request('category') == $id) text-primary @endif"
                                    href="{{ route('buyer.adoptions.index') }}?category={{ $id }}">
                                    {{ $category }}
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
                    @foreach ($adoptions as $adoption)
                        <div class="col-6 col-md-4 col-lg-2 d-flex align-self-stretch px-1">
                            <div class="card w-100 card-shadow-none hoverable">
                                <img class="card-img-top" src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}"
                                    width="120" alt="pet">
                                <div class="card-body d-flex flex-column text-small">
                                    <a class="card-text mb-2 text-primary"
                                        href="{{ route('buyer.adoptions.show', $adoption) }}">
                                        {{ $adoption->pet_name }}
                                    </a>
                                    <h5 class="font-weight-normal">Breed: {{ $adoption->breed->name }}</h5>
                                    <span>
                                        Free
                                    </span><br>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <a href="{{ route('buyer.sellers.show', $adoption->user->seller_account) }}">
                                            <img class="img-fluid rounded-circle"
                                                src="{{ handleNullAvatar($adoption->user->avatar_thumbnail) }}"
                                                width="30" title="{{ $adoption->user->full_name }}" alt="avatar">
                                        </a>
                                        <div>
                                            @if ($adoption->user->avg_ratings)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i > $adoption->user->avg_ratings)
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $adoptions->links() }}
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
