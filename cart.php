<?php
include "connection.php";
session_start();
if (isset($_POST['rfc'])) {
	$product_id = $_POST['product_id'];
	$cart = mysqli_query($conn, "SELECT id FROM cart WHERE product_id = '$product_id'");
	$cart_result = mysqli_fetch_assoc($cart);
	$cart_id = $cart_result['id'];

	mysqli_query($conn, "DELETE FROM cart WHERE id = '$cart_id'");
	header("Location: cart.php");
}


if (isset($_SESSION['username'])) {
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cart</title>
		<link rel="stylesheet" type="text/css" href="css/admin.css">
		<!-- <link rel="stylesheet" type="text/css" href="css/signup.css"> -->
		<style>
			* {
				font-family: Montserrat;
			}

			.bodybtn {
				width: 30%;
				height: 230px;
				background-color: skyblue;
				margin: 20px;
				cursor: pointer;
				border: none;
				font-size: 25px;
			}

			.erorrMessage {
				color: red;
				text-align: center;
			}

			.successMessage {
				color: blue;
				text-align: center;
			}

			.registration {
				text-align: center;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			input {
				width: 250px;
				height: 30px;
				font-size: 15px;
			}

			.actions {
				padding: 10px;
				margin-left: 20px;
				cursor: pointer;
				border: none;
			}

			#update {
				background-color: blue;
				color: white;
			}

			#remove {
				background-color: red;
				color: white;
			}

			#rfc {
				cursor: pointer;
				background-color: #ffd369;
				border: none;
				margin-top: 20px
			}

			#rfc:hover {
				background-color: #d4a73b;
			}

			table {
				text-align: center;
				border-collapse: collapse;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			table td {
				padding: 15px;
				border: 1px solid black;
				width: 160px;
			}
		</style>

	<body>
		<div style="min-height:87vh">
			<?php
			include "header.php";
		

			$username = $_SESSION['username'];
			$user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
			$result = mysqli_fetch_assoc($user);
			$user_id = $result['id'];

			// $product = mysqli_query($conn,"SELECT product_id FROM cart WHERE id = '$user_id'");
			// $result1 = mysqli_fetch_assoc($product);
			// $product_id = $result1['product_id'];

			// $items = mysqli_query($conn,"SELECT no_of_items FROM cart WHERE id = '$user_id'");
			// $result2 = mysqli_fetch_assoc($items);
			// $no_of_items = $result2['no_of_items'];

			$cart = mysqli_query($conn, "SELECT * FROM cart ORDER BY product_id DESC");


			?>


			<div class="userCart">
				<h1 style="text-align:center">Cart</h1>
				<?php
				$total_payment = 0;

				while ($row = mysqli_fetch_assoc($cart)) {
					if ($row['user_id'] == $user_id) {
						$product_id = $row['product_id'];
						$result_product = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");


						while ($row_product = mysqli_fetch_assoc($result_product)) {

							$items = mysqli_query($conn, "SELECT no_of_items FROM cart WHERE product_id = '$product_id'");
							$result2 = mysqli_fetch_assoc($items);
							$no_of_items = $result2['no_of_items'];

							echo "<div style='width:100%;margin:30px;float:left;'>";

							$image = $row_product['image'];

							echo "
									<img src='$image' width='20%' height='200px' style='margin-right:30px;margin-top:15px;float:left'> <br>
									<b>$row_product[title]</b><br><br>";
							echo "<b>Description: </b>" . substr($row_product['description'], 0, 100) . "....<br><br>";
							echo "<b>Unit Price: </b>$row_product[unit_price]<br><br>";
							echo "<b>No of Items: </b>$no_of_items<br><br>
									<form action='' method='post'>
										<input name='product_id' type='hidden' value='$row_product[id]' >
										<input type='submit' name='rfc' id='rfc' value='Remove from Cart'>
									</form>";
							echo "</div>
							<hr width='80%' sytle=''>";

							$total_payment = $total_payment + ($row_product['unit_price'] * $no_of_items);
						}
					}
				}
				$items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
				$cart_items = mysqli_num_rows($items);

				echo "<div style='width:30%;float:right;margin:30px;'>";
				echo "<h3 style='text-align:center'>Cart Payment</h3>";
				echo "<table>
					<tr><td><b>No Of Items</b></td><td>$cart_items</td></tr>
					<tr><td><b>Total Price</b></td><td><b>Rs.</b> $total_payment</td></tr>
				</table>";
				echo "</div>";



				?>
			</div>
		</div>

		<?php

		include "footer.php";
		?>
	</body>

	</html>
<?php
} else {
	header("Location: login.php");
}
?>