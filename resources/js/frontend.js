function scrollToBottom() {
    let chatContent = $('.fp__chat_body');
    chatContent.scrollTop(chatContent.prop("scrollHeight"));
}

window.Echo.private("chat."+loggedInUserId).listen(
    'ChatEvent', (e) => {
        console.log(e);

        let html = `
            <div class="fp__chating">
                <div class="fp__chating_img">
                <img src="${e.avatar}" style="border-radius: 50%; width: 50px; height: 50px; margin-top: -5px; object-fit: cover;" alt="person"
                    class="img-fluid w-100">
                </div>
            <div class="fp__chating_text" style="margin-left: 10px; margin-right: 13px; margin-top: -2px;">
                <p style="padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;">${e.message}</p>
                    <span>sending...</span>
                </div>
            </div>
        `
        $('.fp__chat_body').append(html);

        scrollToBottom();
        $('.unseen_message_count').text(1)
    }
);
