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
	<title>Admin dashboard</title>
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
           
            display:flex;
            justify-content:center;
            align-items:center;
            
        }
        .bodybtn{
			width:15%;
			height:50px;
			background-color:#2b2b2a;
			margin-left:15%;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white
		}
        input{
            width:250px;
            height:30px;
            font-size:15px;
			margin:2px;
        }
		.actions{
			padding:10px;
			margin-left:20px;
			cursor:pointer;
			border:none;
		}
		#update{
			background-color:blue;
			color:white;
		}
		#remove{
			background-color:red;
			color:white;
		}
		#view{
			background-color:green;
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
		#category{
			width:99%;
			height:36px;
			font-size:18px;
		}
	</style>
<body>
		<?php include "header.php" ?>

		
	 <a href="manage-products.php"><input type="button" value="Go Back"style="margin-left:20px; font-size:20px;cursor:pointer;margin-top:20px;float:left;width:15%;
			height:50px;
			background-color:#2b2b2a;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;">
		</a>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateProduct()" enctype="multipart/form-data">
    <br><br>
    <!-- <p style="font-size:30px;font-weight:bold;text-align:center ">Add Product</p> -->
	<p id="message" ></p>

	<?php

include "connection.php";

	if(isset($_POST['addProductBtn']))
	{	
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$unit_price = mysqli_real_escape_string($conn, $_POST['unit_price']);
		$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
		$color = mysqli_real_escape_string($conn, $_POST['color']);
		$weight = mysqli_real_escape_string($conn, $_POST['weight']);
		$size = mysqli_real_escape_string($conn, $_POST['size']);
		$category = mysqli_real_escape_string($conn, $_POST['category']);
		$description = mysqli_real_escape_string($conn, $_POST['description']);


		$var1 = rand(111,999);  // generate random number in $var1 variable
		$var2 = md5($var1);     // convert $var3 using md5 function and generate 32 characters hex number

		$target_dir = "uploads/";
		$target_file = $target_dir.$var2 .".". basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check !== false)
		{
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
			{
				?>
				<p style="color:red;text-align:center">Sorry, only JPG, JPEG & PNG files are allowed.</p>
				<?php
				$uploadOk = 0;
			}
			else
			{
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file))
				{
					
					$sql = "INSERT INTO `products`(`title`,`category_id`, `description`, `weight`, `unit_price`, `quantity` , `image` , `color`, `size`) VALUES ('$title','$category','$description','$weight','$unit_price' , '$quantity','$target_file','$color','$size')";

					mysqli_query($conn,$sql);
				

					$_POST['title'] = "";
					$_POST['unit_price'] = "";
					$_POST['quantity'] = "";	
					$_POST['weight'] = "";	
					$_POST['description'] = "";	

					?>
						<p style="color:green;text-align:center;font-weight:bold">Product added successfully !</p>
					<?php
				}
			}
		}
		else{
			?>
				<p style="color:red;text-align:center">File is not an image.</p>
			<?php
			$uploadOk = 0;
		}
		






		
	}

?>




		<div class="registration">			
			<table>
				<tr>
					<td>
						<input id="title" type="text" name="title" placeholder="Title*" value="<?PHP if(isset($_POST['addProductBtn'])) echo htmlspecialchars($_POST['title']); ?>">
                        <input id="unit_price" type="text" name="unit_price" placeholder="Unit Price*" value="<?PHP if(isset($_POST['addProductBtn'])) echo htmlspecialchars($_POST['unit_price']); ?>">
					</td>
				</tr>
				<tr>
					<td>
                        <input id="quantity" type="text" name="quantity" placeholder="Quantity*" value="<?PHP if(isset($_POST['addProductBtn'])) echo htmlspecialchars($_POST['quantity']); ?>"> 
						<select name="color" id="color">
                            <option value="">Select Color</option>
                            <option value="green"> Green </option>
                            <option value="red"> Red</option>
                            <option value="blue"> Blue</option>
                            <option value="black"> Black</option>
                            <option value="white"> White</option>
                        </select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="image" style="float:left;margin-top:10px">Choose Picture*</label>
						<input id="image"  type="file" name="image" style="border:1px solid black;padding:5px;width:97%">
					</td>
				</tr>
				<tr>
					<td>
						<input id="weight"  type="text" name="weight" placeholder="Weight (g) (optional)" value="<?PHP if(isset($_POST['addProductBtn'])) echo htmlspecialchars($_POST['weight']); ?>">
						<select name="size" id="size">
                            <option value="">Select Size <sup>(optional)</sup></option>
                            <option value="sm"> S </option>
                            <option value="l"> L</option>
                            <option value="xl"> XL</option>
                            <option value="xxl"> XXL</option>
                        </select>
					</td>
				</tr>
				<tr>
					<td>
						<select name="category" id="category">
						<option value="">Select Category</option>
							<?php 
								$sql = "SELECT * FROM categories";
								$result = mysqli_query($conn,$sql);

								while ($row = mysqli_fetch_assoc($result)) {
									echo "<option value='$row[id]'>$row[name]</option>";
								}
							
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<textarea style="margin-top:10px;resize:none" name="description" id="description" cols="71" rows="10" placeholder="Description*"><?PHP if(isset($_POST['addProductBtn'])) echo htmlspecialchars($_POST['description']); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
					<button type="submit" name="addProductBtn" style="width:100%;padding:10px;cursor:pointer;margin-bottom:30px">Add Product</button>
					</td>
				</tr>
			</table>
		</div>
	 </form>



	 <script>


function validateProduct()
{
      let title = document.getElementById("title");
      let unit_price = document.getElementById("unit_price");
      let quantity = document.getElementById("quantity");
      let color = document.getElementById("color");
      let image = document.getElementById("image");
      let weight = document.getElementById("weight");
      let size = document.getElementById("size");
      let category = document.getElementById("category");
      let description = document.getElementById("description");
      let message = document.getElementById("message");


      if(title.value.trim() == "" || unit_price.value.trim() == "" || quantity.value.trim() == "" || color.value == "" || image.value == "" || category.value == "" || quantity.value.trim() == "" || description.value.trim() == "" )
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