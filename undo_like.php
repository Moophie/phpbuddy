<?php

include_once(__DIR__ . "/classes/Db.php");

$data_reaction = "";
$message_id = $_POST['message_id'];

$conn = Db::getConnection();
$statement = $conn->prepare("UPDATE messages SET reaction = :reaction WHERE id = :message_id ");
$statement->bindValue(":reaction", $data_reaction);
$statement->bindValue(":message_id", $message_id);
$result = $statement->execute();

