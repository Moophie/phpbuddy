<?php

include_once(__DIR__ . "/classes/User.php");

session_start();
var_dump($_SESSION['user']);
$u = new User();

$test = $u->getProfileImg();
var_dump($test);


?>