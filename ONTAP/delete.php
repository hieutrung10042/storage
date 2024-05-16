<?php
include 'header.php';
include "D8.php";
include "code.php";

if($conn){
    if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = " DELETE FROM user WHERE ID = $id ";
      $delete = mysqli_query($conn,$sql);
      header('location:user.php');
    } 
    else {
        echo "Không có user_id được gửi.";
    }
}
?>