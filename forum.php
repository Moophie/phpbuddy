<?php
session_start();

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/Upvote.php");


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

    $post->setParent($_POST['postParent']);
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

if (!empty($_POST['deletePost'])) {
    $post = new Post();
    $post->deletePost($_POST['id']);
}

if (!empty($_POST['editPost'])) {
    $post = new Post();
    $post->editPost($_POST['id'], $_POST['content']);
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
    <script type="text/javascript" src="js/forum.js"></script>
    <title>Forums</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="forum float-left" style="margin:10px 0px 0px 10px; border:1px black solid; width: 800px; padding:5px">
        <?php foreach ($allPosts as $post) : ?>
            <div class="post" data-id="<?php echo $post->id; ?>" style="border:1px black solid; max-width: 800px; margin-bottom:10px; padding:5px">
                <strong><?php echo htmlspecialchars($post->op) ?></strong>
                <br>
                <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                <p class="postText"><?php echo htmlspecialchars($post->content) ?></p>
                <p>Pin to FAQ <img class="pin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"></p>
                <?php if ($post->op == $user->getFullname()) : ?>
                    <textarea class="editContent d-none" data-id="<?php echo $post->id; ?>" name="editContent"></textarea>
                    <button class="editPost" data-id="<?php echo $post->id; ?>" data-visible="0">Edit</button>
                    <button class="deletePost" data-id="<?php echo $post->id; ?>">Delete</button>
                <?php endif; ?>

                <button class="reactPost" data-id="<?php echo $post->id; ?>">React</button>
                <button class="showDisc" data-id="<?php echo $post->id; ?>">Show discussion</button>

                <div class="discussion d-none" data-id="<?php echo $post->id; ?>" style="margin-left:20px;margin-top:10px;">
                    <?php
                    $reactions = Post::getReactions($post->id);
                    foreach ($reactions as $reaction) : ?>
                        <strong><?php echo htmlspecialchars($reaction->op) ?></strong>
                        <br>
                        <i><?php echo htmlspecialchars($reaction->timestamp) ?></i>
                        <p class="postText"><?php echo htmlspecialchars($reaction->content) ?></p>
                        <p><a href="#" class="upvote" data-id="<?php echo $post->id; ?>">Upvote</a> <!--<span class="countUpvotes"><?php //echo $post->getUpvotes(); ?></span>--></p>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach; ?>


        <form action="" method="POST">
            <textarea name="postContent"></textarea>
            <input class="postParent" name="postParent" type="text" value="0" hidden>
            <br>
            <input class="submitPost" name="submitPost" type="submit" value="New post">
        </form>
    </div>



    <div class="FAQ float-right" style="margin:10px 10px 0px 0px; border:1px black solid; width: 400px; padding:5px">
        <h3 style="color:black">FAQ</h3>
        <?php foreach ($faqPosts as $post) : ?>
            <div class="post" data-id="<?php echo $post->id; ?>" style="border:1px black solid; max-width: 800px; margin-bottom:10px; padding:5px">
                <strong><?php echo htmlspecialchars($post->op) ?></strong>
                <br>
                <i><?php echo htmlspecialchars($post->timestamp) ?></i>
                <p class="postText"><?php echo htmlspecialchars($post->content) ?></p>
                <p>Unpin from FAQ <img class="unpin" data-id="<?php echo $post->id; ?>" src="https://via.placeholder.com/30"></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        $(".a.upvote").on("click", function(e){
            var postId = $(this).data('id');

            $.ajax({
                method:"POST",
                url: "upvote.php",
                data: {postId: postId},
                dataType: "Json"
            })
            .done(function(res){
                if(res.status == "success"){
                    likes++;
                }
            
        });
  

    </script>

</body>

</html>