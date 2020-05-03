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
            $('[data-id="' + post_id + '"] .d-none.editContent').removeClass("d-none").addClass("d-block");
            $(this).attr("data-visible", "1");
            $(this).html("Save");
        }

        if (visible == "1") {

            $(this).html("Edit");
            $.ajax({
                type: "POST",
                url: "forum.php",
                data: { editPost: 1, id: post_id, content: content },
                success: function(response) {
                    $('[data-id="' + post_id + '"] .postText').html(content);
                    $('[data-id="' + post_id + '"] .d-block.editContent').removeClass("d-block").addClass("d-none");
                    $(this).attr("data-visible", "0");
                }
            })
        }
    });

    $(".reactPost").on("click", function() {

        var post_id = $(this).attr("data-id");

        $(".submitPost").val("React");
        $(".postParent").val(post_id);
    });

    $(".showDisc").on("click", function() {
        var post_id = $(this).attr("data-id");

        if ($('[data-id="' + post_id + '"] .discussion').hasClass("d-none")) {
            $('[data-id="' + post_id + '"] .d-none.discussion').removeClass("d-none").addClass("d-block");
            $('[data-id="' + post_id + '"] .showDisc').html("Hide discussion");
        } else {
            $('[data-id="' + post_id + '"] .d-block.discussion').removeClass("d-block").addClass("d-none");
            $('[data-id="' + post_id + '"] .showDisc').html("Show discussion");
        }
    });

    $(".upvote").on("click", function() {
        var post_id = $(this).attr("data-id");
        console.log(post_id);

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { upvote: 1, id: post_id },
            success: function(response) {}
        })
    });
});