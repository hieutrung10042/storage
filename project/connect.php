<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "user";

// Create connection
$conn = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
