<?php

include_once(__DIR__ . "/bootstrap.include.php");

if (!empty($_POST['upvote'])) {
    $user = new classes\Buddy\User($_SESSION['user']);
    $post = new classes\Buddy\Post($_POST['id']);
    $post->addUpvote();

    $upvote = new classes\Buddy\Upvote();
    $upvote->setPost_id($_POST['id']);
    $upvote->setUser_id($user->getId());
    $upvote->saveUpvote();

    echo classes\Buddy\Post::countUpvotes($_POST['id']);
}
