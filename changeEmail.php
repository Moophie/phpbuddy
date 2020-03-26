<?php
include_once(__DIR__ . "/classes/User.php");
User::changeEmail();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email change</title>
</head>
<body>

<form method="POST" action="">
    Password: <input type="password" name="password"><br/>
    New email: <input type="email" name="email"><br/>
    <input type="submit" value="change" name="submit">
</form>
    
</body>
</html>