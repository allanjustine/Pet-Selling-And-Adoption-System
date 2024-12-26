@extends('layouts.admin.app')

@section('title', 'Manage Profile')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <form action="{{ route('profile.update', auth()->id()) }}" method="POST"
                class="col-md-5 mx-auto bg-white p-5 rounded" id="profile_form">
                @csrf @method('PUT')

                <img src="{{ handleNullAvatar(auth()->user()->avatar_profile) }}"
                    class="img-fluid rounded-circle d-block mx-auto" width='100' alt="avatar.svg">
                <br>

                @include('layouts.includes.alert')

                <div class="form-group mb-3 ">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control form-control-sm" value="{{ auth()->user()->full_name }}"
                        readonly>
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" value="{{ auth()->user()->email }}" readonly>
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">Current Password</label>
                    <input type="text" class="form-control form-control-sm"" name=" old">
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control form-control-sm"" name=" password" placeholder="•••••••••"
                        autocomplete="new-password">
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control form-control-sm"" name=" password_confirmation"
                        placeholder="•••••••••" autocomplete="new-password">
                </div>

                <input type="file" name="avatar" id="user_image">
                <button type="button" class="btn btn-primary form-control"
                    onclick="event.preventDefault();confirm('Do you want to update?', '', 'update').then(res => res.isConfirmed ? $('#profile_form').submit() : false)">Update
                    Profile </button>
            </form>
        </div>
    </div>
    {{-- End CONTAINER --}}
@endsection
@section('script')
    <script>
        initiateFilePond('#user_image', ["image/png", "image/jpeg", "image/jpg", "image/webp"],
            'Drag & Drop or <strong>Browse</strong> Avatar')

        $('#profile_nav').addClass('active')
    </script>
@endsection
