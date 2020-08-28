<?php


function connectDB() {

        $host = "localhost";
        $user = "cruddemo";
        $password = "cruddemo";
        $dbname = "cruddemo";

        static $mysqli = null;
        if(!isset($mysqli)) {
            $mysqli = new mysqli($host,$user,$password,$dbname);
        }

        // error
        if($mysqli->connect_error) {
            die("Sorry database is offline, error: $mysqli->connect_error");
        }
        return $mysqli;


}

