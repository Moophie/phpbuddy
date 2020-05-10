<?php

spl_autoload_register();
session_start();

classes\Buddy\User::verify();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm registration</title>
</head>

<body>
    <h1>Your account has been confirmed!</h1>
    <h6><a href="index.php">Back to home</a><h6>
</body>

</html>