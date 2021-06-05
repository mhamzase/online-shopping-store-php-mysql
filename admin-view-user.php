<?php

session_start();

if(isset($_POST['logout']))
{
	session_destroy();
	header("Location: login.php");
}
if(isset($_SESSION['username']))
{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin View Product</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
    <style>
        *{
            font-family:montserrat;
        }
    </style>
<body>
        <div style="min-height:86vh">
        <?php include "header.php" ?>

<a href="manage-users.php"><input type="button" value="Go back"style="margin-left:20px; font-size:20px;cursor:pointer;margin-top:20px;float:left; width:15%;
      height:50px;
      background-color:#2b2b2a;
      cursor:pointer;
      border:none;
      font-size:25px;
      color:white;margin-left: -100px;"></a>

   
<?php

include "connection.php";

       if(isset($_GET['id']))
       {
           $id = $_GET['id'];

           $sql = "SELECT * FROM users WHERE id = '$id'";
           $result = mysqli_query($conn,$sql);

           while ($row = mysqli_fetch_assoc($result)) {
               echo "<div style='width:60%;border:1px solid lightgray;padding:20px;margin:20px;float:left;font-size:23px'>";
               echo "<h1 style='text-align:center'>User Profile</h1>";
               echo"<b>Username </b> $row[username]<br><br>
               <b>Email : </b>$row[email]<br><br>
               <b>Status :  </b>$row[status]<br><br>
               <b>Phone :  </b>$row[phone]<br><br>
               <b>City :  </b>$row[city]<br><br>
               <b>Address :  </b>$row[address]<br><br>";
           echo "</div>";
           }

       }

        
   ?>

</div>

<hr width="80%" />
        </div>
    <?php 
	 
	 include "footer.php";
 ?>

</body>
</html>
<?php
}
else{
	header("Location: login.php");
}
?>