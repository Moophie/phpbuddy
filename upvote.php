<?php

if(!empty($_POST)){
    $postId = $_POST['postId'];
    $userId = $_POST ['id'];

    $up = new classes\Buddy\Upvote();
    $up->setPost_id($postId);
    $up->setUser_id($userId);
    $up->saveUpvote();

    $result=[
        "status"=>"success",
        "message"=>"Upvote is saved"
    ];

    echo json_encode(($result));
}

?>