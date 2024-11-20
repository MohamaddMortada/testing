<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "namedb";


$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}?>