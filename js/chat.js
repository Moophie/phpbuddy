$(document).ready(function() {
    $(".sendMessage").on("click", function() {
        // Here we are getting the reaction which is tapped by using the data-reaction attribute defined in main page

        var messageText = $(".messageText").val();
        // Sending Ajax request in handler page to perform the database operations
        $.ajax({
            type: "POST",
            url: "chat_action.php",
            data: { content: messageText },
            success: function(response) {
                // This code will run after the Ajax is successful
            }
        })
    });
});