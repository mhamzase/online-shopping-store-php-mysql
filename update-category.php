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
	<title>Update Category</title>
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
	</style>
<body>
	<div style="min-height:87vh">
	<?php include "header.php" ?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateCategory()">
<a href="admin-dashboard.php"><input type="button" value="Go to Dashboard"style="margin-left:20px; font-size:20px;cursor:pointer;margin-top:20px;width:19%;
			height:50px;
			background-color:#2b2b2a;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;"></a>
<p id="message" ></p>

			
<?php

include "connection.php";



if (isset($_GET['id'])) 
{
$id = $_GET['id'];
$record = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
$isRecord = mysqli_num_rows($record);

if ($isRecord) {
	$data = mysqli_fetch_array($record);
	$old_category = $data['name'];
}
}



if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$category = mysqli_real_escape_string($conn, $_POST['category']);

	$sql = "UPDATE categories SET name = '$category'  WHERE id=$id";
	mysqli_query($conn,$sql);
	
	?>
	<p style="color:green;text-align:center;font-weight:bold">Category updated successfully ! Redirecting...</p>
<?php

header("Refresh:2 ; url=manage-categories.php" );

}

?>

<?php 

	if(isset($_GET['id']))
	{
			?>
	<div class="registration">
			
		<table>
			<tr>
				<td>
					<input id="category" type="text" name="category" placeholder="Category Name" value="<?PHP echo $old_category?>">
				</td>
			</tr>
			<tr>
				<td>
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<button type="submit" name="update" style="padding:10px;cursor:pointer">Update Category</button>
				</td>
			</tr>
		</table>
	</div>

	<?php
	}
?>

 </form>


 <script>

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