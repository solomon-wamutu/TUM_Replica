<?php
$dbuser = "root";
$dbpass = "";
$dbhost = "localhost";
$db = "tum";
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);

// if ($mysqli->connect_error) {
//     die("Connection failed: " . $mysqli->connect_error);
// }

// echo "Connected successfully";