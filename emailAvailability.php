<?php

spl_autoload_register();
session_start();

if (isset($_POST["emailAvailability"])) :
    $conn = classes\Buddy\Db::getConnection();
    $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
    $statement->bindValue(":email", $_POST["emailAvailability"]);
    $statement->execute();
    $result = $statement->rowCount();
    echo $result;
endif;
