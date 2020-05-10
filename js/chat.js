$(document).ready(function() {
    $(".sendMessage").on("click", function() {
        //Get the text from the input field
        var messageText = $(".messageText").val();
        //Ajax call
        $.ajax({
            type: "POST",
            url: "chat.php",
            data: { content: messageText },
            success: function(response) {}
        })
    });

    $(".emoji").on("click", function() {
        //Get the reaction from the data-reaction attribute
        var data_reaction = $(this).attr("data-reaction");
        var message_id = $(this).attr("message-id");
        $.ajax({
            type: "POST",
            url: "chat.php",
            data: { like: 1, data_reaction: data_reaction, message_id: message_id },
            success: function(response) {
                //Change the reaction if the call is succesful
                $(".reaction-btn-text." + message_id).text(data_reaction).removeClass().addClass('reaction-btn-text ' + message_id).addClass('reaction-btn-text-' + data_reaction.toLowerCase()).addClass("active");
                $(".like-emo." + message_id).html('<span class="like-btn-' + data_reaction.toLowerCase() + '"></span>');
            }
        })
    });

    $(".reaction-btn-text").on("click", function() {
        //Undo the reaction by clicking on the like
        if ($(this).hasClass("active")) {
            var message_id = $(this).attr("message-id");
            $.ajax({
                type: "POST",
                url: "chat.php",
                data: { like: 0, message_id: message_id },
                success: function(response) {
                    $(".reaction-btn-text." + message_id).text("Like").removeClass().addClass('reaction-btn-text ' + message_id);
                    $(".like-emo." + message_id).html("");
                }
            })
        }
    })
});

//Force the chatbox to scroll to the bottom so the newest messages get displayed
function updateScroll() {
    var messagebox = document.querySelector(".messagebox");
    messagebox.scrollTop = messagebox.scrollHeight;
}