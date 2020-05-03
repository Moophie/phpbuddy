<?php

if(!empty($_POST)){
    $postId = $_POST['postId'];
    $userId = $_POST ['id'];

    $up = new Upvote();
    $up->setPost_id($postId);
    $up->setUser_id($userId);
    $up->save();

    $result=[
        "status"=>"success",
        "message"=>"Upvote is saved"
    ];

    echo json_encode(($result));
}

?>