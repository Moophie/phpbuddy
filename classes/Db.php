<?php

    class Db {
        
        private static $conn; //static zorgt dat je maar 1 uitwerking/bestaande vorm ervan hebt

        public static function getConnection() {
            include_once(__DIR__ . "/../settings/settings.php");
           
            if(self::$conn === null) {
                self::$conn = new PDO('mysql:host=' . SETTINGS['db']['host'] . ';port=' . SETTINGS['db']['port'] . ';dbname=' . SETTINGS['db']['dbname'], SETTINGS['db']['user'], SETTINGS['db']['password']);

                return self::$conn;
            }else {
                return self::$conn;
            }
            
        }  
    }