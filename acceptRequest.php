<?php

include "connection.php";

if(isset($_POST['accept']))
{
      $user_id = $_GET['id'];
      $status = 'active';

      $sql = "UPDATE users SET status = '$status' WHERE id = '$user_id'";
      $result = mysqli_query($conn,$sql);

      header("Location: admin-dashboard.php");
      
}



?>