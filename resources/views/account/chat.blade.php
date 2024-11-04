@extends('template.generic')

@section('title', 'Chat')

@section('custom-header')
@endsection

@section('content')
    <!-- Start account chat Area -->
    <!-- char-area -->
    <section class="message-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="chat-area">
                        <!-- chatlist -->
                        <div class="chatlist">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="chat-header">
                                        <div class="msg-search">
                                            <input type="text" class="form-control" id="inlineFormInputGroup"
                                                placeholder="Search" aria-label="search">
                                            <ul class="action-btn">
                                                <li>
                                                    <a class="btn btn-sm rounded-circle border border-2 btn-outline-dark d-flex
                                                    justify-content-center align-items-center"
                                                        href=#><i class="bx bx-plus"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="Open-tab" data-bs-toggle="tab"
                                                    data-bs-target="#Open" type="button" role="tab"
                                                    aria-controls="Open" aria-selected="true">All Chats</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal-body p-0">
                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="Open" role="tabpanel"
                                                    aria-labelledby="Open-tab">
                                                    <!-- chat-list -->
                                                    <div class="chat-list">
                                                        @foreach ($userLists as $list)
                                                            <a href="{{ '/account/chat/' . $list->id }}"
                                                                class="d-flex align-items-center bg-light p-2"
                                                                style="{{ $user->id == $list->id ? 'background-color: #BCC1CA !important;' : '' }}">
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar">
                                                                        <span id="last-bidders-initial"
                                                                            class="avatar-initial rounded-circle bg-secondary">
                                                                            {{ $list->first_name[0] }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h3>{{ $list->first_name }}
                                                                    </h3>
                                                                    <p class="text-truncate" style="max-width: 40%">
                                                                        {{ $list->message }}</p>
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                    <!-- chat-list -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- chat-list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- chatlist -->

                        <!-- chatbox -->
                        <div class="chatbox">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="msg-head">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="d-flex align-items-center">
                                                    <span class="chat-icon"><img class="img-fluid"
                                                            src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg"
                                                            alt="image title"></span>
                                                    <div class="flex-shrink-0">
                                                        @if (isset($user))
                                                            <div class="avatar">
                                                                <span id="last-bidders-initial"
                                                                    class="avatar-initial rounded-circle bg-secondary">
                                                                    {{ $user->first_name[0] }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3>
                                                            @if (isset($user))
                                                                {{ $user->first_name }}
                                                            @endif
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <div class="msg-body">
                                            <ul>
                                                @foreach ($chats as $chat)
                                                    @if ($user->id == $chat->sender_id || $user->id == $chat->receiver_id)
                                                        <li
                                                            class="{{ $chat->sender_id == $user->id ? 'sender' : 'repaly' }}">
                                                            <p> {{ $chat->message }} </p>
                                                            <span class="time">{{ $chat->created_at }}</span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    @if (optional($user)->id)
                                        <div class="send-box">
                                            <form action="{{ route('chat.send', $user) }}" method="POST">
                                                @csrf
                                                <input type="text" class="form-control" aria-label="message…"
                                                    placeholder="Write message…" name="chat-message">

                                                <button class="bg-primary" type="submit"><i class="ni ni-paper-plane"
                                                        aria-hidden="true"></i>
                                                    Send <i class="bx bx-send"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatbox -->

                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- char-area -->
    <!-- End account chat Area -->
@endsection

@section('custom-js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let chatListLinks = document.querySelectorAll(".chat-list a");
            chatListLinks.forEach(function(link) {
                link.addEventListener("click", function() {
                    document.querySelector(".chatbox").classList.add('showbox');
                    return false;
                });
            });

            let chatIcon = document.querySelector(".chat-icon");
            chatIcon.addEventListener("click", function() {
                document.querySelector(".chatbox").classList.remove('showbox');
            });
        });

        var searchInput = document.getElementById("inlineFormInputGroup");

        searchInput.addEventListener("keyup", function() {
            var searchValue = this.value.toLowerCase();

            var chatListAnchors = document.getElementsByClassName("chat-list")[0].getElementsByTagName("a");

            for (var i = 0; i < chatListAnchors.length; i++) {
                var anchor = chatListAnchors[i];
                var name = anchor.querySelector("h3").textContent.toLowerCase();
                console.log(name.startsWith(searchValue));

                if (name.startsWith(searchValue)) {
                    anchor.classList.remove('d-none')
                } else {
                    anchor.classList.add('d-none')
                }
            }
        });
    </script>
@endsection
