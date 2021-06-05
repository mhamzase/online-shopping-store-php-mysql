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
<?php include "header.php" ?>

	 <a href="manage-products.php"><input type="button" value="Go back"style="margin-left:20px; font-size:20px;cursor:pointer;margin-top:20px;float:left"></a>
    

	<?php

include "connection.php";

            if(isset($_GET['id']))
            {
                $id = $_GET['id'];

                $sql = "SELECT * FROM products WHERE id = '$id'";
                $result = mysqli_query($conn,$sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div style='width:60%;border:1px solid lightgray;padding:20px;margin:20px;float:left;font-size:23px'>";

                    $image = $row['image'];
                    echo "
                    <img src='$image' width='100%' height='400px' style='margin-right:30px;margin-top:15px;float:left'> 
                    <b>Title: </b> $row[title]<br><br>
                    <b>Description: </b>$row[description]<br><br>

                    <b>Unit Price: </b> Rs. $row[unit_price]<br><br>
                    <b>In Stock :</b>$row[quantity]<br><br>
                    <b>Color: </b>$row[color]<br><br>";
                    if($row['size'] != "")
                    {
                        echo "<b>Size: </b>";
                        echo strtoupper($row['size']); 
                        echo "<br><br>";
                    }
                    if($row['weight'] != "")
                    {
                        echo "<b>Weight: </b>$row[weight] g<br><br>";
                    }
                echo "</div>";
                }

            }

		     
	    ?>

	</div>

    <hr width="80%" />
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