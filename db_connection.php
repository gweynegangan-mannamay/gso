<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "vehicle_system2"; // Change this to your actual database name

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$con) {
    die("Failed to connect: " . mysqli_connect_error());
}