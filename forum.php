<?php
session_start();

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Post.php");

$email;

if (empty($_SESSION['user'])) {
    $email = "Anonymous";
} else {
    $email = $_SESSION['user'];
}

$user = new User($email);

if (!empty($_POST['postContent'])) {
    $time = date('Y-m-d H:i:s');

    $post = new Post();

    if (empty($_SESSION['user'])) {
        $post->setOp("Anonymous");
    } else {
        $user = new User($_SESSION['user']);
        $post->setOp($user->getFullname());
    }

    $post->setTimestamp($time);
    $post->setcontent($_POST['postContent']);
    $post->savePost();
}

if (isset($_POST['pinFaq'])) {

    if ($_POST['pinFaq'] == 1) {
        $post = new Post();
        $post->setId($_POST['id']);
        $post->pinPost(1);

    } elseif ($_POST['pinFaq'] == 0) {
        $post = new Post();
        $post->setId($_POST['id']);
        $post->pinPost(0);
    }
}

$allPosts = Post::getAllPosts();
$faqPosts = Post::getFaqPosts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/pin.js"></script>
    <title>Forums</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="forum float-left" style="margin:10px 0px 0px 10px; border:1px black solid; width: 800px; padding:5px">
        <?php foreach ($allPosts as $post) : ?>
            <div class="post" style="border:1px black solid; max-width: 800px; margin-bottom:10px; padding:5px">
                <strong><?php echo htmlspecialchars($post->op) ?></strong>
                <br>
                <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                <p><?php echo htmlspecialchars($post->content) ?></p>
                <p>Pin to FAQ <img class="pin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"><p>
            </div>
        <?php endforeach; ?>


        <form action="" method="POST">
            <textarea name="postContent"></textarea>
            <br>
            <input type="submit" value="Post">
        </form>
    </div>

    <div class="FAQ float-right" style="margin:10px 10px 0px 0px; border:1px black solid; width: 400px; padding:5px">
        <h3 style="color:black">FAQ</h3>
        <?php foreach ($faqPosts as $post) : ?>
            <div class="post" style="border:1px black solid; max-width: 800px; margin-bottom:10px; padding:5px">
                <strong><?php echo htmlspecialchars($post->op) ?></strong>
                <br>
                <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                <p><?php echo htmlspecialchars($post->content) ?></p>
                <p>Unpin from FAQ <img class="unpin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"><p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>