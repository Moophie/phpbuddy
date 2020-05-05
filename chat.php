<?php

include_once(__DIR__ . "/bootstrap.include.php");

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

$user = new classes\Buddy\User($_SESSION['user']);

if (!empty($_POST['content'])) {
    $time = date('Y-m-d H:i:s');

    $active_conversation = $user->getActiveConversations();

    $message = new classes\Buddy\Message();
    $message->setConversation_id($active_conversation->id);
    $message->setSender_id($user->getId());
    $message->setReceiver_id($user->getBuddy_id());
    $message->setContent($_POST['content']);
    $message->setTimestamp($time);
    $message->saveMessage();
}

if (isset($_POST['like'])) {
    if ($_POST['like'] == 1) {
        classes\Buddy\Message::reaction();
    }

    if ($_POST['like'] == 0) {
        classes\Buddy\Message::undoReaction();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/reaction.css" />
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
                                    <span class="reaction-btn-text <?= $message->id ?> <?php if (!empty($message->reaction)) :
                                                                                            echo "reaction-btn-text-" . strtolower($message->reaction);
                                                                                            echo " active";
                                                                                        endif; ?>" message-id="<?= $message->id ?>">
                                        <?php if (!empty($message->reaction)) :
                                            echo $message->reaction;
                                        else :
                                            echo "Like";
                                        endif; ?>
                                    </span>
                                    <!-- Default like button text,(Like, wow, sad..) default:Like  -->
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

            <textarea id="" cols="30" rows="1" class="messageText"></textarea>
            <button class="sendMessage">Send</button>
    </form>

    <script src="js/jquery.min.js"></script>
    <script src="js/chat.js"></script>
</body>

</html>