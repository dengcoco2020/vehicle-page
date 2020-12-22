<?php

function getConnection() {
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db_name = "vehiclepage_db";    
    $db = new mysqli($host, $user, $pass, $db_name);
    mysqli_set_charset($db, 'utf8');
    return $db;    
}