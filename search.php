<?php

include_once(__DIR__ . "/classes/User.php");

session_start();

if (!empty($_SESSION['user'])) {
    $email = $_SESSION['user'];
} else {
    header("Location: login.php");
}

if (!empty($_POST)) {
    $foundUsers = User::searchUsers($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Search</title>
</head>

<body>
    <div class="float-left" style="margin-right:40px;">
        <form action="" method="POST" class="border rounded" style="padding:20px; width:500px;">
            <h1>Search</h1>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" class="form-control">
            </div>
            <div class="form-group">
                <label for="games">Games</label>
                <input type="text" id="games" name="games" class="form-control">
            </div>
            <div class="form-group">
                <label for="music">Music</label>
                <input type="text" id="music" name="music" class="form-control">
            </div>
            <div class="form-group">
                <label for="films">Films</label>
                <input type="text" id="films" name="films" class="form-control">
            </div>
            <div class="form-group">
                <label for="books">Books</label>
                <input type="text" id="books" name="books" class="form-control">
            </div>
            <div class="form-group">
                <label for="hobby">Hobby</label>
                <input type="text" id="hobby" name="hobby" class="form-control">
            </div>
            <div class="form-group">
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
        <?php foreach ($foundUsers as $foundUser) : ?>
            <div class="float-left" style="margin-right: 10px; border: 1px solid black; padding: 10px;">
                <ul style="list-style:none; margin:0px; padding:0px;">
                    <li><b>Full name:</b> <?= $foundUser->fullname ?></li>
                    <li><b>Location :</b> <?= $foundUser->location ?></li>
                    <li><b>Games    :</b> <?= $foundUser->games ?></li>
                    <li><b>Music    :</b> <?= $foundUser->music ?></li>
                    <li><b>Films    :</b> <?= $foundUser->films ?></li>
                    <li><b>Books    :</b> <?= $foundUser->books ?></li>
                    <li><b>Hobby    :</b> <?= $foundUser->hobby ?></li>
                    <li><b>Studies  :</b> <?= $foundUser->study_pref ?></li>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>