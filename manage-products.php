<?php
include "connection.php";
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
	<title>Manage Products</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/signup.css"> -->
	<style>
		*{
			font-family: Montserrat;
		}
		.bodybtn{
			width:30%;
			height:230px;
			background-color:skyblue;
			margin:20px;
			cursor:pointer;
			border:none;
			font-size:25px;
		}
        .erorrMessage{
			color:red;
			text-align:center;
		}
		.successMessage{
			color:blue;
			text-align:center;
		}
        .registration{
            text-align:center;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        input{
            width:250px;
            height:30px;
            font-size:15px;
			margin:2px;
        }
		.actions{
			padding:10px;
			cursor:pointer;
			border:none;
			margin-left:10px;
		}
		#update{
			background-color:#6182c9;
			color:white;
		}
		#remove{
			background-color:#c95b53;
			color:white;
		}
		#view{
			background-color:#4ead67;
			color:white;
		}
		#color{
			width:260px;
			height:36px;
			font-size:18px;
		}
		#size{
			width:260px;
			height:36px;
			font-size:18px;
		}
		.bodybtn{
			width:15%;
			height:50px;
			background-color:#2b2b2a;
			margin-left:15%;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;
		}
	</style>
<body>
<?php include "header.php" ?>

	 <a href="admin-dashboard.php"><input class="bodybtn" type="button" value="Go to Dashboard"style=" font-size:20px;cursor:pointer;margin-top:20px;float:left; margin-left: -10%;"></a>

	 <a href="add-product.php">
	 <button class="bodybtn" style="float: right;">
	 Add Product
	 </button>
	 </a>
		<div style="text-align:center;margin-top: 25px;">
		

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSearchProduct()">
				<input type="text" id="searchProduct" name="searchProduct" placeholder="Search..."  value="<?PHP if(isset($_POST['searchBtn'])) echo htmlspecialchars($_POST['searchProduct']); ?>"/>
				<button name="searchBtn" type="submit" style="padding:8px;cursor:pointer">Search Product</button>
			</form>

			<p id="searchMessage" ></p>
			<div style="margin-top:20px">
		<table style="border:1px solid black;margin:auto;border-collapse:collapse">
		
		<?php 
			if(isset($_POST['searchBtn']))
			{
				$searchProduct = $_POST['searchProduct'];
				$sql = "SELECT * FROM products WHERE LOWER(title) LIKE LOWER('%$searchProduct%')";
				$record = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($record);

				if($isFound)
				{
					while ($row = mysqli_fetch_assoc($record)) {
						echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
						
						<a href='admin-view-product.php?id=$row[id]'> 
							<button  type='submit' name='view' id='view' class='actions' >View</button>
						</a>
		
						<a href='update-product.php?id=$row[id]'> 
							<button  type='submit' name='edit' id='update' class='actions' >Update</button>
						</a>
						<a href='remove-product.php?id=$row[id]'>
							<button  type='submit' name='remove' id='remove' class='actions' >Remove</button>
						</a>";
		
		
						$image = $row['image'];
						echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
						<b>$row[title]</b><br>
						$row[description]<br>
						</div>";
					 }
				}
				else
				{
					?>
						<p style="color:red">Product Not Found!</p>
					<?php
				}
			
			}
		?>
		</table>
	</div>

	</div>


	
	<hr width="90%">
	


     <br/><br/>
     <div class="allproducts">
     <h1 style="text-align:center">All Products</h1>
	
	     <?php 
	
		     
		     $sql = "SELECT * FROM products ORDER BY id DESC";
		     $result = mysqli_query($conn,$sql);

		     while ($row = mysqli_fetch_assoc($result)) {
				echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
				
				<input name='product_id' type='hidden' value='$row[id]' />
				<a href='admin-view-product.php?id=$row[id]'> 
					<button  type='submit' name='view' id='view' class='actions' >View</button>
				</a>

				<a href='update-product.php?id=$row[id]'> 
					<button  type='submit' name='edit' id='update' class='actions' >Update</button>
				</a>
				<a href='remove-product.php?id=$row[id]'>
					<button  type='submit' name='remove' id='remove' class='actions' >Remove</button>
				</a>";


				$image = $row['image'];
				echo "
				<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br>
				<b>$row[title]</b><br>";
				echo substr($row['description'],0,40);
				echo "...<br>
				
				</div>";
		     }
	    ?>

	</div>
	 <!-- <script src="js/signup.js"></script> -->

	 <script>


function validateSearchProduct()
{
	let searchProduct = document.getElementById("searchProduct");
	let searchMessage = document.getElementById("searchMessage");

	if(searchProduct.value.trim() == "")
	{
		searchMessage.innerText = "field is required !";
        messageErorr(searchMessage);
        return false;
	}
	return true;
}

function validateProduct()
{
      let title = document.getElementById("title");
      let unit_price = document.getElementById("unit_price");
      let quantity = document.getElementById("quantity");
      let color = document.getElementById("color");
      let image = document.getElementById("image");
      let weight = document.getElementById("weight");
      let size = document.getElementById("size");
      let description = document.getElementById("description");
      let message = document.getElementById("message");


      if(title.value.trim() == "" || unit_price.value.trim() == "" || quantity.value.trim() == "" || color.value == "" || image.value == "" || quantity.value.trim() == "" || description.value.trim() == "" )
      {
            message.innerText = "All fields required !";
            messageErorr(message);
            return false;
      }
      else
      {

            if(isNaN(unit_price.value))
            {
                  message.innerText = "Invalid unit price!";
                  messageErorr(message);
                  return false;
            }
            else{
                if(isNaN(quantity.value))
				{
					message.innerText = "Invalid quantity!";
                    messageErorr(message);
                    return false;
				}    
				else{
					if(weight.value.trim() != "")
					{
						if(isNaN(weight.value))
						{
							message.innerText = "Invalid weight!";
							messageErorr(message);
							return false;
						}
						else{
							return true;
						}
					}
					else{
						return true;
					}
				} 
            }
      }

}



function messageErorr(message){
            message.style.display = "block";
            message.style.color = "red";
            message.style.textAlign = "center";
}



function messageSuccess(message){
      message.style.display = "block";
      message.style.color = "blue";
      message.style.textAlign = "center";
}
	 </script>
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