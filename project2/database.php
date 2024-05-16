<?php
$servername ="localhost";
$username = "root";
$pass ="";
$dbname="user";
$conn = mysqli_connect($servername,$username,$pass,$dbname);
if(!$conn)
{
    die("connection error:");
}


?>