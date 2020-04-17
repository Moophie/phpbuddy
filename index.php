<?php

include_once(__DIR__ . "/classes/User.php");

session_start();

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

$email = $_SESSION['user'];
$user = new User($email);

//Get all the users from the database except for the active user
$potMatches = $user->getAllExceptUser();

//If someone sends a buddy suggestion
if (!empty($_POST['getBuddy'])) {

    //Update the buddy_id in the database
    $conn = Db::getConnection();
    $statement = $conn->prepare("UPDATE users SET buddy_id = :buddy_id WHERE email = :email");
    $statement->bindValue(":buddy_id", $_POST['buddy_id']);
    $statement->bindValue(":email", $user->getEmail());
    $statement->execute();

    //Then redirect them to their chatwindow
    header("Location: chat.php");
}

if (!empty($_POST['acceptBuddy'])) {
    if ($_POST['acceptBuddy'] == "Accept") {

        //Make the other person your buddy
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = :buddy_id WHERE email = :email");
        $statement->bindValue(":buddy_id", $_POST['buddy_id']);
        $statement->bindValue(":email", $user->getEmail());
        $statement->execute();
    } elseif ($_POST['acceptBuddy'] == "Reject") {

        //Remove yourself as buddy
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET buddy_id = 0 WHERE email = :email");
        $statement->bindValue(":email", $_POST['buddy_email']);
        $statement->execute();

        //Prompt box for rejecting reason
        echo "<script>var reason = prompt('Would you like telling the reason for this rejection?', 'Write reason here');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <title>IMD Buddy</title>
    <style>
        .matches {
            max-width: 250px;
            margin: 5px 20px;
            padding: 10px;
            border: solid black 1px;
        }
    </style>
</head>

<body>

    <?php include_once("nav.include.php"); ?>

    <div class="container">
        <div class="jumbotron">
            <h2>Welcome back, <?php echo htmlspecialchars($user->getFullname()) ?></h2>
            <div class="center">
                <?php if (!($user->checkProfileComplete())) : ?>
                    <p>It seems your profile is not completed yet.</p>
                    <form action="profile.php">
                        <input type="submit" class="btn-default btn-lg" Value="Complete your profile!">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="jumbotron">
            <div class="center" style="height:400px;">
                <!-- If the user has no buddy yet, show suggestions -->

                <?php if (empty($user->getBuddy_id())) : ?>

                    <h2>Potential Buddies</h2>
                    <!-- Loop over all the other users -->
                    <?php foreach ($potMatches as $potMatch) :

                        //Check each user for a match
                        $match = $user->getMatch($potMatch);

                        //If the function returns a match, print it out
                        if (!empty($match) && empty($match->buddy_id)) : ?>
                            <div class="matches float-left" style="display:block">
                                <h4><?= $match->fullname ?></h4>
                                <img src="./uploads/<?= htmlspecialchars($match->profileImg) ?>" width="100px;" height="100px;" />
                                <br>
                                <br>
                                <h6>Things you have in common:</h6>

                                <!-- Check all attributes for common ones and then print them out -->
                                <?php if ($match->location == $user->getLocation()) : ?>
                                    <p><?= "Location: " . htmlspecialchars($match->location); ?><p>
                                        <?php endif; ?>
                                        <?php if ($match->games == $user->getGames()) : ?>
                                            <p><?= "Video games: " . htmlspecialchars($match->games); ?></p>
                                        <?php endif; ?>
                                        <?php if ($match->music == $user->getMusic()) : ?>
                                            <p><?= "Music: " . htmlspecialchars($match->music); ?></p>
                                        <?php endif; ?>
                                        <?php if ($match->films == $user->getFilms()) : ?>
                                            <p><?= "Movies: " . htmlspecialchars($match->films); ?></p>
                                        <?php endif; ?>
                                        <?php if ($match->books == $user->getBooks()) : ?>
                                            <p><?= "Books: " . htmlspecialchars($match->books); ?></p>
                                        <?php endif; ?>
                                        <?php if ($match->study_pref == $user->getStudy_pref()) : ?>
                                            <p><?= "Same study preferences: " . htmlspecialchars($match->study_pref); ?></p>
                                        <?php endif; ?>
                                        <?php if ($match->hobby == $user->getHobby()) : ?>
                                            <p><?= "Hobby: " . htmlspecialchars($match->hobby); ?></p>
                                        <?php endif; ?>

                                        <?php if ($match->buddy_id == $user->getId()) : ?>
                                            <form action="" method="POST">
                                                <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id) ?>" hidden>
                                                <input type="submit" name="acceptBuddy" value="Accept">
                                            </form>
                                            <form action="" method="POST">
                                                <input type="text" name="buddy_email" value="<?= htmlspecialchars($match->email) ?>" hidden>
                                                <input type="submit" name="acceptBuddy" value="Reject">
                                            </form>
                                        <?php else : ?>
                                            <form action="" method="POST">
                                                <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id) ?>" hidden>
                                                <input type="submit" name="getBuddy" value="Send buddy request!">
                                            </form>
                                        <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>