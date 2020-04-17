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
    $statement = $conn->prepare("SELECT messages.id, messages.content, users.fullname FROM messages,users WHERE messages.sender_id = users.id AND (messages.receiver_id = :userId OR messages.sender_id = :userId) ORDER BY messages.id ASC");
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
    <!-- bootstrap css -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Css for reaction system -->
    <link rel="stylesheet" type="text/css" href="css/reaction.css" />

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- jQuery for Reaction system -->
    <script type="text/javascript" src="js/reaction.js"></script>
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
                <div class="container" style="padding:0px">
                    <div class="header">
                    </div>
                    <div class="main">
                        <!-- Reaction system start -->
                        <div class="reaction-container">
                            <!-- container div for reaction system -->
                            <span class="like-emo">
                                <!-- like emotions container -->
                            </span>
                            <span class="reaction-btn">
                                <!-- Default like button -->
                                <span class="reaction-btn-text">Like</span> <!-- Default like button text,(Like, wow, sad..) default:Like  -->
                                <ul class="emojies-box">
                                    <!-- Reaction buttons container-->
                                    <li class="emoji emo-like" data-reaction="Like" message-id="<?= $message->id ?>"></li>
                                    <li class="emoji emo-love" data-reaction="Love" message-id="<?= $message->id ?>"></li>
                                    <li class="emoji emo-haha" data-reaction="HaHa" message-id="<?= $message->id ?>"></li>
                                    <li class="emoji emo-wow" data-reaction="Wow" message-id="<?= $message->id ?>"></li>
                                    <li class="emoji emo-sad" data-reaction="Sad" message-id="<?= $message->id ?>"></li>
                                    <li class="emoji emo-angry" data-reaction="Angry" message-id="<?= $message->id ?>"></li>
                                </ul>
                            </span>
                        </div>
                        <!-- Reaction system end -->
                    </div>
                    <br>
                </div>
            <?php endforeach; ?>

            <textarea name="content" id="" cols="30" rows="1"></textarea>
            <input type="submit" name="sendMessage" value="Send">
    </form>
</body>

</html>