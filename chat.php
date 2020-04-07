<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");

session_start();

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

//Function that gets all messages from the database where the current user is either the sender or the receiver)
function getMessages()
{
    $user = new User($_SESSION['user']);

    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT messages.content, users.fullname FROM messages,users WHERE messages.sender_id = users.id AND (messages.receiver_id = :userId OR messages.sender_id = :userId) ORDER BY messages.id ASC");
    $statement->bindValue(":userId", $user->getId());
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    return $result;
}

//If a message has been submitted, save it in the database
if (!empty($_POST['sendMessage'])) {

    $user = new User($_SESSION['user']);
    $sender = $user->getId();
    $receiver = $user->getBuddy_id();
    $content = $_POST['content'];

    $conn = Db::getConnection();
    $statement = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (:sender_id, :receiver_id, :content)");
    $statement->bindValue(":sender_id", $sender);
    $statement->bindValue(":receiver_id", $receiver);
    $statement->bindValue(":content", $content);
    $result = $statement->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <title>Chat</title>
    <style>
        .chat {
            border: solid black 1px;
            margin-right: 30%;
            margin-left: 30%;
            padding: 20px;
            max-width: 500px;
        }
    </style>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <form action="" method="POST" class="chat">
        <h2>Chat</h2>
        <a href="index.php">Back to home</a>
        <div class="messagebox">
            <?php
            $messages = getMessages();

            //Print out all messages
            foreach ($messages as $message) : ?>
                <p><strong><?= htmlspecialchars($message->fullname) ?></strong></p>
                <p><?= htmlspecialchars($message->content) ?></p>
            <?php endforeach; ?>
        </div>
        <textarea name="content" id="" cols="30" rows="1"></textarea>
        <input type="submit" name="sendMessage" value="Send">
    </form>
</body>

</html>