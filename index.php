<?php
include_once(__DIR__ . "/classes/User.php");

session_start();
$user = new User();
$match = $user->getBuddies();

// If there's an active session, put the session variable into $username for easier access
if (!empty($_SESSION['user'])) {
    $username = $_SESSION['user'];
} else {

    // If there's no active session, redirect to login.php
    header("Location: login.php");
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
        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropbtn i {
            margin-right: 5px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343A40;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #68717a;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>

</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">IMD Buddy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown">

                                <a class="dropbtn">
                                    <i class="fas fa-user"></i>
                                    <?php
                                    // Don't forget to htmlspecialchars() when using inputted variables in your code
                                    echo htmlspecialchars($username);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="profile.php">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="logout.php">Log out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </nav>

<!---
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="HeaderContent">
                    <h1>IMD Buddy</h1>
                    <h3>Where Students Help Eachother</h3>
                    <hr>

                    <!-- Show message with link if the user's profile is incomplete --> <!--
                    <?php if(!($user->checkProfileComplete())): ?>
                    <form action="profile.php">
                        <input type="submit" class="btn-default btn-lg" Value="Complete your profile!">
                    </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    --->

<div>
    <?php foreach ($match as $m): ?>
    <p><?php echo $m['fullname']; ?> is interested in <?php echo $m['study_pref']; ?> </p>
    <?php endforeach; ?>
</div>


    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>