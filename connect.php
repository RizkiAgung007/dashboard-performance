<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "data_master";

// Create connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if(!$conn) {
    die ("Database connection error");
};
?>