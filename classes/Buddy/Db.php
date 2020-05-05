<?php

namespace classes\Buddy;

include_once(__DIR__ . "/../../settings/settings.php");

class Db
{
    private static $conn;

    public static function getConnection()
    {
        //If there's no connection yet
        if (self::$conn === null) {

            //Make a new connection
            //Fill in new PDO's arguments in with the values found in the settings file
            self::$conn = new \PDO('mysql:host=' . SETTINGS['db']['host'] . ';port=' . SETTINGS['db']['port'] . ';dbname=' . SETTINGS['db']['dbname'], SETTINGS['db']['user'], SETTINGS['db']['password']);

            return self::$conn;
        } else {
            return self::$conn;
        }
    }
}
