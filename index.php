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
                <h2>Potential Buddies</h2>
                <?php foreach ($potMatches as $potMatch) :
                    $match = $user->getMatch($potMatch);

                    if (!empty($match)) : ?>
                        <div class="matches float-left" style="display:block">
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
                                        <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id) ?>" hidden>
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