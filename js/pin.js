$(document).ready(function() {
    $(".pin").on("click", function() {

        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { pinFaq: 1, id: post_id },
            success: function(response) {}
        })
    });

    $(".unpin").on("click", function() {

        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { pinFaq: 0, id: post_id },
            success: function(response) {}
        })
    });
});