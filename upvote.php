<?php

include_once(__DIR__ . "/bootstrap.include.php");

if (isset($_POST['upvote'])) {
    $user = new classes\Buddy\User($_SESSION['user']);
    $post = new classes\Buddy\Post($_POST['id']);

    //Check if it's an upvote or downvote
    if ($_POST['upvote'] == 1) {
        if ($user->alreadyUpvoted($_POST['id'])) {
            $error = "You've already upvoted this.";
        } else {
            //Add an upvote to the post in the database
            $post->addUpvote();
            $upvote = new classes\Buddy\Upvote();
            $upvote->setPost_id($_POST['id']);
            $upvote->setUser_id($user->getId());
            //Save the upvote as a seperate entity in the database
            $upvote->saveUpvote();
        }
    }

    if ($_POST['upvote'] == 0) {
        if ($user->alreadyUpvoted($_POST['id'])) {
            $post->removeUpvote();
            $upvote = new classes\Buddy\Upvote();
            $upvote->setPost_id($_POST['id']);
            $upvote->setUser_id($user->getId());
            $upvote->deleteUpvote();
        } else {
            $error = "You can't downvote, only remove your upvote.";
        }
    }

    //Echo the new amount of upvotes so it can be used to update the upvote counter
    echo classes\Buddy\Post::countUpvotes($_POST['id']);
}
