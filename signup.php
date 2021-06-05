<?php

session_start();
include "connection.php";

if (isset($_SESSION['username'])) {

	$session_user = $_SESSION['username'];

	$user_query = "SELECT * FROM users WHERE username = '$session_user'";
	$user_result = mysqli_query($conn, $user_query);

	$user_data = mysqli_fetch_assoc($user_result);
	$db_type = $user_data['type'];

	if ($dp_type == 0) {
		header("Location: admin-dashboard.php");
	}
	if ($db_type == 1) {
		header("Location: index.php");
	}
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/signup.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<style>
		.erorrMessage {
			color: red;
			text-align: center;

		}

		.successMessage {
			color: green;
			text-align: center;
		}

		.heading {
			text-align: center;
			background-color: #ffd369;
			position: relative;
			padding: 10px;
			width: 190px;
			font-size: 10px;
		}

		.registration {
			margin-top: 70px;
			border-color: white;
			margin-left: 37%;
			margin-right: 37%;
			padding: 40px;
			height: 300px;
			padding-top: 60px;
			position: relative;
			background-color: white;
			box-shadow: 2px 2px 15px white;
		}
	</style>
</head>

<body>


	<?php include "header.php" ?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSignUp()">
		<div class="registration">
			<h1 class="heading" style="font-size: 24px;">REGISTRATION</h1>
			<p id="message" style="position: absolute;margin-left: 20%;"></p>

			<?php

			include "connection.php";

			if (isset($_POST['signup'])) {
				$username = mysqli_real_escape_string($conn, $_POST['username']);
				$email = mysqli_real_escape_string($conn, $_POST['email']);
				$password = mysqli_real_escape_string($conn, $_POST['password']);
				$type = 1;
				$status = "active";


				$profile_picture = "profiles/default.png";

				$sql = "SELECT * FROM users WHERE username = '$username'";
				$result = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($result);

				if ($count) {
			?> <br>
					<p class="erorrMessage" style="position: absolute;text-align: center;margin-left:10%;">username already exist!</p> <?php
																																	} else {
																																		$sql1 = "SELECT * FROM users WHERE email = '$email'";
																																		$result1 = mysqli_query($conn, $sql1);
																																		$count1 = mysqli_num_rows($result1);

																																		if ($count1) {
																																		?> <br>
						<p class="erorrMessage" style="position: absolute;text-align: center;margin-left:15%;">email already exist!</p> <?php
																																		} else {
																																			$sql = "INSERT INTO `users`(`profile_picture`,`username`, `email`, `password`, `type`, `status`) VALUES ('$profile_picture','$username','$email','$password','$type' , '$status')";

																																			if (mysqli_query($conn, $sql)) {
																																		?> <br>
							<p class="successMessage" style="position: absolute;margin-left: -10%;">You are registered successfully!</p> <?php
																																			}
																																			$_POST['username'] = "";
																																			$_POST['email'] = "";
																																			$_POST['password'] = "";
																																			$_POST['cpassword'] = "";
																																		}
																																	}
																																}

																																			?>

			<table style="margin-top: 30px;">
				<tr>
					<td>
						<input id="username" type="text" name="username" placeholder="Username" value="<?PHP if (isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="email" type="email" name="email" placeholder="Email" value="<?PHP if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="password" type="password" name="password" placeholder="Password" value="<?PHP if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="cpassword" type="password" name="cpassword" placeholder="Comfirm password" value="<?PHP if (isset($_POST['cpassword'])) echo htmlspecialchars($_POST['cpassword']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<button type="submit" name="signup">Sign Up</button>
					</td>
				</tr>
				<tr>
					<td style="padding-left: 10px;">
						<span>Have an account?</span><a href="login.php">Login</a>
					</td>
				</tr>
			</table>
		</div>
	</form>

	<!-- <script src="js/signup.js"></script> -->

	<script>
		function validateSignUp() {
			let username = document.getElementById("username");
			let email = document.getElementById("email");
			let password = document.getElementById("password");
			let cpassword = document.getElementById("cpassword");
			let message = document.getElementById("message");


			if (username.value == "" || email.value == "" || password.value.trim() == "" || cpassword.value.trim() == "") {
				message.innerText = "All fields required !";
				messageErorr(message);
				return false;
			} else {

				if (/\s/.test(username.value)) {
					message.innerText = "Invalid username !";
					messageErorr(message);
					return false;
				} else {
					if (/\s/.test(email.value)) {
						message.innerText = "Invalid email !";
						messageErorr(message);
						return false;
					} else {
						if (password.value != cpassword.value) {
							message.innerText = "Both passowrd are not same !";
							messageErorr(message);
							return false;
						} else {
							return true;
						}

					}
				}
			}

		}



		function messageErorr(message) {
			message.style.display = "block";
			message.style.color = "red";
			message.style.textAlign = "center";


		}



		function messageSuccess(message) {
			message.style.display = "block";
			message.style.color = "blue";
			message.style.textAlign = "center";
		}
	</script>

</body>

</html>