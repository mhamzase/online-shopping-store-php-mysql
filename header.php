<style>
	.dropbtn 
	{
		background-color: #ffd369;
		padding: 10px;
		font-size: 16px;
		border: none;
		width:160px;
		border-radius:5px;
	}

	.dropdown 
	{
		position: relative;
		display: inline-block;
		float:right;
		margin:20px;
	}

	.dropdown-content 
	{
		display: none;
		position: absolute;
		background-color: #f1f1f1;
		min-width: 160px;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		z-index: 1;
		border-radius:5px;
	}
	.dropdown-content button{
		width:160px;
		height:40px;
		background-color:#e33b24;
		border:none;
		color:white;
		font-size:16px;
		border-radius:5px;
		cursor:pointer;
	}
	#cart{
		background-color: #4ead67;
		padding: 10px;
		font-size: 16px;
		border: none;
		width:100px;
		border-radius:5px;
		float:right;
		margin:20px;
	}
	#cart:hover {background-color: #4ac76b;}

	.dropdown-content a:hover {background-color: #ddd;}

	.dropdown:hover .dropdown-content {display: block;}

	.dropdown:hover .dropbtn {background-color: #d4a73b;}

</style>

<?php 
	
	if(isset($_POST['logout']))
	{
		session_destroy();
		header("Location: login.php");
	}

	if(isset($_SESSION['username']))
	{
		include "connection.php";
		?>

	<div class="header">
		<?php 
			$username = $_SESSION['username'];
			$result = mysqli_query($conn, "SELECT id , type FROM users WHERE username = '$username'");
			$user = mysqli_fetch_assoc($result);
			$user_id = $user['id'];

			if($user['type'] == 0)
			{
				?>
					<div class="welcome">
     					<a href=""><img src="logo.png" alt="Logo is here" width="150px" style="cursor:pointer"></a>
     				</div>
				<?php
			}
			else
			{
				?>
					<div class="welcome">
     					<a href="index.php"><img src="logo.png" alt="Logo is here" width="150px" style="cursor:pointer"></a>
     				</div>
		 <?php
			}
		?>
		


		<div class="dropdown">
			<button class="dropbtn"><?php echo $_SESSION['username'] ?>&nbsp;&nbsp;<span style='font-weight:bold'>&darr;</span></button>
			<div class="dropdown-content">
					<?php 
					

					if($user['type'] == 1)
					{
					?>
							<a href="user-profile.php?id=<?php echo $user_id ; ?>">
								<button type="button" name="profileBtn" style="background-color:#3c6699">Profile</button>
							</a>
					<?php 
					}
					?>


				
				<a>
					<form action="" method="post" >
						<button name="logout" type="submit" id="logout">Logout</button>
					</form>
				</a>

			</div>
		</div>


		<?php 

				if(isset($_SESSION['username']))
				{
					$username = $_SESSION['username'];
					$result = mysqli_query($conn, "SELECT type FROM users WHERE username = '$username'");
					$user= mysqli_fetch_assoc($result);
					$user_type = $user['type'];

					if($user_type == 1)
					{
						?> <a href="cart.php"><button name="cart" type="button" id="cart" style="cursor:pointer">Cart</button></a> <?php
					}
				}

		?>
    </div>
		<?php
	}
	else
	{
		?>
			<div class="header">
     	<div class="welcome">
     		<a href="index.php"><img src="logo.png" alt="Logo is here" width="150px" style="cursor:pointer"></a>
     	</div>
     	<div class="button">
			<a href="login.php"><button name="logout" type="button" style="cursor:pointer;background-color:#4ead67">Login</button></a> <span style="color:white"> | </span>
			<a href="signup.php"><button name="logout" type="button" style="cursor:pointer">Register</button></a>
     	</div>
		</div>
		<?php
	}

?>