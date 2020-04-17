$(document).ready(function() {
    $(".emoji").on("click", function() {
        // Here we are getting the reaction which is tapped by using the data-reaction attribute defined in main page
        var data_reaction = $(this).attr("data-reaction");
        var message_id = $(this).attr("message-id");
        // Sending Ajax request in handler page to perform the database operations
        $.ajax({
            type: "POST",
            url: "like.php",
            data: { data_reaction: data_reaction, message_id: message_id },
            success: function(response) {
                // This code will run after the Ajax is successful
                $(".reaction-btn-text." + message_id).text(data_reaction).removeClass().addClass('reaction-btn-text ' + message_id).addClass('reaction-btn-text-' + data_reaction.toLowerCase()).addClass("active");
                $(".like-emo." + message_id).html('<span class="like-btn-' + data_reaction.toLowerCase() + '"></span>');
            }
        })
    });

    $(".reaction-btn-text").on("click", function() { // undo like click
        if ($(this).hasClass("active")) {

            var message_id = $(this).attr("message-id");

            // Sending Ajax request in handler page to perform the database operations
            $.ajax({
                type: "POST",
                url: "undo_like.php",
                data: { message_id: message_id },
                success: function(response) {
                    // Handle when the Ajax is successful
                    $(".reaction-btn-text." + message_id).text("Like").removeClass().addClass('reaction-btn-text ' + message_id);
                    $(".like-emo." + message_id).html("");
                }
            })
        }
    })
});