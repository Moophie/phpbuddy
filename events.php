<?php

include_once(__DIR__ . "/bootstrap.include.php");

if (!empty($_POST['createEvent'])) {
    $user = new classes\Buddy\User($_SESSION['user']);

    $event = new classes\Buddy\Event();
    $event->setTitle($_POST['title']);
    $event->setTimestamp($_POST['time']);
    $event->setDescription($_POST['description']);
    $event->setMax($_POST['max']);
    $event->setCreator($user->getFullname());
    $event->saveEvent();
}

if (!empty($_POST['joinEvent'])) {
    $user = new classes\Buddy\User($_SESSION['user']);
    $event = new classes\Buddy\Event($_POST['eventId']);
    if (($user->checkJoinedEvent($_POST['eventId']) == false) && ($event->amountParticipants() < $_POST['maxP'])) {
        $user->joinEvent($_POST['eventId']);
    }
}

$all_events = classes\Buddy\Event::getAllEvents();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
    <title>Events</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div>
        <div class="jumbotron float-left" style="width: 400px;">
            <h2>Organize an event!</h2>
            <br>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" placeholder="Describe the event you're organizing"></textarea>
                </div>
                <div class="form-group">
                    <label for="max">Maximum participants:</label>
                    <input type="number" class="form-control" id="max" name="max" min="2">
                </div>
                <div class="form-group">
                    <label for="time">Date and time</label>
                    <input type="datetime-local" class="form-control" id="time" name="time">
                </div>
                <div class="form-group">
                    <input type="submit" value="Create Event" name="createEvent">
                </div>
            </form>
        </div>
    </div>
    <div class="jumbotron float-left">
        <h2>List of events</h2>
        <br>
        <?php foreach ($all_events as $event) : ?>
            <?php 
            $e = new classes\Buddy\Event($event->id); 
            $amount_participants = $e->amountParticipants();
            ?>
            <div class="event float-left jumbotron">
                <h4><?php echo htmlspecialchars($event->title) ?></h4>
                <p><i>Created by <?php echo htmlspecialchars($event->creator) ?></i></p>
                <p><?php echo htmlspecialchars($event->description) ?></p>
                <p>Participants: <?php echo $amount_participants . "/" . htmlspecialchars($event->max); ?></p>
                <p><?php echo htmlspecialchars($event->timestamp) ?></p>
                <?php if ($user->checkJoinedEvent($event->id) == false) : ?>
                    <?php if ($amount_participants >= $event->max) : ?>
                        <p>Event is full</p>
                    <?php else : ?>
                        <form action="" method="POST">
                            <input type="text" name="eventId" value="<?php echo $event->id ?>" hidden>
                            <input type="text" name="maxP" value="<?php echo $event->max ?>" hidden>
                            <input type="submit" name="joinEvent" value="Join">
                        </form>
                    <?php endif; ?>
                <?php else : ?>
                    <p>You have already joined this event.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>