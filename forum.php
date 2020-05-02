<?php
session_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <title>Forums</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="forum" style="margin:10px 0px 0px 10px;">
        <div class="post" style="border:1px black solid; max-width: 800px; margin-bottom:10px;">
            <strong>USERNAME</strong>
            <br>
            <i>timestamp</i>
            <p>CONTENT</p>
        </div>
        <form action="" method="POST">
            <textarea name="postContent"></textarea>
            <br>
            <input type="submit" value="Post">
        </form>
    </div>

    <div class="FAQ">

    </div>

</body>

</html>