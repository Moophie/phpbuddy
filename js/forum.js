$(document).ready(function() {
    $(".pin").on("click", function() {

        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { pinFaq: 1, id: post_id },
            success: function(response) {

            }
        })
    });

    $(".unpin").on("click", function() {

        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "forum.php",
            data: { pinFaq: 0, id: post_id },
            success: function(response) {

            }
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
        //Get the id so it can be used to change the right post
        var post_id = $(this).attr("data-id");
        var visible = $('[data-id="' + post_id + '"].editPost').attr("data-visible");
        var content = $(' [data-id="' + post_id + '"].editContent').val();

        if (visible == "0") {
            $('[data-id="' + post_id + '"].d-none.editContent').removeClass("d-none").addClass("d-block");
            $('[data-id="' + post_id + '"].editPost').attr("data-visible", "1");
            $('[data-id="' + post_id + '"].editPost').html("Save");
        }

        if (visible == "1") {

            $('[data-id="' + post_id + '"].editPost').html("Edit");
            $.ajax({
                type: "POST",
                url: "forum.php",
                data: { editPost: 1, id: post_id, content: content },
                success: function(response) {
                    //Change the post text to the new edited content
                    $('[data-id="' + post_id + '"].postText').html(content);
                    $('[data-id="' + post_id + '"].d-block.editContent').removeClass("d-block").addClass("d-none");
                    $('[data-id="' + post_id + '"].editPost').attr("data-visible", "0");
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

        //Open or close the FAQ discussion, depending on if it was already shown or not
        if ($(this).hasClass("showFaq")) {
            if ($('[data-id="' + post_id + '"] .discussion.discFaq').hasClass("d-none")) {
                $('[data-id="' + post_id + '"] .d-none.discussion.discFaq').removeClass("d-none").addClass("d-block");
                $('[data-id="' + post_id + '"] .showDisc.showFaq').html("Hide discussion");
            } else {
                $('[data-id="' + post_id + '"] .d-block.discussion.discFaq').removeClass("d-block").addClass("d-none");
                $('[data-id="' + post_id + '"] .showDisc.showFaq').html("Show discussion");
            }
        }

        //Open or close the discussion, depending on if it was already shown or not
        if ($(this).hasClass("showPost")) {
            if ($('[data-id="' + post_id + '"] .discussion.discPost').hasClass("d-none")) {
                $('[data-id="' + post_id + '"] .d-none.discussion.discPost').removeClass("d-none").addClass("d-block");
                $('[data-id="' + post_id + '"] .showDisc.showPost').html("Hide discussion");
            } else {
                $('[data-id="' + post_id + '"] .d-block.discussion.discPost').removeClass("d-block").addClass("d-none");
                $('[data-id="' + post_id + '"] .showDisc.showPost').html("Show discussion");
            }
        }
    });

    //Upvote AJAX
    $(".upvote").on("click", function() {
        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "upvote.php",
            data: { upvote: 1, id: post_id },
            success: function(data) {
                $('[data-id="' + post_id + '"].upvote-counter').html(data);
            }
        })
    });

    //Removing your own upvote AJAX
    $(".downvote").on("click", function() {
        var post_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "upvote.php",
            data: { upvote: 0, id: post_id },
            success: function(data) {
                $('[data-id="' + post_id + '"].upvote-counter').html(data);
            }
        })
    });
});