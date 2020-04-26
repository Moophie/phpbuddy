<?php

include_once(__DIR__ . "/classes/Message.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

session_start();
$user = new User($_SESSION['user']);

$time = date('Y-m-d H:i:s');

$active_conversation = $user->getActiveConversations();

$message = new Message();
$message->setConversation_id($active_conversation->id);
$message->setSender_id($user->getId());
$message->setReceiver_id($user->getBuddy_id());
$message->setContent($_POST['content']);
$message->setTimestamp($time);
$message->saveMessage();