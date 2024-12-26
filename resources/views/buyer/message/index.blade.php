@extends('layouts.buyer.app')

@section('title', "$app_name | Inbox")

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('messages.create') }}" method="GET">
                    <div class="input-group">
                        <select class="selectpicker show-tick" data-style='btn-white text-dark' data-live-search="true"
                            data-width='300px' name="user">
                            <optgroup label="All Seller">
                                @foreach ($sellers as $seller)
                                    <option data-tokens="{{ $seller->name }}" value="{{ $seller->id }}">
                                        {{ $seller->full_name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary text-white"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @include('layouts.includes.alert')
                <div class="row mt-3">
                    @forelse ($participants as $participant)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    {{-- Content --}}
                                    <div class="row align-items-center">
                                        {{-- Logo --}}
                                        <div class="col-3">
                                            <img class="d-block mx-auto rounded-circle"
                                                src="{{ handleNullAvatar($participant->avatar_profile) }}" width="60"
                                                alt="{{ $participant->full_name }}">
                                        </div>

                                        {{-- dorm Info --}}
                                        <div class="col-9">
                                            <a class="text-small"
                                                href="{{ route('messages.create') }}?user={{ $participant->id }}">
                                                {{ $participant->full_name }}
                                            </a>
                                            {{-- <h5 class="font-weight-normal">
                                                Active {{ $participant->created_at->diffForHumans() }}
                                            </h5> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <figure>
                            <img class="img-fluid" src="{{ asset('img/nodata.svg') }}" alt="empty">
                        </figure>
                    @endforelse

                    <div class="d-flex ml-auto">
                        {{-- {{ $participants->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection

@section('script')
    <script>
        $(() => {
            $('#message').selectpicker()
        })
        $('#message_nav').addClass('active')
    </script>
@endsection
