<?php

include_once(__DIR__ . "/bootstrap.include.php");

//If there's no active session, redirect to login.php
if (empty($_SESSION['user'])) {
    header("Location: login.php");
}

//Remove session variables
unset($_SESSION["user"]);

//Destroy session
session_destroy();

//Redirect to homepage
header("Location: index.php");
