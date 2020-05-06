<?php

include_once(__DIR__ . "/bootstrap.include.php");

$email;

if (empty($_SESSION['user'])) {
    $email = "Anonymous";
} else {
    $email = $_SESSION['user'];
}

$user = new classes\Buddy\User($email);

if (!empty($_POST['postContent'])) {
    $time = date('Y-m-d H:i:s');

    $post = new classes\Buddy\Post();

    if (empty($_SESSION['user'])) {
        $post->setOp($email);
    } else {
        $user = new classes\Buddy\User($_SESSION['user']);
        $post->setOp($user->getFullname());
    }

    $post->setParent($_POST['postParent']);
    $post->setTimestamp($time);
    $post->setcontent($_POST['postContent']);
    $post->savePost();
}

if (isset($_POST['pinFaq'])) {
    if ($_POST['pinFaq'] == 1) {
        $post = new classes\Buddy\Post();
        $post->setId($_POST['id']);
        $post->pinPost(1);
    } elseif ($_POST['pinFaq'] == 0) {
        $post = new classes\Buddy\Post();
        $post->setId($_POST['id']);
        $post->pinPost(0);
    }
}

if (!empty($_POST['deletePost'])) {
    $post = new classes\Buddy\Post();
    $post->deletePost($_POST['id']);
}

if (!empty($_POST['editPost'])) {
    $post = new classes\Buddy\Post();
    $post->editPost($_POST['id'], $_POST['content']);
}

$all_posts = classes\Buddy\Post::getAllPosts();
$faq_posts = classes\Buddy\Post::getFaqPosts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
    <title>Forums</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="float-left jumbotron forum">
        <h2>Forum</h2>
        <div class="forum-content">
            <?php foreach ($all_posts as $post) : ?>
                <?php $upvote_counter = classes\Buddy\Post::countUpvotes($post->id); ?>
                <div class="jumbotron post" data-id="<?php echo $post->id; ?>">
                    <p>Upvotes: <span class="upvote-counter" data-id="<?php echo $post->id; ?>"><?php echo $upvote_counter; ?></span></p>
                    <strong><?php echo htmlspecialchars($post->op) ?></strong>
                    <br>
                    <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                    <br>
                    <br>
                    <p class="postText"><?php echo htmlspecialchars($post->content) ?></p>
                    <p>Pin to FAQ <img class="pin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"></p>
                    <?php if ($post->op == $user->getFullname()) : ?>
                        <textarea class="editContent d-none" data-id="<?php echo $post->id; ?>" name="editContent"></textarea>
                        <button class="editPost" data-id="<?php echo $post->id; ?>" data-visible="0">Edit</button>
                        <button class="deletePost" data-id="<?php echo $post->id; ?>">Delete</button>
                    <?php endif; ?>

                    <button class="reactPost" data-id="<?php echo $post->id; ?>">React</button>
                    <button class="upvote" data-id="<?php echo $post->id; ?>">Upvote</button>
                    <button class="showDisc showPost" data-id="<?php echo $post->id; ?>">Show discussion</button>

                    <div class="discussion d-none discPost" data-id="<?php echo $post->id; ?>" style="margin-left:20px;margin-top:10px;">
                        <?php
                        $reactions = classes\Buddy\Post::getReactions($post->id);
                        foreach ($reactions as $reaction) : ?>
                            <p>Upvotes: <?php echo classes\Buddy\Post::countUpvotes($reaction->id); ?></p>
                            <strong><?php echo htmlspecialchars($reaction->op) ?></strong>
                            <br>
                            <i><?php echo htmlspecialchars($reaction->timestamp) ?></i>
                            <p class="postText"><?php echo htmlspecialchars($reaction->content) ?></p>
                            <p><button class="upvote" data-id="<?php echo $reaction->id; ?>">Upvote</button></p>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="jumbotron post-box">
            <form action="" method="POST">
                <textarea name="postContent" cols="50" rows="4"></textarea>
                <input class="postParent" name="postParent" type="text" value="0" hidden>
                <input class="submitPost float-right" name="submitPost" type="submit" value="New post">
            </form>
        </div>
    </div>
    <div class="faq-container">
        <div class="float-right jumbotron faq">
            <h2>FAQ</h2>
            <?php foreach ($faq_posts as $post) : ?>
                <div class="jumbotron post" data-id="<?php echo $post->id; ?>">
                    <?php $upvote_counter = classes\Buddy\Post::countUpvotes($post->id); ?>
                    <p>Upvotes: <span class="upvote-counter" data-id="<?php echo $post->id; ?>"><?php echo $upvote_counter; ?></span></p>
                    <strong><?php echo htmlspecialchars($post->op) ?></strong>
                    <br>
                    <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                    <p class="postText"><?php echo htmlspecialchars($post->content) ?></p>
                    <p>Unpin from FAQ <img class="unpin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"></p>

                    <button class="reactPost" data-id="<?php echo $post->id; ?>">React</button>
                    <button class="upvote" data-id="<?php echo $post->id; ?>">Upvote</button>
                    <button class="showDisc showFaq" data-id="<?php echo $post->id; ?>">Show discussion</button>

                    <div class="discussion d-none discFaq" data-id="<?php echo $post->id; ?>" style="margin-left:20px;margin-top:10px;">
                        <?php
                        $reactions = classes\Buddy\Post::getReactions($post->id);
                        foreach ($reactions as $reaction) : ?>
                            <p>Upvotes: <?php echo classes\Buddy\Post::countUpvotes($reaction->id); ?></p>
                            <strong><?php echo htmlspecialchars($reaction->op) ?></strong>
                            <br>
                            <i><?php echo htmlspecialchars($reaction->timestamp) ?></i>
                            <p class="postText"><?php echo htmlspecialchars($reaction->content) ?></p>
                            <p><button class="upvote" data-id="<?php echo $reaction->id; ?>">Upvote</button></p>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/forum.js"></script>
</body>

</html>