<?php

include_once(__DIR__ . "/bootstrap.include.php");

try {
    $classrooms = classes\Buddy\Classroom::getClassrooms($_GET['search']);
    str_replace("//", ".", $classrooms);
} catch (\Throwable $th) {
    $error = $th->getMessage();
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">
    <title>Classrooms</title>
</head>

<body>
    <?php include_once("nav.include.php"); ?>

    <div class="container">

        <div class="jumbotron center" style="margin-top:20px;">
            <?php if (isset($error)) : ?>
                <h2><?php echo $error ?></h2>
            <?php else : ?>
                <h2>Found Classrooms</h2>
        </div>

        <?php foreach ($classrooms as $classroom) : ?>
            <div class="jumbotron float-left" style="width:300px; margin-left:20px;">
                <h4>Classroom: <?php echo htmlspecialchars($classroom['name']); ?> </h4>
                <p>Building: <?php echo htmlspecialchars($classroom['building']); ?></p>
                <p>Floor: <?php echo htmlspecialchars($classroom['floor']); ?></p>
                <p>Class Number: <?php echo htmlspecialchars($classroom['room_number']); ?></p>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
    </div>

</body>

</html>