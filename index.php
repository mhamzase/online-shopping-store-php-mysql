<?php 
session_start(); 
include "connection.php";


if(isset($_SESSION['username']))
{
    $sql = mysqli_query($conn,"SELECT * FROM users WHERE username = '$_SESSION[username]'");
    $fetch_data = mysqli_fetch_assoc($sql);
    $user_type = $fetch_data['type'];
    if($user_type == 0)
    {
		header("Location: admin-dashboard.php");
	}
	else
	{
		?>
			<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="css/index.css">
	<style>
		#searchProduct{
			height:36px;
			width:250px;	
		}
		#searchMessage{
			color:red;
		}
	</style>
<body>

<?php 
	include "connection.php";
	include "header.php" ;
?>

<div>
		<img src="cover.jpg" alt="Banner is here" width="100%" style="text-align:center;margin-top:-5px"><br>
		<h1 style="text-align:center">Featured Products</h1>
		<hr width="80%" />

		<div style="display:block;">
			<div class="filterDiv" >
				<form action="" method="post">
					<select name="category" id="category" required>
						<option value="">Select Category</option>
						<?php 
							$sql = "SELECT * FROM categories";
							$result = mysqli_query($conn,$sql);

							while ($row = mysqli_fetch_assoc($result)) {
								echo "<option value='$row[id]'";
								echo (isset($_POST['filterCategory']) && $_POST['category'] == $row['id']) ? 'selected' : '';
								echo ">$row[name]</option>";
							}

						?>
					</select>
					<button type="submit" name="filterCategory" class="filterBtn">Filter</button>
				</form>
			</div>

			<div class="searchProduct" style="width:40%;" >
			<small id="searchMessage"></small>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSearchProduct()">
					<input type="text" name="searchProduct" id="searchProduct" value=" <?PHP if(isset($_POST['searchBtn'])) echo htmlspecialchars($_POST['searchProduct']);?>">
					<button type="submit" name="searchBtn" class="searchBtn">Search</button>
				</form>
				
			</div>
		</div>
				
		<div style="display:block;">
		<?php 	     
			if(isset($_POST['searchBtn']))
			{
				$searchProduct = $_POST['searchProduct'];
				$sql = "SELECT * FROM products WHERE LOWER(title) LIKE LOWER('%$searchProduct%')";
				$result = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($result);

				if($isFound)
				{
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
						
						<input name='product_id' type='hidden' value='$row[id]' />
						<a href='user-view-product.php?id=$row[id]'> 
							<button  type='submit' name='view' id='view' class='actions' >View</button>
						</a>";
	
	
						$image = $row['image'];
						echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
						<b>$row[title]</b><br>";
						echo substr($row['description'],0,40);
						echo "...<br>
						</div>";
					}
				}
				else
				{
					echo "<h1 style='text-align:center;margin:200px;color:'>Nothing Found!</h1>";
				}
			}
			elseif(isset($_POST['filterCategory']))
			{
				$category = $_POST['category'];

				$sql = "SELECT * FROM products WHERE category_id = '$category'";
				$result = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($result);


				if ($isFound) {
					while ($row = mysqli_fetch_assoc($result)) {
					echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
					
					<input name='product_id' type='hidden' value='$row[id]' />
					<a href='user-view-product.php?id=$row[id]'> 
						<button  type='submit' name='view' id='view' class='actions' >View</button>
					</a>";


					$image = $row['image'];
					echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
					<b>$row[title]</b><br>";
					echo substr($row['description'],0,40);
					echo "...<br>
					</div>";
				}
				}
				else
				{
					echo "<h1 style='text-align:center;margin:200px;color:'>Nothing Found!</h1>";
				}
			}
			else
			{
				$sql = "SELECT * FROM products ORDER BY id DESC";
				$result = mysqli_query($conn,$sql);

				while ($row = mysqli_fetch_assoc($result)) {
					echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
					
					<input name='product_id' type='hidden' value='$row[id]' />
					<a href='user-view-product.php?id=$row[id]'> 
						<button  type='submit' name='view' id='view' class='actions' >View</button>
					</a>";


					$image = $row['image'];
					echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
					<b>$row[title]</b><br>";
					echo substr($row['description'],0,40);
					echo "...<br>
					</div>";
				}
			}
		     
	    ?>
		</div>
		<hr width="80%" />
</div>

<script>
function validateSearchProduct()
{
	let searchProduct = document.getElementById("searchProduct");
	let searchMessage = document.getElementById("searchMessage");

	if(searchProduct.value.trim() == "")
	{
		searchMessage.innerText = "field is required !";
        return false;
	}
	return true;
}
</script>
<?php 
	 
	 include "footer.php";
 ?>
</body>
</html>
		<?php
	}

}
else
{
	?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="css/index.css">
	<style>
		#searchProduct{
			height:36px;
			width:250px;	
		}
		#searchMessage{
			color:red;
		}
	</style>
<body>

<?php 
	include "connection.php";
	include "header.php" ;
?>

<div>
		<img src="cover.jpg" alt="Banner is here" width="100%" style="text-align:center;margin-top:-5px"><br>
		<h1 style="text-align:center">Featured Products</h1>
		<hr width="80%" />

		<div style="display:block;">
			<div class="filterDiv" >
				<form action="" method="post">
					<select name="category" id="category" required>
						<option value="">Select Category</option>
						<?php 
							$sql = "SELECT * FROM categories";
							$result = mysqli_query($conn,$sql);

							while ($row = mysqli_fetch_assoc($result)) {
								echo "<option value='$row[id]'";
								echo (isset($_POST['filterCategory']) && $_POST['category'] == $row['id']) ? 'selected' : '';
								echo ">$row[name]</option>";
							}

						?>
					</select>
					<button type="submit" name="filterCategory" class="filterBtn">Filter</button>
				</form>
			</div>

			<div class="searchProduct" style="width:40%;" >
			<small id="searchMessage"></small>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSearchProduct()">
					<input type="text" name="searchProduct" id="searchProduct" value="<?PHP if(isset($_POST['searchBtn'])) echo htmlspecialchars($_POST['searchProduct']);?>">
					<button type="submit" name="searchBtn" class="searchBtn">Search</button>
				</form>
				
			</div>
		</div>
				
		<div style="display:block;">
		<?php 	     
			if(isset($_POST['searchBtn']))
			{
				$searchProduct = $_POST['searchProduct'];
				$sql = "SELECT * FROM products WHERE LOWER(title) LIKE LOWER('%$searchProduct%')";
				$result = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($result);
				
				if($isFound >= 1)
				{
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
						
						<input name='product_id' type='hidden' value='$row[id]' />
						<a href='user-view-product.php?id=$row[id]'> 
							<button  type='submit' name='view' id='view' class='actions' >View</button>
						</a>";
	
	
						$image = $row['image'];
						echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
						<b>$row[title]</b><br>";
						echo substr($row['description'],0,40);
						echo "...<br>
						</div>";
					}
				}
				else
				{
					echo "<h1 style='text-align:center;margin:200px;color:'>Nothing Found!</h1>";
				}
			}
			elseif(isset($_POST['filterCategory']))
			{
				$category = $_POST['category'];

				$sql = "SELECT * FROM products WHERE category_id = '$category'";
				$result = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($result);


				if ($isFound) {
					while ($row = mysqli_fetch_assoc($result)) {
					echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
					
					<input name='product_id' type='hidden' value='$row[id]' />
					<a href='user-view-product.php?id=$row[id]'> 
						<button  type='submit' name='view' id='view' class='actions' >View</button>
					</a>";


					$image = $row['image'];
					echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
					<b>$row[title]</b><br>";
					echo substr($row['description'],0,40);
					echo "...<br>
					</div>";
				}
				}
				else
				{
					echo "<h1 style='text-align:center;margin:200px;color:'>Nothing Found!</h1>";
				}
			}
			else
			{
				$sql = "SELECT * FROM products ORDER BY id DESC";
				$result = mysqli_query($conn,$sql);

				while ($row = mysqli_fetch_assoc($result)) {
					echo "<div style='width:19%;border:1px solid lightgray;padding:10px;margin:20px;float:left'>
					
					<input name='product_id' type='hidden' value='$row[id]' />
					<a href='user-view-product.php?id=$row[id]'> 
						<button  type='submit' name='view' id='view' class='actions' >View</button>
					</a>";


					$image = $row['image'];
					echo "<img src='$image' width='250px' height='200px' style='margin-top:15px'><br><br><br>
					<b>$row[title]</b><br>";
					echo substr($row['description'],0,40);
					echo "...<br>
					</div>";
				}
			}
		     
	    ?>
		</div>
		<hr width="80%" />
</div>

<script>
function validateSearchProduct()
{
	let searchProduct = document.getElementById("searchProduct");
	let searchMessage = document.getElementById("searchMessage");

	if(searchProduct.value.trim() == "")
	{
		searchMessage.innerText = "field is required !";
        return false;
	}
	return true;
}
</script>
<?php 
	 
	 include "footer.php";
 ?>
</body>
</html>
	<?php
}
?>

