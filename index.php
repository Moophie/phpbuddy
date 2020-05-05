<?php

include_once(__DIR__ . "/bootstrap.include.php");

require(__DIR__ . "/sendgrid/sendgrid-php.php");
putenv("SENDGRID_API_KEY=***REMOVED***");

$email = $_SESSION['user'];
$user = new classes\Buddy\User($email);

//Get all the users from the database except for the active user
$potential_matches = $user->getAllExceptUser();
$registered_count = $user->totalRegistration();
$total_buddy_count = $user->totalBuddies();

//If someone sends a buddy suggestion
if (!empty($_POST['getBuddy'])) {

    //Update the buddy_id in the database
    $user->updateBuddy();

    $sgmail = new \SendGrid\Mail\Mail();
    $sgmail->setFrom("michael.van.lierde@hotmail.com", "IMD Buddy");
    $sgmail->setSubject("Someone sent you a buddy request!");
    $sgmail->addTo($_POST['buddy_email'], $_POST['buddy_name']);
    $sgmail->addContent("text/plain", "You've received a buddy request on IMD Buddy from " .  $user->getFullname());

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    $sendgrid->send($sgmail);

    //Create a conversation
    $conversation = new classes\Buddy\Conversation();
    $conversation->setUser_1($user->getId());
    $conversation->setUser_2($_POST['buddy_id']);
    $conversation->saveConversation();
}

if (!empty($_POST['acceptBuddy'])) {
    if ($_POST['acceptBuddy'] == "Accept") {

        //Make the other person your buddy
        $user->updateBuddy();
    } elseif ($_POST['acceptBuddy'] == "Reject") {

        //Remove yourself as buddy
        $user->removeBuddy();
        $user->removeConversation();

        //Prompt box for rejecting reason
        echo "<script>var reason = prompt('Would you like telling the reason for this rejection?', 'Write reason here');</script>";
    }
}

if (!empty($_POST['unmatch'])) {
    $conn = classes\Buddy\Db::getConnection();

    if ($_POST['buddy_id'] == $user->getId()) {
        $user->unmatch();
    } else {
        $user->unmatch();
    }

    $user->removeConversation();
}

$user_buddy = classes\Buddy\User::findBuddy($user->getEmail());

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
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

    <div class="container" style="height:250px; margin-top: 20px; margin-bottom:20px;">
        <div class="jumbotron float-left" style="width:60%; height:250px;">
            <div>
                <h2>Welcome back, <?php echo htmlspecialchars($user->getFullname()) ?></h2>
                <br>
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
        <div class="jumbotron float-right" style="width:38%; height:250px;">
            <h4>Buddy application statistics</h4>
            <div>
                <p><strong>Registered users:</strong> <?php echo $registered_count ?> <?php ?> </p>
            </div>
            <div>
                <p><strong>Buddy relations:</strong> <?php echo $total_buddy_count ?> </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="jumbotron">
            <h2>Find your classroom here:</h2>
            <form action="classrooms.php" method="get">
                <input type="text" name="search" class="search" placeholder="Z3.04" autocomplete="off">
                <input type="submit" name="submit_search" value="search" class="search_submit">
                <div class="suggestions"></div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="jumbotron">
            <div class="center" style="height:450px;">
                <!-- If the user has no buddy yet, show suggestions -->

                <?php if (empty($user->getBuddy_id())) : ?>

                    <h2>Potential Buddies</h2>
                    <!-- Loop over all the other users -->
                    <?php foreach ($potential_matches as $potential_match) :

                        //Check each user for a match
                        $match = $user->getMatch($potential_match);

                        //If the function returns a match, print it out
                        if (!empty($match) && (empty($match->buddy_id) || $match->buddy_id == $user->getId())) : ?>
                            <div class="matches float-left" style="display:block">
                                <h4><?= $match->fullname ?></h4>
                                <img src="./uploads/<?= htmlspecialchars($match->profile_img) ?>" width="100px;" height="100px;" />
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
                                                <input type="text" name="buddy_name" value="<?= htmlspecialchars($match->fullname) ?>" hidden>
                                                <input type="text" name="buddy_email" value="<?= htmlspecialchars($match->email) ?>" hidden>
                                                <input type="submit" name="getBuddy" value="Send buddy request!">
                                            </form>
                                        <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php if ($user_buddy->buddy_id == $user->getId()) : ?>
                        <h2 style="margin-top:-30px; padding-bottom: 20px">Your buddy</h2>
                    <?php else : ?>
                        <h2 style="margin-top:-30px; padding-bottom: 20px">You have sent a request to:</h2>
                    <?php endif; ?>
                    <div class="d-flex flex-row border rounded">
                        <div class="p-0 w-25">
                            <img src="./uploads/<?= htmlspecialchars($user_buddy->profile_img); ?>" class="img-thumbnail border-0" />
                        </div>
                        <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
                            <h4 class="text-primary"><?= htmlspecialchars($user_buddy->fullname); ?></h4>
                            <h6>Things you have in common:</h6>
                            <!-- Check all attributes for common ones and then print them out -->
                            <?php if ($user_buddy->location == $user->getLocation()) : ?>
                                <p><?= "Location: " . htmlspecialchars($user_buddy->location); ?><p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->games == $user->getGames()) : ?>
                                        <p><?= "Video games: " . htmlspecialchars($user_buddy->games); ?></p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->music == $user->getMusic()) : ?>
                                        <p><?= "Music: " . htmlspecialchars($user_buddy->music); ?></p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->films == $user->getFilms()) : ?>
                                        <p><?= "Movies: " . htmlspecialchars($user_buddy->films); ?></p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->books == $user->getBooks()) : ?>
                                        <p><?= "Books: " . htmlspecialchars($user_buddy->books); ?></p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->study_pref == $user->getStudy_pref()) : ?>
                                        <p><?= "Same study preferences: " . htmlspecialchars($user_buddy->study_pref); ?></p>
                                    <?php endif; ?>
                                    <?php if ($user_buddy->hobby == $user->getHobby()) : ?>
                                        <p><?= "Hobby: " . htmlspecialchars($user_buddy->hobby); ?></p>
                                    <?php endif; ?>
                                    <form action="" method="POST">
                                        <input type="text" name="buddy_id" value="<?php echo $user_buddy->buddy_id; ?>" hidden>
                                        <input type="submit" class="btn btn-danger" name="unmatch" value="Unmatch Buddy">
                                    </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <script src="js/jquery.min.js"></script>
    <script src="js/autocomplete.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/2b908491a1.js" crossorigin="anonymous"></script>
</body>

</html>