<?php
include_once(__DIR__ . "/classes/Db.php");

$validation_string = $_GET['code'];

$conn = Db::getConnection();
$statement = $conn->prepare("UPDATE users SET active = 1 WHERE validation_string = :validation_string");
$statement->bindValue(":validation_string", $validation_string);
$statement->execute();

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