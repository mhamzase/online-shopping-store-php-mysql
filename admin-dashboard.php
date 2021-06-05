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
	<title>Admin dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<style>
		*{
			font-family: Montserrat;
		}
		.bodybtn{
			width:25%;
			height:200px;
			background-color:#2b2b2a;
			margin:20px;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;
			float: left;
			margin-top: 100px;

		}
	</style>
<body>

	<div style="min-height:87vh">
		<?php include "header.php" ?>


		<a href="manage-products.php">
		<button class="bodybtn" style="margin-left: -50px;">
		<b>Products</b>
		</button>
		</a>

		<a href="manage-categories.php">
		<button class="bodybtn">
		<b>Categories</b>
		</button>
		</a>

		<a href="manage-users.php">
		<button class="bodybtn">
		<b>Users</b>
		</button>
		</a>

	
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