@extends('layouts.seller.app')

@section('title', "$app_name | Create Pet for Adoption")

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
                    Create Pet for Adoption
                </li>
            </ol>
        </nav>

        <div class="alert alert-primary alert-dismissible fade show p-3 text-white" role="alert">
            Note: To verify your status as the pet owner, we kindly request you to provide a proof of
            ownership. In case you do not possess any documentation, please submit a photo of yourself
            with or next to the pet subject. For more info you may visit our <a class="text-white text-underline"
                href="#">FAQS</a>
            page.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.includes.alert')
                        <form action="{{ route('seller.adoptions.store') }}" method="post" id="adoption_form">
                            @csrf


                            <div class="form-group mb-3">
                                <label class="form-label">Pet Name *</label>
                                <input class="form-control form-control-sm" type="text" name="pet_name"
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-control form-control-sm" name="category_id" required
                                    onchange="showInputs(this)">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            data-has_vaccination='{{ $category->has_vaccination }}'
                                            data-has_deworming="{{ $category->has_deworming }}"
                                            @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label">Breed *</label>
                                <select class="form-control form-control-sm" name="breed_id" required>
                                    <option value=""></option>
                                    @foreach ($breeds as $id => $breed)
                                        <option value="{{ $id }}"
                                            @if (old('breed_id') == $id) selected @endif>{{ $breed }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Breed Type</label>
                                <select class="form-control form-control-sm" name="type">
                                    <option value=""></option>
                                    <option value="pure breed" @if (old('type') == 'pure breed') selected @endif>
                                        Pure Breed
                                    </option>
                                    <option value="cross breed" @if (old('type') == 'cross breed') selected @endif>
                                        Cross Breed
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Sex</label>
                                <select class="form-control form-control-sm" name="sex">
                                    <option value=""></option>
                                    <option value="male" @if (old('sex') == 'male') selected @endif>
                                        Male
                                    </option>
                                    <option value="female" @if (old('sex') == 'female') selected @endif>
                                        Female
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Birth Date *</label>
                                <input type="date" class="form-control form-control-sm" name="birth_date"
                                    value="{{ formatDate(old('birth_date'), 'dateInput') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Color *</label>
                                <input type="text" class="form-control form-control-sm" name="color"
                                    value="{{ old('color') }}" required>
                            </div>


                            {{-- show vaccination record if the category has a vaccination --}}
                            <div class="d-none" id="show_vaccination_record_radio_button">
                                <div class="form-group mb-3">
                                    <label class="form-label">Has Vaccination Record? *</label> <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_vaccination_yes" name="has_vaccination"
                                            class="custom-control-input has_vaccination" value="1">
                                        <label class="custom-control-label" for="has_vaccination_yes"
                                            @if (old('has_vaccination') == true) checked @endif>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_vaccination_no" name="has_vaccination"
                                            class="custom-control-input has_vaccination" value="0">
                                        <label class="custom-control-label" for="has_vaccination_no"
                                            @if (old('has_vaccination') == false) checked @endif>
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="d-none" id="show_vaccination_record_file_input">
                                    <input class="vaccination_history_input" type="file"
                                        name="vaccination_history_image[]" multiple>
                                </div>
                            </div>

                            {{-- show deworming record if the category has a deworming --}}
                            <div class="d-none" id="show_deworming_record_radio_button">
                                <div class="form-group mb-3">
                                    <label class="form-label">Has Deworming Record? *</label> <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_deworming_yes" name="has_deworming"
                                            class="custom-control-input has_deworming" value="1"
                                            @if (old('has_deworming') == true) checked @endif>
                                        <label class="custom-control-label" for="has_deworming_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="has_deworming_no" name="has_deworming"
                                            @if (old('has_deworming') == false) checked @endif
                                            class="custom-control-input has_deworming" value="0">
                                        <label class="custom-control-label" for="has_deworming_no">
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div class="d-none" id="show_deworming_record_file_input">
                                    <input class="deworming_history_input" type="file"
                                        name="deworming_history_image[]" multiple>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Reason for Adoption *</label>
                                <input type="text" class="form-control form-control-sm" name="reason"
                                    value="{{ old('reason') }}" required>
                            </div>

                            <div>
                                <input type="file" class="pet_avatar" name="avatar">
                            </div>

                            <div>
                                <input type="file" class="pet_featured_photos" name="featured_photos[]" multiple>
                            </div>

                            <div>
                                <input type="file" class="proof_of_ownership" name="proof_of_ownership">
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm w-100"
                                    onclick="promptStore(event, '#adoption_form')">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
@section('script')

    <script>
        function showInputs(category) {

            // Get the radio button elements for vaccination
            const hasVaccinationYes = document.getElementById('has_vaccination_yes');
            const hasVaccinationNo = document.getElementById('has_vaccination_no');

            // Get the elements to show/hide for vaccination
            const showVaccinationRecordRadioButton = document.getElementById('show_vaccination_record_radio_button');
            const showVaccinationRecordFileInput = document.getElementById('show_vaccination_record_file_input');


            // Get the radio button elements for deworming
            const hasDewormingYes = document.getElementById('has_deworming_yes');
            const hasDewormingNo = document.getElementById('has_deworming_no');

            // Get the elements to show/hide for deworming
            const showDewormingRecordRadioButton = document.getElementById('show_deworming_record_radio_button');
            const showDewormingRecordFileInput = document.getElementById('show_deworming_record_file_input');



            if (category.value !== "") {

                // ******************** For Vaccination Record Logic


                const has_vaccination = $(category).find(":selected").attr('data-has_vaccination');
                const has_deworming = $(category).find(":selected").attr('data-has_deworming');


                // Category has vaccination
                if (has_vaccination == true) {

                    showVaccinationRecordRadioButton.classList.remove('d-none'); // Show radio buttons

                }
                // Category does not have vaccination
                else {

                    showVaccinationRecordRadioButton.classList.add('d-none'); // Hide radio buttons
                    showVaccinationRecordFileInput.classList.add('d-none'); // Hide file input

                }

                // Add event listeners to radio buttons to show/hide file input based on selection
                hasVaccinationYes.addEventListener('change', function() {

                    initiateFilePond('.vaccination_history_input', ["image/png", "image/jpeg", "image/jpg",
                            "image/webp"
                        ],
                        'Select or <span class="filepond--label-action"> Browse Vaccination Record</span>')

                    showVaccinationRecordFileInput.classList.remove(
                        'd-none'); // Show file input when "Yes" is selected

                });

                hasVaccinationNo.addEventListener('change', function() {
                    showVaccinationRecordFileInput.classList.add('d-none'); // Hide file input when "No" is selected
                });



                // ******************** For Deworming Record Logic

                // Category has deworming
                if (has_deworming == true) {

                    showDewormingRecordRadioButton.classList.remove('d-none'); // Show radio buttons

                }
                // Category does not have deworming
                else {

                    showDewormingRecordRadioButton.classList.add('d-none'); // Hide radio buttons
                    showDewormingRecordFileInput.classList.add('d-none'); // Hide file input

                }

                // Add event listeners to radio buttons to show/hide file input based on selection
                hasDewormingYes.addEventListener('change', function() {

                    initiateFilePond('.deworming_history_input', ["image/png", "image/jpeg", "image/jpg",
                            "image/webp"
                        ],
                        'Select or <span class="filepond--label-action"> Browse Deworming Record</span>')

                    showDewormingRecordFileInput.classList.remove(
                        'd-none'); // Show file input when "Yes" is selected

                });

                hasDewormingNo.addEventListener('change', function() {
                    showDewormingRecordFileInput.classList.add('d-none'); // Hide file input when "No" is selected
                });


            } else {
                // Category does not have deworming
                showDewormingRecordRadioButton.classList.add('d-none'); // Hide radio buttons
                showDewormingRecordFileInput.classList.add('d-none'); // Hide file input
            }


        }
    </script>

    <script>
        initiateFilePond('.pet_avatar', ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            'Select or <span class="filepond--label-action"> Browse Avatar</span>')
        initiateFilePond('.pet_featured_photos', ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            'Select or <span class="filepond--label-action"> Browse Featured Photo </span>')
        initiateFilePond('.proof_of_ownership', ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            'Select or <span class="filepond--label-action"> Browse Proof of Ownership</span>')
    </script>
@endsection
