<?php

include_once(__DIR__ . "/bootstrap.include.php");

$user = new classes\Buddy\User($_SESSION['user']);

$active_conversation = $user->getActiveConversations();
$conversation = new classes\Buddy\Conversation();
$conversation->setId($active_conversation->id);
$conversation->readMessages($user->getId());
$messages = $conversation->getMessages();
$chat_partner = $conversation->getPartner($user->getId());

if (!empty($_POST['content'])) {
    $time = date('Y-m-d H:i:s');

    $active_conversation = $user->getActiveConversations();

    $message = new classes\Buddy\Message();
    $message->setConversation_id($active_conversation->id);
    $message->setSender_id($user->getId());
    $message->setReceiver_id($chat_partner->id);
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
    <link rel="stylesheet" href="css/reaction.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
    <title>Chat</title>
</head>

<body onload="updateScroll()">
    <?php include_once("nav.include.php"); ?>

    <form action="" method="POST" class="chat">
        <div class="chatbox">
            <?php if (!empty($active_conversation)) : ?>
                <h2 class="d-inline-block">Chat</h2>
                <h4 class="float-right d-inline-block"><?php echo htmlspecialchars($chat_partner->fullname); ?></h4>
                <div class="messagebox" style="min-height: 400px;">
                    <?php
                    if (!empty($active_conversation)) :
                        //Print out all messages
                        foreach ($messages as $message) : ?>
                            <div class="messageElement">
                                <div class="messageContent">
                                    <strong class="float-left"><?= htmlspecialchars($message->fullname) ?></strong>
                                    <small class="float-right"><?= $message->timestamp; ?></small>
                                    <br>
                                    <p class="float-left"><?= htmlspecialchars($message->content) ?></p>
                                    <br>
                                </div>
                                <div class="container float-left">
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
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <textarea id="messageText" cols="30" rows="1" class="messageText float-left"></textarea>
                <button class="sendMessage float-left">Send</button>
            <?php else : ?>
                <h2 class="d-inline-block">You have no buddy to chat with!</h2>
                <h6>Send a request to someone or wait for someone else to ask you.</h6>
            <?php endif; ?>
        </div>
    </form>

    <script src="js/jquery.min.js"></script>
    <script src="js/chat.js"></script>
</body>

</html>