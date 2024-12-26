@extends('layouts.seller.app')

@section('title', "$app_name | Messages")

@section('styles')
    <style>
        body {
            background-color: #f4f7f6;
        }

        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: 0, 0, 0, .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
            overflow-x: auto !important;
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7;
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .my-message {
            background: #efefef
        }

        .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #efefef;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .other-message {
            background: #e8f1f3;
            text-align: right
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #e8f1f3;
            left: 93%
        }

        .chat .chat-message {
            padding: 20px
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }

        /*Extra Large Screen Size*/
        @media only screen and (min-width: 992px) and (max-width: 2400px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }
    </style>
@endsection

@section('content')
    {{-- CONTAINER --}}
    <div class="container mt-3">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card-header bg-gray">
                    <div class="card-text text-white">
                        <a class="float-left text-white" href="{{ route('messages.index') }}"><i
                                class="fas fa-arrow-left mr-3"></i></a>
                        Messages <i class="fas fa-envelope ml-1"></i>
                    </div>
                </div>
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @foreach ($participants as $participant)
                                <a href="{{ route('messages.create') }}?user={{ $participant->id }}">
                                    <li class="clearfix @if ($participant->id === $recipient->id) active @endif">
                                        <img src="{{ handleNullAvatar($participant->avatar_profile) }}" alt="avatar">
                                        <div class="about">
                                            <div class="name text-sm">
                                                {{ $participant->full_name }}
                                            </div>
                                            <div class="status">
                                                @if ($participant->isOffline)
                                                    <i class="fa fa-circle offline"></i>
                                                    active {{ $participant?->updated_at->diffForHumans() }}
                                                @else
                                                    <i class="fa fa-circle online"></i>
                                                    Active
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                    {{-- Chart --}}
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="{{ handleNullAvatar($recipient->avatar_profile) }}" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h5 class="m-b-0">{{ $recipient->full_name }} <br>
                                            <small>Buyer</small>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-6 hidden-sm text-right">
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0" id="d_chat_history">
                                {{-- display chat history --}}
                                {{-- @forelse ($messages as $message)
                                    @if ($message->sender_id !== auth()->id())
                                        <li class="clearfix text-right">
                                            <div class="message-data text-right">
                                                <span
                                                    class="message-data-time">{{ formatDate($message->created_at, 'dateTime') }}</span>
                                                <img src="{{ handleNullAvatar($message->sender->avatar_profile) }}"
                                                    alt="avatar" title="{{ $message->sender->name }}">
                                            </div>
                                            <div class="message other-message float-right"> {{ $message->message }}</div>
                                        </li>
                                    @else
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <img src="{{ handleNullAvatar($message->sender->avatar_profile) }}"
                                                    alt="avatar" title="{{ $message->sender->name }}">
                                                <span
                                                    class="message-data-time">{{ formatDate($message->created_at, 'dateTime') }}</span>

                                            </div>
                                            <div class="message my-message">{{ $message->message }}</div>
                                        </li>
                                    @endif

                                @empty
                                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/nodata.svg') }}"
                                        width="350" alt="nodata">
                                    <p class="text-center">Empty Conversation</p>
                                @endforelse --}}
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <form id="message_form" enctype="multipart/form-data">
                                <input class="message_images" name="image[]" type="file" multiple
                                    data-max-file-size="3MB" data-max-files="3">
                                <div class="input-group mb-0">
                                    <input type="text" class="form-control" name="message" id="message"
                                        placeholder="Enter text here...">
                                    <input type="hidden" class="form-control" name="recipient_id" id="recipient_id"
                                        value="{{ $recipient->id }}">
                                    <div class="input-group-append" role="button">
                                        <button type="button" class="btn btn-primary" onclick="sendMessage()"><i
                                                class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
            getMessages()
            setInterval(() => {
                getMessages()
            }, 5000);
        })

        /*load messages from the buyer*/
        async function getMessages() {

            const auth_user = @json(auth()->id());

            try {
                const res = await axios.get(route('messages.show', @json($recipient->id)))

                const messages = res.data.results;

                let output = '';

                let html_images = ''

                messages.forEach(message => {
                    if (message.sender_id !== auth_user) {

                        // if all messages are null && no image upload do not show
                        if (message.message == null && message.images.length == 0) {

                            output += ` `
                        } else if (message.message == null) {

                            output += `
                                    <li class="clearfix text-right">
                                            <div class="message-data text-right">
                                                <span
                                                    class="message-data-time">${message.created_at}</span>
                                                    ${handleNullAvatar(message.sender_avatar)}
                                            </div>
                                            <div class="message other-message float-right">
                                                ${getMessageImages(message)}
                                            </div>
                                        </li>
                                    `
                        } else {

                            output += `
                                    <li class="clearfix text-right">
                                            <div class="message-data text-right">
                                                <span
                                                    class="message-data-time">${message.created_at}</span>
                                                    ${handleNullAvatar(message.sender_avatar)}
                                            </div>
                                            <div class="message other-message float-right">
                                                <span>${message.message }</span>
                                                ${getMessageImages(message)}
                                            </div>
                                        </li>
                                        `
                        }
                    } else {

                        // if all messages are null && no image upload do not show
                        if (message.message == null && message.images.length == 0) {

                            output += ` `
                        } else if (message.message == null) {
                            output += `
                                     <li class="clearfix">
                                            <div class="message-data">
                                                ${handleNullAvatar(message.sender_avatar)}
                                                <span
                                                    class="message-data-time">${message.created_at}</span>

                                            </div>
                                            <div class="message my-message">
                                                ${getMessageImages(message)}
                                            </div>
                                        </li>`
                        } else {

                            output += `
                                     <li class="clearfix">
                                            <div class="message-data">
                                                ${handleNullAvatar(message.sender_avatar)}
                                                <span
                                                    class="message-data-time">${message.created_at}</span>

                                            </div>
                                            <div class="message my-message">
                                                <span>${message.message}</span> <br>
                                                ${getMessageImages(message)}
                                            </div>
                                        </li>
                                    `
                        }
                    }

                })
                $('#d_chat_history').html(output); // append output

            } catch (e) {
                log(e)
            }
        }

        /*send message to buyer*/
        async function sendMessage() {
            try {
                let form_data = new FormData($('#message_form')[0]);
                const res = await axios.post(route('messages.store'), form_data);
                const new_message = res.data.result
                let output;

                // if all messages are null && no image upload do not show
                if (new_message.message == null && new_message.images?.length == 0) {

                    output = ` `;

                } else if (new_message.message == null) {
                    output = `
                                    <li class="clearfix">
                                        <div class="message-data">
                                            ${handleNullAvatar(new_message.avatar)}
                                            <span
                                                class="message-data-time">${new_message.created_at}</span>

                                        </div>
                                        <div class="message my-message">
                                               ${getMessageImages(new_message)}
                                            </div>
                                    </li>`;
                } else {
                    output = `
                                    <li class="clearfix">
                                        <div class="message-data">
                                            ${handleNullAvatar(new_message.avatar)}
                                            <span
                                                class="message-data-time">${new_message.created_at}</span>

                                        </div>
                                        <div class="message my-message">
                                            <span>${new_message.message}</span> <br>
                                               ${getMessageImages(new_message)}
                                            </div>
                                    </li>`;
                }


                $('#d_chat_history').append(output); // append new message
                pond ? pond.removeFiles() : "";
                $('#message_form')[0].reset()
            } catch (e) {
                log(e)
                log(e.reponse)
                const responses = e.response.data.errors;
                if (responses) {
                    const errors = Object.values(responses);
                    errors.forEach((e) => {
                        toastDanger(e);
                    });
                } else {
                    error(e.response.data.message);
                }
            }
        }

        function getMessageImages(message) {
            let html_images = '';
            // if there is images
            if (message.images.length > 0) {
                message.images.forEach((img, index) => {
                    // html_images += `<img class='img-thumbnail' src='${img}' width='50'>`

                    html_images += `<a href="${img}" class="glightbox" data-gallery="gallery-${index}">
                                        <img class="img-thumbnail " src="${img}" width="50" alt="photo">
                                    </a>`;
                })
            }

            return html_images;
        }

        initiateFilePond('.message_images')
        $('#message_nav').addClass('active');
    </script>
@endsection
