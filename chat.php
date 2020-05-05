<?php

include_once(__DIR__ . "/bootstrap.include.php");

session_start();

$user = new classes\Buddy\User($_SESSION['user']);

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
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
    <script type="text/javascript" src="js/chat.js"></script>
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
            $active_conversation = $user->getActiveConversations();
            if (!empty($active_conversation)) :
                $conversation = new classes\Buddy\Conversation();
                $conversation->setId($active_conversation->id);
                $messages = $conversation->getMessages();

                //Print out all messages
                foreach ($messages as $message) : ?>
                    <p>
                        <strong><?= htmlspecialchars($message->fullname) ?></strong>
                        <br>
                        <?= $message->timestamp; ?>
                    </p>
                    <p><?= htmlspecialchars($message->content) ?></p>
                    <div class="container" style="padding:0px">
                        <div class="header">
                        </div>
                        <div class="main">
                            <!-- Reaction system start -->
                            <div class="reaction-container">
                                <!-- container div for reaction system -->
                                <span class="like-emo <?= $message->id ?> ">
                                    <!-- like emotions container -->
                                    <?php if (!empty($message->reaction)) : ?>
                                        <span class="like-btn-<?= strtolower($message->reaction) ?>"></span>
                                    <?php endif; ?>
                                </span>
                                <span class="reaction-btn <?= $message->id ?>">
                                    <!-- Default like button -->
                                    <span class="reaction-btn-text <?= $message->id ?> <?php if (!empty($message->reaction)) {
                                                                                            echo "reaction-btn-text-" . strtolower($message->reaction);
                                                                                            echo " active";
                                                                                        } ?>" message-id="<?= $message->id ?>"><?php if (!empty($message->reaction)) {
                                                                                                                                echo $message->reaction;
                                                                                                                            } else {
                                                                                                                                echo "Like";
                                                                                                                            } ?> </span> <!-- Default like button text,(Like, wow, sad..) default:Like  -->
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
            <?php endif; ?>

            <textarea name="content" id="" cols="30" rows="1" class="messageText"></textarea>
            <input type="submit" name="sendMessage" value="Send" class="sendMessage">
    </form>
</body>

</html>