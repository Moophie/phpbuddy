<?php

include_once(__DIR__ . "/bootstrap.include.php");

session_start();
$user = new classes\Buddy\User($_SESSION['user']);

$time = date('Y-m-d H:i:s');

$active_conversation = $user->getActiveConversations();

$message = new classes\Buddy\Message();
$message->setConversation_id($active_conversation->id);
$message->setSender_id($user->getId());
$message->setReceiver_id($user->getBuddy_id());
$message->setContent($_POST['content']);
$message->setTimestamp($time);
$message->saveMessage();
