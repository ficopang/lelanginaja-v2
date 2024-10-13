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
                                            <a class="add" href=#><img class="img-fluid"
                                                    src="https://mehedihtml.com/chatbox/assets/img/add.svg"
                                                    alt="add"></a>
                                        </div>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="Open-tab" data-bs-toggle="tab"
                                                    data-bs-target="#Open" type="button" role="tab"
                                                    aria-controls="Open" aria-selected="true">All Chats</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal-body">
                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="Open" role="tabpanel"
                                                    aria-labelledby="Open-tab">
                                                    <!-- chat-list -->
                                                    <div class="chat-list">
                                                        @foreach ($userLists as $list)
                                                            <a href="{{ '/account/chat/' . $list->id }}"
                                                                class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 fs-4 m-2 ">
                                                                    <i class="lni lni-user"></i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>{{ $list->first_name }}
                                                                    </h3>
                                                                    <p>{{ $list->message }}</p>
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
                                                    <div class="flex-shrink-0 fs-4 m-2">
                                                        <i class="lni lni-user"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
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

                                                <button type="submit"><i class="ni ni-paper-plane" aria-hidden="true"></i>
                                                    Send</button>
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
