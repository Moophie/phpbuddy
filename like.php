<?php

include_once(__DIR__ . "/classes/Db.php");

// Here you can add code to save the values in the database
// Getting the reaction from Ajax and printing

$data_reaction = $_POST['data_reaction'];
$message_id = $_POST['message_id'];

$conn = Db::getConnection();
$statement = $conn->prepare("UPDATE messages SET rating = :rating WHERE id = :message_id ");
$statement->bindValue(":rating", $data_reaction);
$statement->bindValue(":message_id", $message_id);
$result = $statement->execute();


?>