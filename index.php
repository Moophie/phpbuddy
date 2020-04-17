<?php
include_once(__DIR__ . "/classes/User.php");

session_start();

// If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

$email = $_SESSION['user'];
$user = new User($email);
$potMatches = $user->getAllExceptUser();
$registeredCount = $user->totalRegistration();
$totalBuddyCount = $user->totalBuddies();

if (!empty($_POST['getBuddy'])) {
    $conn = Db::getConnection();
    $statement = $conn->prepare("UPDATE users SET buddy_id = :buddy_id WHERE email = :email");
    $statement->bindValue(":buddy_id", $_POST['buddy_id']);
    $statement->bindValue(":email", $user->getEmail());
    $statement->execute();

    header("Location: chat.php");
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

        .center {
            text-align: center;
        }

        .matches {
            max-width: 250px;
            margin: 5px 20px;
            padding: 10px;
            border: solid black 1px;
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
                        <a class="nav-link" href="chat.php">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buddies.php">Buddies</a>
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
                                    echo htmlspecialchars($email);
                                    ?>
                                </a>
                                <div class="dropdown-content">
                                    <a href="search.php">Search</a>
                                    <div class="dropdown-divider"></div>
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

    <div class="container">
        <div class="jumbotron">
            <div class="center">
                <div>
                <p>Registered users = <?php echo $registeredCount ?> <?php ?> </p>
                </div>
                <div>
                <p>amount of buddy relations = <?php echo $totalBuddyCount ?> </p>
                </div>
            </div>
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
                <h2>Potential Buddies</h2>
                <?php foreach ($potMatches as $potMatch) :
                    $match = $user->getMatch($potMatch);

                    if (!empty($match)) : ?>
                        <div class = "matches float-left" style="display:block">
                            <h4><?= $match->fullname ?></h4>
                            <img src="./uploads/<?= htmlspecialchars($match->profileImg) ?>" width="100px;" height="100px;" />
                            <br>
                            <br>
                            <h6>Things you have in common:</h6>
                            <?php if ($match->location == $user->getLocation()) : ?>
                                <p> <?= "Location: " . htmlspecialchars($match->location); ?><p>
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
                                    <form action="" method="POST">
                                        <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id)?>" hidden>
                                        <input type="submit" name="getBuddy" value="Accept buddy!">
                                    </form>
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>