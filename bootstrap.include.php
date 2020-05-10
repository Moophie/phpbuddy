<?php

namespace classes;

//Set up autoloading
spl_autoload_register();
//Start the session
session_start();

//Get the path
$page = basename($_SERVER['PHP_SELF']);

//If there's no active session, redirect to login.php
if($page == "login.php" || $page == "register.php"){
    if (!empty($_SESSION['user'])) {
        header("Location: index.php");
    }
} else {
    if (empty($_SESSION['user'])) {
        header("Location: login.php");
    }
}
