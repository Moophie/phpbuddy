<?php

session_start();

// If a session is active, send the user on to the logged in index
if(!empty($_SESSION['user'])){
    header("Location: indexLoggedIn.php");
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
                            <a class="nav-link" href="login.php"><i class="fas fa-user"></i> Log in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Sign up</a>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="HeaderContent">
                    <h1>IMD Buddy</h1>
                    <h3>Where Students Help Eachother</h3>
                </div>
            </div>

        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>