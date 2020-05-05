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
    if (($user->checkJoinedEvent($_POST['eventId']) == false) && ($event->checkFull() == false)) {
        $user->joinEvent($_POST['eventId']);
    }
}

$allEvents = classes\Buddy\Event::getAllEvents();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/phpbuddy.css">
    <title>Events</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div>
        <div>
            <?php foreach ($allEvents as $event) : ?>
                <?php $e = new classes\Buddy\Event($event->id) ?>
                <div class="event" style="border:1px black solid; max-width: 800px; margin-bottom:10px; padding:5px">
                    <strong><?php echo htmlspecialchars($event->title) ?></strong>
                    <br>
                    <p><i><?php echo htmlspecialchars($event->description) ?></i></p>
                    <p><?php echo htmlspecialchars($event->max) ?></p>
                    <p><?php echo htmlspecialchars($event->timestamp) ?></p>
                    <p><i>Created by <?php echo htmlspecialchars($event->creator) ?></i></p>
                    <?php if ($user->checkJoinedEvent($event->id) == false) : ?>
                        <?php if ($e->checkFull() == false) : ?>
                            <form action="" method="POST">
                                <input type="text" name="eventId" value="<?php echo $event->id ?>" hidden>
                                <input type="submit" name="joinEvent" value="Join">
                            </form>
                        <?php else : ?>
                            <br>
                            <p>Event is full</p>
                        <?php endif; ?>
                    <?php else : ?>
                        <br>
                        <p>You have already joined this event.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
        <form action="" method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
            <br>
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Describe the event you're organizing"></textarea>
            <br>
            <label for="max">Maximum participants:</label>
            <input type="number" id="max" name="max" min="2">
            <br>
            <label for="time"></label>
            <input type="datetime-local" id="time" name="time">
            <br>
            <input type="submit" value="Create Event" name="createEvent">
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
</body>

</html>