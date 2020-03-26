<?php
include_once(__DIR__ . "/classes/User.php");
User::changePassword();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password change</title>
</head>
<body>

<form method="POST" action="">
    Old Password: <input type="password" name="oldpassword"><br/>
    New Password: <input type="password" name="newpassword"><br/>
    <input type="submit" value="change" name="submit">
</form>
    
</body>
</html>