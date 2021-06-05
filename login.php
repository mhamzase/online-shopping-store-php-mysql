<?php 

session_start();
include "connection.php";

if(isset($_SESSION['username']))
{

	$session_user = $_SESSION['username'];

	$user_query = "SELECT * FROM users WHERE username = '$session_user'";
	$user_result = mysqli_query($conn,$user_query);

	$user_data = mysqli_fetch_assoc($user_result);
	$db_type = $user_data['type'];
	
		if($dp_type == 0)
		{
			header("Location: admin-dashboard.php");
		}
		if($db_type == 1){
			header("Location: index.php");
		}
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<style>
		.heading{
	text-align: center;
	background-color:#ffd369;
	position: relative;
	padding: 10px; 
	margin-bottom:-50px;
	margin-top: -32%;
	width: 170px;
	margin-left: 40PX;


}
	</style>
</head>
<body >

	<div style="min-height:90vh">
<?php include "header.php" ?>

	
	 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateLogin()">
		<div class="login">
			<h1 class="heading">LOGIN</h1>
			<?php

				if(isset($_GET['msg']))
				{
					?> <p style="color:red"><?php echo $_GET['msg']?></p> <?php
				}

			?>
			<table style="margin-top: 10px;">
				<p id="message" style="display:none"></p>
				<tr>
					<td>
						<input id="username" type="text" name="username" placeholder="Username" value="<?PHP if(isset($_POST['loginBtn'])) echo htmlspecialchars($_POST['username']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="password" type="password" name="password" placeholder="Password" value="<?PHP if(isset($_POST['loginBtn'])) echo htmlspecialchars($_POST['password']); ?>">
					</td>
				</tr>
				
				<tr>
					<td>
					<span>Don't have an account?</span><a href="signup.php">Sign Up</a>
					</td>
				</tr>
			</table>
		</div>
	 </form>




	 <?php
include "connection.php";


if(isset($_POST['loginBtn']))
{
      $username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

      $sql = "SELECT * FROM users WHERE username = '$username'";

      $result = mysqli_query($conn,$sql);
      $isUser = mysqli_num_rows($result);

      if($isUser)
      {
            $user_data = mysqli_fetch_assoc($result);
            
            $db_password = $user_data['password'];
            if($password === $db_password)
            {
                  
                  $type = $user_data['type'];
                  if($type == 0)
                  {
                        $_SESSION['username'] = $username;
                        header("Location: admin-dashboard.php");
                  }
                  else{
                        $status = $user_data['status'];
                        if($status == 'active')
                        {
                              $_SESSION['username'] = $username;
                              header("Location:index.php");
                        }
                        elseif($status == 'pending'){
                              header("Location:login.php?msg=Your request is still pending");
                        }
                        else{
                              header("Location:login.php?msg=Your request is rejected by Admin !");
                        }
                  }
            }
            else{
                  header("Location:login.php?msg= username or password incorrect !");
                  return;
            }
            
      }
      else{
            header("Location:login.php?msg= username or password incorrect !");
            return;
      }
}




mysqli_close($conn);
?>


	 <script src="js/login.js"></script>

</div>

	
</body>
</html>