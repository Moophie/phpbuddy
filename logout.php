<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Remove session variables
unset($_SESSION["user"]);

//Destroy session
session_destroy();

//Redirect to homepage
header("Location: index.php");
