@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chat Box</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Components</a></div>
            <div class="breadcrumb-item">Chat Box</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 h-100">
                <div class="card" style="height: 70vh">
                    <div class="card-header">
                        <h4>Who's Online?</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach($senders as $sender)
                                @php
                                    $userChat = \App\Models\User::find($sender->sender_id);
                                    $unseenMessages = \App\Models\Chat::where(['sender_id' => $userChat->id,
                                    'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                                @endphp
                                <li class="media fp_chat_user" data-name="{{ $userChat->name }}" data-user="{{ $userChat->id }}" style="cursor: pointer">
                                    <img alt="image" class="mr-3 rounded-circle" width="50"
                                        src="{{ asset($userChat->avatar) }}" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;">
                                    <div class="media-body">
                                        <div class="mt-0 mb-1 font-weight-bold">{{ $userChat->name }}</div>
                                        <div class="text-warning text-small font-600-bold got_new_message"></div>
                                        @if ($unseenMessages > 0)
                                            {{-- <i class=""></i>New Message --}}
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-9">
                <div class="card chat-box" id="mychatbox" data-inbox="" style="height: 70vh">
                    <div class="card-header">
                        <h4 id="chat_header"></h4>
                    </div>
                    <div class="card-body chat-content">

                    </div>
                    <div class="card-footer chat-form">
                        <form id="chat-form">
                            @csrf
                            <input type="text" class="form-control" placeholder="Type a message"
                             id="admin_input_field" name="admin_message">
                            <input type="hidden" value="" name="receiver_id" id="receiver_id">
                            <input  type="hidden" name="msg_temp_id" class="msg_temp_id" value="">
                            <button class="btn btn-primary" id="admin_submit_btn" disabled="disabled">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var userId = {{ auth()->user()->id }};
            $('#receiver_id').val("");

            function scrollToBottom() {
                let chatContent = $('.chat-content');
                chatContent.scrollTop(chatContent.prop("scrollHeight"));
            }

            //Fetching users messages
            $('.fp_chat_user').on('click', function() {
                let senderId = $(this).data('user');
                let senderName = $(this).data('name');
                let clickedElement = $(this);
                $("#mychatbox").attr('data-inbox', senderId);
                $('#receiver_id').val(senderId);
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.chat.get-message', ':senderId') }}".replace(":senderId", senderId),
                    beforeSend: function(){
                        $('.chat-content').empty();
                        $("#chat_header").text(senderName);
                    },
                    success: function(response) {
                        $('.chat-content').empty();

                        $.each(response, function(index, message) {
                            let avatar =  message.sender.avatar;

                            let html = `
                                <div class="chat-item ${ message.sender_id === userId ? "chat-right" : "chat-left" } "
                                    style=""><img src="${ avatar }" style="border-radius: 50%; width: 50px; height: 50px; margin-top: -5px; object-fit: cover;">
                                    <div class="chat-details">
                                        <div class="chat-text">${message.message}</div>
                                    </div>
                                </div>
                            `
                            $('.chat-content').append(html);
                        });
                        clickedElement.find('.got_new_message').html("");

                        scrollToBottom();
                    },
                    error: function(xhr, status, error){

                    }
                });
            });

            //Sending admin message
            $("#chat-form").on('submit', function(e){
                e.preventDefault();
                
                var msgId = Math.floor(Math.random() * (1 - 10000 + 1)) + 10000;
                $('.msg_temp_id').val(msgId);

                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.chat.send-message') }}",
                    data: formData,
                    beforeSend: function() {
                        let message = $('#admin_input_field').val();
                        let html = `
                            <div class="chat-item chat-right" style=""><img src="{{ asset(auth()->user()->avatar) }}" style="border-radius: 50%; width: 50px; height: 50px; margin-top: -5px; object-fit: cover;"><div
                                class="chat-details" style="margin-right: 60px;"><div
                                class="chat-text" padding-top: 14px !important;
                                                  padding-right: 15px;
                                                  padding-bottom: 14px !important;
                                                  padding-left: 15px;>${message}</div>
                                <div class="chat-time ${msgId}">sending...</div></div>
                            </div>
                        `
                        $(".chat-content").append(html);
                        $(".chat-content").val('');
                        scrollToBottom();

                        // Remove beep notification

                        $(".fp_chat_user").each(function(){
                            let senderId = $(this).data('user');

                            if ($("#mychatbox").attr('data-inbox') == senderId) {
                                $(this).find('.got_new_message').html("");
                            }
                        })

                        if($("#admin_input_field").val('') || $("#receiver_id").val('')){
                            $("#admin_submit_btn").prop('disabled', true);
                        }else{
                            $("#admin_submit_btn").prop('disabled', false);
                        }

                    },
                    success: function(response) {
                        if ($('.msg_temp_id').val() === response.msgId) {
                            $('.'+msgId).remove();
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                })
            });

            $("#admin_input_field").on('input change', function() {
                if($("#admin_input_field").val() != '' && $("#receiver_id").val() != '') {
                    $("#admin_submit_btn").prop('disabled', false);
                }else{
                    $("#admin_submit_btn").prop('disabled', true);
                }
            });
        })
    </script>
@endpush
