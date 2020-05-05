<?php

include_once(__DIR__ . "/bootstrap.include.php");

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

//Get all users from the database
$users = classes\Buddy\User::getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <title>IMD Buddy</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="container">
        <div class="jumbotron">
            <h1>Buddy list</h1>
            <p>Find out who are buddies</p>
        </div>

        <ul>
            <?php foreach ($users as $user) : ?>
                <li class="list-group-item">
                    <div class="col-md-12">
                        <div class="d-flex flex-row border rounded">
                            <div class="p-0 w-25">
                                <img src="./uploads/<?= htmlspecialchars($user->profile_img); ?>" class="img-thumbnail border-0" />
                            </div>
                            <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
                                <h4 class="text-primary"><?= htmlspecialchars($user->fullname); ?></h4>
                                <h5 class="text-info">IMD 3</h5>
                                <p class="text-right m-0"><a href="#" class="btn btn-primary"><i class="far fa-user"></i> View Profile</a></p>
                            </div>
                        </div>
                        <?php

                        //Select the user's buddy
                        $buddy = classes\Buddy\User::findBuddy($user->email);

                        //Check if there is a buddy, then print out the buddy's fullname
                        if (!empty($buddy)) : ?>
                            <div class="border rounded">
                                <p><strong>My buddy is: </strong> <?= htmlspecialchars($buddy->fullname) ?></p>
                            </div>
                        <?php endif; ?>
                        <br>
                        <br>
                    <?php endforeach ?>
                    </div>
                </li>
        </ul>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>