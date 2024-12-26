@extends('layouts.main.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white text-primary">
                        <a class="" href="{{ route('auth.login') }}"> <i class="fas fa-chevron-left mr-1"></i></a>
                        <span class="ml-2">
                            Reset Password
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{-- {{ session('status') }} --}}
                                <p>
                                    A password reset link has been sent to your email address. Email not found? Please check
                                    your email spam folder.
                                </p>
                            </div>
                        @endif


                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="img-fluid" src="{{ asset('img/auth/mail.svg') }}" alt="password_reset.svg"
                                        width="300">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email * </label>

                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="You@email.com" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
