@extends('layouts.seller.app')

@section('title', "$app_name | adoption Adoption Management")

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
                                    href="{{ route('seller.adoptions.index') }}?category={{ $id }}">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a class="float-right btn btn-sm btn-primary me-3 text-smallest"
                        href="{{ route('seller.adoptions.create') }}">Create adoption +</a><br>
                </h4>

                {{-- Start ROW --}}
                <div class="row">

                    @if ($adoptions->isNotEmpty())
                        @foreach ($adoptions as $adoption)
                            <div class="col-md-12" id="adoption_row-{{ $adoption->id }}">
                                <div class="card">


                                    <div class="card-body">

                                        {{-- Content --}}
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <img class="d-block mx-auto rounded-circle"
                                                    src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}"
                                                    width="80" alt="{{ $adoption->pet_name }}">
                                            </div>
                                            <div class="col-8">
                                                <div class='dropdown float-right'>
                                                    <a class='btn btn-sm btn-icon-only text-light' href='javascript:void(0)'
                                                        role='button' data-toggle='dropdown' data-display="static"
                                                        aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </a>
                                                    <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                                                        <a href="{{ route('seller.adoptions.show', $adoption) }}"
                                                            class="dropdown-item">
                                                            View
                                                        </a>

                                                        @if ($adoption->status === \App\Models\Adoption::PENDING)
                                                            <a href="{{ route('seller.adoptions.edit', $adoption) }}"
                                                                class="dropdown-item">
                                                                Edit
                                                            </a>
                                                        @endif

                                                        <a class="dropdown-item" href='javascript:void(0)'
                                                            onclick="promptDestroy(event, '#remove_adoption-{{ $adoption->id }}')">
                                                            Delete
                                                        </a>


                                                        <form action="{{ route('seller.adoptions.destroy', $adoption) }}"
                                                            method="POST" id="remove_adoption-{{ $adoption->id }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary">
                                                        {{ $adoption->pet_name }} | {{ $adoption->category->name }}
                                                    </h4>
                                                    <h5 class="font-weight-normal">
                                                        {{ $adoption->created_at->diffForHumans() }}
                                                    </h5>

                                                    @if ($adoption->is_adopted)
                                                        <h5 class="font-weight-normal">
                                                            <span class="badge badge-success">Adopted <i
                                                                    class="fas fa-check-circle ml-1"> </i></span>
                                                        </h5>
                                                    @else
                                                        <h5 class="font-weight-normal">
                                                            {!! isApproved($adoption->status) !!}
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
                                        href="{{ route('seller.adoptions.create') }}">add adoption?</a></p>
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
