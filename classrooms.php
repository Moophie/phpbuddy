<?php

include_once(__DIR__ . "/bootstrap.include.php");

$classrooms = classes\Buddy\Classroom::getClassroom($_GET['search']);
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
    <title>Classrooms</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="container">
        <div class="jumbotron center" style="margin-top:20px;">
            <h2>Found Classrooms</h2>
        </div>
        <?php if ($classrooms > 0) :  foreach ($classrooms as $class) : ?>
                <div class="jumbotron float-left" style="width:300px; margin-left:20px;">
                    <h4>Classroom: <?php echo $class['name']; ?> </h4>
                    <p>Building: <?php echo $class['building']; ?></p>
                    <p>Floor: <?php echo $class['floor']; ?></p>
                    <p>Class Number: <?php echo $class['room_number']; ?></p>
                </div>

            <?php endforeach; ?>
        <?php else : ?>
            <p>No classrooms found!</p>
        <?php endif; ?>
    </div>

</body>

</html>