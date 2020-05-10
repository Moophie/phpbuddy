<?php

include_once(__DIR__ . "/bootstrap.include.php");

require(__DIR__ . "/sendgrid/sendgrid-php.php");
putenv("SENDGRID_API_KEY=***REMOVED***");

$email = $_SESSION['user'];
$user = new classes\Buddy\User($email);

if (!empty($_POST['unmatch'])) {
    $conn = classes\Buddy\Db::getConnection();

    if ($_POST['buddy_id'] == $user->getId()) {
        $user->unmatch();
    } else {
        $user->unmatch();
    }

    $user->removeConversation();
}

//If someone sends a buddy suggestion
if (!empty($_POST['getBuddy'])) {

    //Update the buddy_id in the database
    $user->updateBuddy();

    //Create a conversation
    $conversation = new classes\Buddy\Conversation();
    $conversation->setUser_1($user->getId());
    $conversation->setUser_2($_POST['buddy_id']);
    $conversation->saveConversation();

    $sgmail = new \SendGrid\Mail\Mail();
    $sgmail->setFrom("no-reply@imdbuddy.be", "IMD Buddy");
    $sgmail->setSubject("Someone sent you a buddy request!");
    $sgmail->addTo($_POST['buddy_email'], $_POST['buddy_name']);
    $sgmail->addContent("text/plain", "You've received a buddy request on IMD Buddy from " .  $user->getFullname());

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    $sendgrid->send($sgmail);
}

if (!empty($_POST['acceptBuddy'])) {
    if ($_POST['acceptBuddy'] == "Accept") {

        //Make the other person your buddy
        $user->updateBuddy();
    } elseif ($_POST['acceptBuddy'] == "Reject") {

        //Remove yourself as buddy
        $user->removeBuddy();
        $user->removeConversation();

        $mail_content = "Unfortunately, " .  $user->getFullname() . " has denied your request to be buddies.";

        //Check if there's a reason for the rejection and put it in the email content
        if(!empty($_POST['reason'])){
            $mail_content = "Unfortunately, " .  $user->getFullname() . " has denied your request to be buddies.\nReason:\n" . $_POST['reason'];
        }

        $sgmail = new \SendGrid\Mail\Mail();
        $sgmail->setFrom("no-reply@imdbuddy.be", "IMD Buddy");
        $sgmail->setSubject("Someone has rejected your buddy request");
        $sgmail->addTo($_POST['buddy_email'], $_POST['buddy_name']);
        $sgmail->addContent("text/plain", $mail_content);

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $sendgrid->send($sgmail);
    }
}

//Get all the users from the database except for the active user
$potential_matches = $user->getAllExceptUser();
$registered_count = classes\Buddy\User::totalRegistration();
$total_buddy_relations = classes\Buddy\User::totalBuddies();

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
    <title>IMD Buddy</title>
</head>

<body>

    <?php include_once("nav.include.php") ?>

    <div class="container" style="height:250px;">
        <div class="jumbotron float-left" style="width:50%; height:230px;">
            <div>
                <h2>Welcome back, <?php echo htmlspecialchars($user->getFullname()) ?></h2>
                <br>
                <div class="center">
                    <?php if (!($user->checkProfileComplete())) : ?>
                        <p>It seems your profile is not completed yet.</p>
                        <form action="profile.php">
                            <input type="submit" class="btn-default btn-lg btn-primary" Value="Complete your profile!">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="jumbotron float-right" style="width:46%; height:230px;">
            <h2>Buddy application statistics</h2>
            <br>
            <div>
                <p><strong>Registered users:</strong> <?php echo $registered_count ?> <?php ?> </p>
            </div>
            <div>
                <p><strong>Buddy relations:</strong> <?php echo $total_buddy_relations ?> </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="jumbotron" style="height: 125px;">
            <h2>Find your classroom here:</h2>
            <form action="classrooms.php" method="GET">
                <input type="text" name="search" class="search" style="border:none; margin-right:20px; padding-right:20px; padding-bottom:10px;" placeholder="Z3.04" autocomplete="off">
                <input type="submit" name="submit_search" value="Search" class="btn btn-dark">
                <div class="suggestions" style="z-index: 1000; position:relative"></div>
            </form>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="center">
            <div class="jumbotron">
                <!-- If the user has no buddy yet, show suggestions -->
                <?php if (empty($user->getBuddy_id())) : ?>
                    <h2>Potential Buddies</h2>
            </div>
            <!-- Loop over all the other users -->
            <?php foreach ($potential_matches as $potential_match) :

                        //Check each user for a match
                        $match = $user->getMatch($potential_match);

                        //If the function returns a match, print it out
                        if (!empty($match) && (empty($match->buddy_id) || $match->buddy_id == $user->getId())) : ?>
                    <div class="matches float-left">
                        <h3><?= $match->fullname ?></h3>
                        <div class="img-div">
                            <img class="img-match" src="./uploads/<?= htmlspecialchars($match->profile_img) ?>" />
                        </div>

                        <!-- Check all attributes for common ones and then print them out -->
                        <?php if ($match->location == $user->getLocation()) : ?>
                            <h6>Location</h6>
                            <h5><?= htmlspecialchars($match->location); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->games == $user->getGames()) : ?>
                            <h6>Video Games</h6>
                            <h5><?= htmlspecialchars($match->games); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->music == $user->getMusic()) : ?>
                            <h6>Music</h6>
                            <h5><?= htmlspecialchars($match->music); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->films == $user->getFilms()) : ?>
                            <h6>Movies</h6>
                            <h5><?= htmlspecialchars($match->films); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->books == $user->getBooks()) : ?>
                            <h6>Books</h6>
                            <h5><?= htmlspecialchars($match->books); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->study_pref == $user->getStudy_pref()) : ?>
                            <h6>Study Preference</h6>
                            <h5><?= htmlspecialchars($match->study_pref); ?></h5>
                        <?php endif; ?>
                        <?php if ($match->hobby == $user->getHobby()) : ?>
                            <h6>Hobby</h6>
                            <h5><?= htmlspecialchars($match->hobby); ?></h5>
                        <?php endif; ?>

                        <?php if ($match->buddy_id == $user->getId()) : ?>
                            <form action="" method="POST">
                                <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id) ?>" hidden>
                                <input class="button-accept" type="submit" name="acceptBuddy" value="Accept">
                            </form>
                            <form action="" method="POST">
                                <input type="text" name="buddy_email" value="<?= htmlspecialchars($match->email) ?>" hidden>
                                <input type="text" name="buddy_name" value="<?= htmlspecialchars($match->fullname) ?>" hidden>
                                <input class="reject-reason" type="text" name="reason" value="" hidden>
                                <input class="button-reject" type="submit" name="acceptBuddy" value="Reject">
                            </form>
                        <?php else : ?>
                            <form action="" method="POST">
                                <input type="text" name="buddy_id" value="<?= htmlspecialchars($match->id) ?>" hidden>
                                <input type="text" name="buddy_name" value="<?= htmlspecialchars($match->fullname) ?>" hidden>
                                <input type="text" name="buddy_email" value="<?= htmlspecialchars($match->email) ?>" hidden>
                                <input class="button-sbm" type="submit" name="getBuddy" value="Send buddy request!">
                            </form>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    </div>

<?php else : ?>
    <?php if ($user_buddy->buddy_id == $user->getId()) : ?>

        <div class="container" style="margin-top: 20px;">
            <div class="center">
                <div class="jumbotron">
                    <h2>Your buddy</h2>
                <?php else : ?>
                    <h2>You have sent a request to:</h2>
                <?php endif; ?>
                </div>

                <div class="matches float-left">
                    <h3><?= htmlspecialchars($user_buddy->fullname); ?></h3>
                    <img class="img-match" src="./uploads/<?= htmlspecialchars($user_buddy->profile_img); ?>" />

                    <!-- Check all attributes for common ones and then print them out -->
                    <?php if ($user_buddy->location == $user->getLocation()) : ?>
                        <h6>Location</h6>
                        <h5><?= htmlspecialchars($user_buddy->location); ?><h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->games == $user->getGames()) : ?>
                                <h6>Video Games</h6>
                                <h5><?= htmlspecialchars($user_buddy->games); ?></h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->music == $user->getMusic()) : ?>
                                <h6>Music</h6>
                                <h5><?= htmlspecialchars($user_buddy->music); ?></h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->films == $user->getFilms()) : ?>
                                <h6>Movies</h6>
                                <h5><?= htmlspecialchars($user_buddy->films); ?></h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->books == $user->getBooks()) : ?>
                                <h6>Books</h6>
                                <h5><?= htmlspecialchars($user_buddy->books); ?></h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->study_pref == $user->getStudy_pref()) : ?>
                                <h6>Study Preference</h6>
                                <h5><?= htmlspecialchars($user_buddy->study_pref); ?></h5>
                            <?php endif; ?>

                            <?php if ($user_buddy->hobby == $user->getHobby()) : ?>
                                <h6>Hobby</h6>
                                <h5><?= htmlspecialchars($user_buddy->hobby); ?></h5>
                            <?php endif; ?>

                            <form action="" method="POST">
                                <input type="text" name="buddy_id" value="<?php echo $user_buddy->buddy_id; ?>" hidden>
                                <input type="submit" class="btn btn-danger" name="unmatch" value="Unmatch Buddy">
                            </form>
                </div>
            <?php endif; ?>
            </div>
        </div>



        <script src="js/jquery.min.js"></script>
        <script src="js/index.js"></script>
        <script src="js/bootstrap.js"></script>
</body>

</html>