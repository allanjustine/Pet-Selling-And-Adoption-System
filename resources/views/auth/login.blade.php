@extends('layouts.main.app')

@section('title', "$app_name | Login")

@section('content')

    {{-- @section('bg', 'bg-warning') --}}
    <!-- Page content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 px-5 mt-6">
                <img class="img-fluid d-block mx-auto" src="{{ asset('img/auth/1.svg') }}" width="200" alt="logo"> <br>
                {{-- Form --}}
                <form action="{{ route('auth.attemptLogin') }}" method="post">
                    @csrf

                    <h3 class="text-center text-white font-weight-bold">Welcome to Furfect!</h3>
                    <h5 class="text-center text-white font-weight-bold">An online platform for Pet lovers</h5> <br>

                    @include('layouts.includes.alert')

                    <div class="form-group mb-3">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control" type="email" name="email" placeholder="Email"
                                autocomplete="email" value="admin@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend" id="password">
                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                            </div>
                            <input class="form-control" type="password" name="password" placeholder="Password"
                                autocomplete="new-password" value="test1234" id="password_field" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <a class="text-sm text-white" href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-dark form-control">Login</button>
                    </div>
                    <br>
                    <div class="text-sm text-white text-center">
                        Not yet registered?
                        <a href="{{ route('auth.register') }}" style="text-decoration: underline; color: #fff">Register</a>
                    </div>
                </form>
                {{-- End Form --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     if (handleApplicationDisplay() == "browser") {
        //         location.href = window.location.origin + "/install";
        //         return;
        //     }

        //     function handleApplicationDisplay() {
        //         const isStandalone = window.matchMedia(
        //             "(display-mode: standalone)"
        //         ).matches;
        //         if (document.referrer.startsWith("android-app://")) {
        //             return "twa";
        //         } else if (navigator.standalone || isStandalone) {
        //             return "standalone";
        //         }
        //         return "browser";
        //         // if the user didnt install the app, always redirect to the root_url/install
        //         // browser
        //     }
        // })

        const password_field = document.getElementById('password_field');
        document.getElementById('password').addEventListener('click', function() {
            return password_field.getAttribute('type') == "password" ?
                password_field.setAttribute('type', 'text') :
                password_field.setAttribute('type', 'password')
        })
    </script>
@endsection
