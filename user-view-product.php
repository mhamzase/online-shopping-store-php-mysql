<?php 

    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>User View Product</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
    <style>
    *{
        font-family:montserrat;
    }
        .backhome{
			width:8%;
			height:40px;
			background-color:black;
			cursor:pointer;
			font-size:25px;
			color:white;
            float:left;
            border:none;
            margin-top:20px;
		}
        .addtocart{
            width:25%;
			height:40px;
			background-color:#4ead67;
			cursor:pointer;
			font-size:20px;
			color:white;
            float:left;
            border:none;
            margin-top:20px;
            border-radius:5px;
        }.addtocart:hover{
            background-color:#3d9c56;
            
        }
        /* no of items */
        #noi{
            width:50px;
            height:30px;
            font-size:20px;
        }
    </style>
<body>
        <div style="min-height:87vh">
        <?php include "header.php" ?>

<a href="index.php"><input type="button" class="backhome" value="Home"></a>


<?php

include "connection.php";

       if(isset($_GET['id']))
       {
           $id = $_GET['id'];

           $sql = "SELECT * FROM products WHERE id = '$id'";
           $result = mysqli_query($conn,$sql);

           while ($row = mysqli_fetch_assoc($result)) {
               echo "<div style='width:50%;border:1px solid lightgray;padding:20px;margin:20px;float:left;font-size:23px'>";

               $image = $row['image'];
               echo "
                   <img src='$image' width='100%' height='400px' style='margin-bottom:20px'> 
                   <b>$row[title]</b><br><br>
                   <b>Description: </b>$row[description]<br><br>

                   <b>Unit Price: </b> Rs. $row[unit_price]<br><br>
                   <b>In Stock : </b>$row[quantity]<br><br>
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
                   
                   echo "<form action='' method='post'> 
                       <b>Quantity : </b><input required type='number' min='1' max='$row[quantity]' value='1' name='no_of_items' id='noi'><br>

                       <input name='product_id' type='hidden' value='$row[id]' />
                       <button class='addtocart' name='addtocart' type='submit'>Add to Cart</button>
                   </form>";
               echo "</div>";
           }

       }

        if(isset($_POST['addtocart']))
        {
           if(isset($_SESSION['username']))
           {
               $username = $_SESSION['username'];
               $result = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
               $user= mysqli_fetch_assoc($result);
               $user_id = $user['id'];

               $no_of_items = $_POST['no_of_items'];
               $product_id = $_POST['product_id'];

               $product_found = false;

               $product_fetch = mysqli_query($conn, "SELECT product_id FROM cart WHERE user_id = '$user_id'");
               while ($product_result = mysqli_fetch_array($product_fetch)) {
                   if($product_result['product_id'] == $product_id)
                   {
                       $product_found = true;
                   }
               }

               if($product_found)
               {
                   $old_no_of_items = mysqli_query($conn,"SELECT no_of_items FROM cart WHERE user_id = '$user_id' and product_id = '$product_id'");
                   $old_items_result = mysqli_fetch_array($old_no_of_items);

                   $no_of_items = $no_of_items + $old_items_result['no_of_items'];

                   if(mysqli_query($conn,"UPDATE cart SET no_of_items = '$no_of_items' WHERE user_id = '$user_id' and product_id = '$product_id'"))
                   {
                       header("Location: cart.php");
                   }
               }
               else
               {
                   if(mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `product_id`, `no_of_items`) VALUES ('$user_id','$product_id','$no_of_items')"))
                   {
                       header("Location: cart.php");
                   }
               }

               
           }
           else
           {
               header("Location: login.php");                 
           }
        }
   ?>
<hr width="80%" />
</div>

        </div>
    <?php 
	 
	 include "footer.php";
 ?>


</body>
</html>