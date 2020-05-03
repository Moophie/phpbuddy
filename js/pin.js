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

    $(".deletePost").on("click", function() {

        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { deletePost: 1, id: post_id },
            success: function(response) {
                $('[data-id="' + post_id + '"]').remove();
            }
        })
    });

    $(".editPost").on("click", function() {

        var post_id = $(this).attr("data-id");
        var visible = $(this).attr("data-visible");
        var content = $(' [data-id="' + post_id + '"] .editContent').val();

        if (visible == "0") {
            $('[data-id="' + post_id + '"] .d-none').removeClass("d-none").addClass("d-block");
            $(this).attr("data-visible", "1");
        }

        if (visible == "1") {
            $.ajax({
                type: "POST",
                url: "forum.php",
                data: { editPost: 1, id: post_id, content: content },
                success: function(response) {
                    $('[data-id="' + post_id + '"] .postText').html(content);
                    $('[data-id="' + post_id + '"] .d-block').removeClass("d-block").addClass("d-none");
                    $(this).attr("data-visible", "0");
                }
            })
        }
    });
});