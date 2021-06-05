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
	<title>Manage Categories</title>
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
            float:right;
            display:flex;
           
            align-items:center;
           
        }
        input{
            width:250px;
            height:30px;
            font-size:15px;
        }
		.actions{
			padding:10px;
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
	</style>
<body>
<?php include "header.php" ?>

	 <a href="admin-dashboard.php"><input type="button" value="Go to Dashboard"style=" font-size:20px;cursor:pointer;margin-top:20px;float:left;
			width:17%;
			height:50px;
			margin-left: -100px;
			background-color:#2b2b2a;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;"></a>
		<br><br><br>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateCategory()">
   

	<?php

include "connection.php";

	if(isset($_POST['add']))
	{	
		$category = mysqli_real_escape_string($conn, $_POST['category']);

        $sql = "INSERT INTO `categories`(`name`) VALUES ('$category')";
        mysqli_query($conn,$sql);
        $_POST['category'] = "";
		?>
			<p style="color:green;">Category added successfully !</p>
		<?php

	}

?>
	

<br><br>
		<div class="registration" style="float: left;margin-left:200px;margin-top: 12px;">
         <p id="message"  ></p>
				
			<table>
				<tr>
					<td>
						<input id="category" type="text" name="category" placeholder="Category Name" value="<?PHP if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>">
					</td>
					<td>
					<button type="submit" name="add" style="padding:8px;cursor:pointer">Add Category</button>
					</td>
				</tr>
			</table>
		</div>
	 </form>



	 <div style="text-align:center;margin:30px;float:right;margin-right:200px; margin-top: x;">
		

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSearchCategory()">
				<input type="text" id="searchCategory" name="searchCategory" placeholder="Enter category name"  value="<?PHP if(isset($_POST['searchBtn'])) echo htmlspecialchars($_POST['searchCategory']); ?>"/>
				<button name="searchBtn" type="submit" style="padding:8px;cursor:pointer">Search Category</button>
			</form>
			
			<p id="searchMessage" ></p>
			
			<div style="margin-top:20px">
		<table style="border:1px solid black;margin:auto;border-collapse:collapse">
		
		<?php 
			if(isset($_POST['searchBtn']))
			{
				$searchCategory = $_POST['searchCategory'];
				$sql = "SELECT * FROM categories WHERE LOWER(name) LIKE LOWER('%$searchCategory%')";
				$record = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($record);


				if($isFound)
				{
					?>
						<tr style="background-color:lightgreen;color:black;">
							<td style='border:1px solid black;padding:15px'>SR #</td>
							<td style='border:1px solid black;padding:15px'>Name</td>
						</tr>

					<?php

					$count=0;
					while ($row = mysqli_fetch_assoc($record)) {
						$count++;
					echo "<tr style='border:1px solid black'>
					<td style='border:1px solid black;padding:15px'>$count</td>
					<td style='border:1px solid black;padding:15px'>$row[name]</td>
					</tr>";
					}
				}
				else
				{
					?>
						<p style="color:red">Category not found!</p>
					<?php
				}
			
			}
		?>
		</table>
	</div>

	</div>

     

     </div>
     <br/><br/><br/><br/>
     <hr width="90%">
     <br/><br/>
     <div class="accepted" style="width:100%">
     <h1 style="text-align:center">All Categories</h1>
	     <table id="pendingTable" style="margin:30px;border:2px solid black;width:95%;font-size:20px;text-align:center;border-collapse:collapse">
			<tr style="background-color:lightgreen;color:black;">
				<th style="border:1px solid black;padding:15px">SR #</th>
				<th style="border:1px solid black">Category Name</th>
				<th style="border:1px solid black">Actions</th>
			</tr>
	     <?php 
	
		     
		     $sql = "SELECT * FROM categories ";
		     $result = mysqli_query($conn,$sql);
			$count =0;

		     while ($row = mysqli_fetch_assoc($result)) {
				$count++;
                echo "<tr style='border:1px solid black'>
                <td style='border:1px solid black;padding:15px'>$count</td>
                <td style='border:1px solid black'>$row[name]</td>
                <td style='border:1px solid black'>

					<input name='category_id' type='hidden' value='$row[id]' />
					<a href='update-category.php?id=$row[id]'> 
						<button  type='submit' name='edit' id='update' class='actions' >Update</button>
					</a>
					<a href='remove-category.php?id=$row[id]'>
						<button  type='submit' name='remove' id='remove' class='actions' >Remove</button>
					</a>
					
				</td>

                </tr>";
		     }

	    ?>
	</table>

	 <!-- <script src="js/signup.js"></script> -->

	 <script>

function validateSearchCategory(){

	let searchCategory = document.getElementById("searchCategory");
	let searchMessage = document.getElementById("searchMessage");

	if(searchCategory.value.trim() == "")
	{
		searchMessage.innerText = "category is required !";
        messageErorr(searchMessage);
        return false;
	}
	return true;

}

function validateCategory()
{
      let category = document.getElementById("category");
      if(category.value.trim() == "")
      {
            message.innerText = "field is required !";
            messageErorr(message);
            return false;
      }
      return true;            
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