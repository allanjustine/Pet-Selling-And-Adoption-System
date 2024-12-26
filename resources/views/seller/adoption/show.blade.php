@extends('layouts.seller.app')

@section('title', "$app_name | $adoption->pet_name")

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('seller.adoptions.index') }}">
                        All Pets
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $adoption->pet_name }}
                </li>
            </ol>
        </nav>

        @include('layouts.includes.alert')

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
                                src="{{ handleNullAvatarForPet($adoption->avatar_profile) }}" width="120" alt="avatar">
                            <br>
                            <h4 class="font-weight-normal">Name: {{ $adoption->pet_name }}</h4>
                            <h4 class="font-weight-normal">Breed: {{ $adoption->breed->name }}</h4>
                            <h4 class="font-weight-normal">Category: {{ $adoption->category->name }}</h4>
                            <h4 class="font-weight-normal">Sex: {{ $adoption->sex }}</h4>
                            <h4 class="font-weight-normal">Color: {{ $adoption->color }}</h4>
                            <h4 class="font-weight-normal">Birth Date: {{ formatDate($adoption->birth_date) }}</h4>
                            <h4 class="font-weight-normal">Age: {{ getPetAge($adoption->birth_date) }}</h4>
                            <h4 class="font-weight-normal">{!! isAdopted($adoption->is_adopted) !!}</h4> <br>
                            @if ($adoption->status == \App\Models\Adoption::APPROVED && !$adoption->is_adopted)
                                <a class="btn btn-sm btn-outline-primary" data-toggle="collapse" href="#mark_as_adopted"
                                    role="button" aria-expanded="false" aria-controls="mark_as_adopted">
                                    Mark as Adopted
                                </a>
                            @endif
                            <br>
                        </div>
                        @if ($adoption->status == \App\Models\Adoption::APPROVED && !$adoption->is_adopted)
                            <div class="collapse mt-3" id="mark_as_adopted">
                                <div class="card card-body">
                                    <h3>Who adopted your pet?</h3>
                                    <form action="{{ route('seller.adoptions.mark_as_adopted', $adoption) }}"
                                        method="POST" id="mark_as_adopted_form">
                                        @csrf @method('PUT')

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="selectOption">Select Adopter:</label>
                                            <select class="form-control form-control-sm" name="adopter_id"
                                                id="selectOption">
                                                <option value="">Select an option</option>
                                                @foreach ($buyers as $buyer)
                                                    <option value="{{ $buyer->id }}">{{ $buyer->full_name }}</option>
                                                @endforeach
                                                <option value="others">Others</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 d-none customInputContainer">
                                            <label class="form-label">Complete Name:</label>
                                            <input type="text" class="form-control form-control-sm" name="adopter_name"
                                                placeholder="Your Name">
                                        </div>


                                        <div class="form-group mb-3 d-none customInputContainer">
                                            <div class="form-label">Contact</div>
                                            <input type="number" min="0" class="form-control form-control-sm"
                                                name="adopter_contact" placeholder="Eg. 09659312005">
                                        </div>

                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="promptStore(event, '#mark_as_adopted_form')">Submit</button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- if its adopted show the details --}}
                        @if ($adoption->is_adopted)
                            <div class="card">
                                <div class="card-header bg-primary text-white">Pet Adopter <i class="fas fa-paw ml-1">
                                    </i>

                                </div>
                                <div class="card-body text-center">
                                    @if ($adoption->adopter)
                                        <img class="img-fluid rounded-circle d-block mx-auto mb-3"
                                            src="{{ handleNullAvatar($adoption->adopter->avatar_profile) }}"
                                            width="75" alt="avatar">

                                        <h4 class="font-weight-normal">Name: {{ $adoption->adopter->full_name }}</h4>
                                        <h4 class="font-weight-normal">Contact: {{ $adoption->adopter->contact }}</h4>
                                    @else
                                        <img class="img-fluid rounded-circle d-block mx-auto mb-3"
                                            src="{{ asset('img/noimg.svg') }}" width="75" alt="avatar">
                                        <h4 class="font-weight-normal">Name: {{ $adoption->adopter_name }}</h4>
                                        <h4 class="font-weight-normal">Contact: {{ $adoption->adopter_contact }}</h4>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                {{-- Start Row 2 --}}
                <div class="row">
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
                                            @forelse ($adoption->getMedia('vaccination_history') as $vaccination_history)
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
                                            @forelse ($adoption->getMedia('deworming_history') as $deworming_history)
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

@section('script')
    <script>
        $(document).ready(function() {
            // Show/hide custom input based on the selected option
            $('#selectOption').on('change', function() {
                const selectedValue = $(this).val();
                let customInputContainer = document.querySelectorAll('.customInputContainer');


                if (selectedValue === 'others') {
                    customInputContainer.forEach((input) => {
                        $(input).removeClass('d-none');
                    })
                } else {
                    customInputContainer.forEach((input) => {
                        $(input).addClass('d-none');
                    })
                }
            });
        });
    </script>
@endsection
