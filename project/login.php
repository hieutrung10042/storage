<?php
require_once "connect.php";

session_start();



$data = mysqli_connect($host,$user,$password,$db);
if($data == false)
{
    die("connection error");
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    

    $sql = "SELECT * FROM login WHERE username= '".$username."' AND password = '".$password."' ";
    $result = mysqli_query($data,$sql);
    $row = mysqli_fetch_array($result);
    if($row["role"]=="user")
    {   
        $_SESSION["username"]=$username;
        header("location:userhome.php");
    }
    elseif($row["role"]=="admin")
    {
        $_SESSION["username"]=$username;
        header("location:adminhome.php");
    }
    else
    {
        echo"username or password incorrect";
    }
}
?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <center>
        <h1>Login Form</h1>
        <br><br><br><br>
        <div style="background-color:gray; width:500px;">
            <br><br>
            <form action="#" method="POST">
                <div>
                    <label for="">username</label>
                    <input type="text" name="username" require>
                </div>
                <br><br>
                <div>
                    <label for="">pasword</label>
                    <input type="text" name="password" require>
                </div>
                <br><br>
                <div>
                    <input type="submit" value="login">
                </div>
            </form>
            <br><br>

        </div>
    </center>
</body>

</html>