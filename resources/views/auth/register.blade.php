@extends('layouts.main.app')

@section('title', "$app_name | Create an Account")

@section('content')
    <!-- Page content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 px-3 mb-5">
                <br>

                {{-- User Form --}}
                <fieldset>
                    <legend>
                        <h4 class="text-white"> <a class="text-white font-weight-bold" href="{{ route('auth.login') }}"><i
                                    class="fas fa-arrow-left"></i></a> <span class="ml-2">Register</span></h4>
                    </legend>

                    <div class="alert alert-dark  alert-dismissible fade show p-3 text-white" role="alert">
                        Welcome to {{ config('app.name') }} To get started, simply fill out the registration form and create
                        your account. Once you've done that, you'll have access to our full range of pets, pet community,
                        and
                        special offers. Plus, you'll be able to manage your orders, track orders, and much more.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    @include('layouts.includes.alert')


                    <form action="{{ route('auth.attemptRegister') }}" method="post">
                        @csrf

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="first_name" placeholder="First Name *"
                                    value="{{ old('first_name') }}" autocomplete="name" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="middle_name" placeholder="Middle Name"
                                    value="{{ old('middle_name') }}" autocomplete="name" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="last_name" placeholder="Last Name *"
                                    autocomplete="name" value="{{ old('last_name') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                </div>
                                <select class="form-control" name="sex">
                                    <option value="">Sex *</option>
                                    <option value="male" @if (old('sex') == 'male') selected @endif>Male</option>
                                    <option value="female" @if (old('sex') == 'female') selected @endif>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input class="form-control" type="date" name="birth_date" max="2004-01-01"
                                    value="{{ formatDate(old('birth_date'), 'dateInput') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                                </div>
                                <input class="form-control" type="text" name="address" placeholder="Complete Address *"
                                    autocomplete="address-level1" value="{{ old('address') }}" required>
                            </div>
                        </div>

                        {{-- <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                                </div>
                                <select class="form-control" name="barangay_id">
                                    <option value="">Select Barangay *</option>
                                    <option value=""></option>
                                    @foreach ($barangays as $id => $barangay)
                                        <option value="{{ $id }}"
                                            @if (old('barangay_id') == $id) selected @endif>{{ $barangay }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input class="form-control" type="number" min="0" name="contact"
                                    placeholder="Contact Ex. 09659312001 *" autocomplete="tel-local"
                                    value="{{ old('contact') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" type="email" name="email" placeholder="Email *"
                                    autocomplete="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" type="password" name="password" placeholder="Password *"
                                    autocomplete="new-password" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" type="password" name="password_confirmation"
                                    placeholder="Re-type Password" autocomplete="new-password" required>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="role_id" value="3">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark form-control">Register</button>
                        </div>
                        <br>
                        <div class="text-sm text-white text-center">
                            Already have an account?
                            <a href="{{ route('auth.login') }}" style="text-decoration: underline; color: #fff">Login</a>
                        </div>
                    </form>
                </fieldset>
                {{-- End User Form --}}


            </div>
        </div>
    </div>
@endsection
