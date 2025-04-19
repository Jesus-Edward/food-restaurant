
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
      aria-labelledby="v-pills-settings-tab">
      <div class="fp_dashboard_body fp__change_password">
          <div class="fp__message">
              <h3>Message</h3>
              <div class="fp__chat_area">
                  <div class="fp__chat_body">
                      {{-- <div class="fp__chating">
                          <div class="fp__chating_img">
                              <img src="images/service_provider.png" alt="person"
                                  class="img-fluid w-100">
                          </div>
                          <div class="fp__chating_text">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                              </p>
                              <span>15 Jun, 2023, 05:26 AM</span>
                          </div>
                      </div> --}}
                      {{-- <div class="fp__chating tf_chat_right">
                          <div class="fp__chating_img">
                              <img src="images/client_img_1.jpg" alt="person"
                                  class="img-fluid w-100">
                          </div>
                          <div class="fp__chating_text">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                              </p>
                              <span>15 Jun, 2023, 05:26 AM</span>
                          </div>
                      </div> --}}
                  </div>
                  <form class="fp__single_chat_bottom chat_input">
                    @csrf
                      <input  type="hidden" name="msg_temp_id" class="msg_temp_id" value="">
                      <input type="text" placeholder="Type a message..." class="fp_send_message" name="message" id="input_field">
                      <input type="hidden" name="receiver_id" value="1">
                      <button class="fp__massage_btn" type="submit" id="btn_submit" disabled="disabled">
                            <i class="fas fa-paper-plane"
                        aria-hidden="true"></i></button>

                  </form>
              </div>
          </div>
      </div>
  </div>


@push('scripts')
    <script>
        $(document).ready(function(){
            var userId = "{{ auth()->user()->id }}";

            function scrollToBottom() {
                let chatContent = $('.fp__chat_body');
                chatContent.scrollTop(chatContent.prop("scrollHeight"));
            }

            // Send message
            $('.chat_input').on('submit', function(e){
                e.preventDefault();

                var msgId = Math.floor(Math.random() * (1 - 10000 + 1)) + 10000;
                $('.msg_temp_id').val(msgId);
                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "{{ route('chat.send-message') }}",
                    data: formData,
                    beforeSend: function() {
                        let message = $('#input_field').val();
                        let html = `
                            <div class="fp__chating tf_chat_right">
                                <div class="fp__chating_img">
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="person"
                                        class="img-fluid w-100" style="border-radius: 50%;">
                                </div>
                                <div class="fp__chating_text" style=" padding: -2px">
                                    <p>${message}</p>
                                    <span class="msg_sending ${msgId}">sending...</span>
                                </div>
                            </div>
                        `
                        $(".fp__chat_body").append(html);
                        //$(".fp__chat_body").val('');
                        scrollToBottom();
                        if($("#input_field").val('')){
                            $("#btn_submit").prop('disabled', true);
                        }else{
                            $("#btn_submit").prop('disabled', false);
                        }

                    },
                    success: function(response) {
                        if ($('.msg_temp_id').val() == response.msgId) {
                            $('.'+msgId).remove();
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                })
            });

            $("#input_field").on('input change', function() {
                if($(this).val() != '') {
                    $("#btn_submit").prop('disabled', false);
                }else{
                    $("#btn_submit").prop('disabled', true);
                }
            });

            //Fetches users conversation

            $('.fp_chat_message').on('click', function(){
                let senderId = 1;
                //let receiver_id = {{ auth()->user()->id }}
                $.ajax({
                    method: 'GET',
                    url: "{{ route('chat.get-message', ':senderId') }}".replace(":senderId", senderId),
                    beforeSend: function(){

                    },
                    success: function(response) {
                        $('.fp__chat_body').empty();

                        $.each(response, function(index, message) {
                            let avatar =  message.sender.avatar;

                            let html = `
                                <div class="fp__chating ${message.sender_id == userId ? 'tf_chat_right' : ''}">
                                    <div class="fp__chating_img">
                                        <img src="${avatar}" style="border-radius: 50%; width: 50px; height: 50px; margin-top: -5px; object-fit: cover;" alt="person"
                                            class="img-fluid w-100">
                                    </div>
                                    <div class="fp__chating_text" style="margin-left: 10px; margin-right: 13px; margin-top: -2px;">
                                        <p style="padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;">${message.message}</p>

                                    </div>
                                </div>
                            `
                            $('.fp__chat_body').append(html);
                            $('.unseen_message_count').text(0);
                        });

                        scrollToBottom();
                    },
                    error: function(xhr, status, error){

                    }
                });
            })
        });
    </script>

@endpush
