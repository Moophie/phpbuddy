<?php

include_once(__DIR__ . "/bootstrap.include.php");

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

//If someone clicks search, find the correct users based on the filters in the $_POST
if (!empty($_POST)) {
    $found_users = classes\Buddy\User::searchUsers($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <title>Search</title>
</head>

<body>

    <?php include_once("nav.include.php"); ?>

    <div class="float-left" style="margin-right:40px;">
        <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
            <h1>Search</h1>
            <div class="form-label-group">
                <label for="fullname">Full name</label>
                <input type="text" id="fullname" name="fullname" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="games">Games</label>
                <input type="text" id="games" name="games" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="music">Music</label>
                <input type="text" id="music" name="music" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="films">Films</label>
                <input type="text" id="films" name="films" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="books">Books</label>
                <input type="text" id="books" name="books" class="form-control">
            </div>
            <div class="form-label-group">
                <label for="hobby">Hobby</label>
                <input type="text" id="hobby" name="hobby" class="form-control">
            </div>
            <div class="form-label-group">
                <p>Study Preference</p>
                <div class="form-check">
                    <input type="radio" id="design" name="study_pref" class="form-check-input" value="design">
                    <label for="design" class="form-check-label">Design</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="development" name="study_pref" class="form-check-input" value="development">
                    <label for="development" class="form-check-label">Development</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="undecided" name="study_pref" class="form-check-input" value="undecided">
                    <label for="undecided" class="form-check-label">Undecided</label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>


    <div class="float-left">
        <?php if (!empty($found_users)) : ?>

            <!-- Print out all users and their properties -->
            <?php foreach ($found_users as $found_user) : ?>
                <div class="float-left" style="margin-right: 10px; border: 1px solid black; padding: 10px;">
                    <ul style="list-style:none; margin:0px; padding:0px;">
                        <li><b>Full name:</b> <?= htmlspecialchars($found_user->fullname) ?></li>
                        <li><b>Location :</b> <?= htmlspecialchars($found_user->location) ?></li>
                        <li><b>Games :</b> <?= htmlspecialchars($found_user->games) ?></li>
                        <li><b>Music :</b> <?= htmlspecialchars($found_user->music) ?></li>
                        <li><b>Films :</b> <?= htmlspecialchars($found_user->films) ?></li>
                        <li><b>Books :</b> <?= htmlspecialchars($found_user->books) ?></li>
                        <li><b>Hobby :</b> <?= htmlspecialchars($found_user->hobby) ?></li>
                        <li><b>Studies :</b> <?= htmlspecialchars($found_user->study_pref) ?></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>