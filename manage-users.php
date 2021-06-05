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
	<title>Manage Users</title>
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
	</style>
<body>
<?php include "header.php" ?>

	 <a href="admin-dashboard.php"><input type="button" value="Go to Dashboard"style="font-size:20px;cursor:pointer;margin-top:20px;float:left; width:19%;
			height:50px;
			background-color:#2b2b2a;
			margin-left:-9%;
			cursor:pointer;
			border:none;
			font-size:25px;
			color:white;"></a>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSignUp()" style="float:left;margin-left:100px">
	
	<p id="message" ></p>

	<?php

include "connection.php";

	if(isset($_POST['adduser']))
	{	
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$type = 1;
		$status = "active";

		
		$sql = "SELECT * FROM users WHERE username = '$username'";
      	$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);

		if($count)
		{
			?> <br><p class="erorrMessage">username already exist!</p> <?php
		}
		else{
			$sql1 = "SELECT * FROM users WHERE email = '$email'";
      		$result1 = mysqli_query($conn,$sql1);
			$count1 = mysqli_num_rows($result1);

			if($count1)
			{
				?> <br> <p class="erorrMessage">email already exist!</p> <?php
			}
			else{
				$sql = "INSERT INTO `users`(`username`, `email`, `password`, `type`, `status`) VALUES ('$username','$email','$password','$type' , '$status')";

				mysqli_query($conn,$sql);


				$_POST['username'] = "";
				$_POST['email'] = "";
				$_POST['password'] = "";	
				$_POST['cpassword'] = "";

				?>
					<p style="color:green">User added successfully !</p>
				<?php

				
			}
		}
	}

?>


		<div class="registration" style="border: 1px solid black; margin-left: 70px;float: left;">
				
			<table>
				<tr>
					<td>
						<input id="username" type="text" name="username" placeholder="Username" value="<?PHP if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="email"  type="email" name="email" placeholder="Email" value="<?PHP if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="password"  type="password" name="password" placeholder="Password" value="<?PHP if(isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="cpassword"  type="password" name="cpassword" placeholder="Comfirm password" value="<?PHP if(isset($_POST['cpassword'])) echo htmlspecialchars($_POST['cpassword']); ?>">
					</td>
				</tr>
				<tr>
					<td>
					<button type="submit" name="adduser" style="padding:10px;cursor:pointer;margin-bottom:30px">Add User</button>
					</td>
				</tr>
			</table>
		</div>
	 </form>

     

     </div>
     <br/><br/><br/><br/>
		<div style="text-align:center;margin:30px;float:right;margin-right:150px">
		

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateUsername()">
			<p style="font-size:30px;font-weight:bold; margin-right:40px">Search User</p>
				<input type="text" id="searchUser" name="searchUser" placeholder="Enter username"  value="<?PHP if(isset($_POST['searchBtn'])) echo htmlspecialchars($_POST['searchUser']); ?>"/>
				<button name="searchBtn" type="submit" style="padding:8px;cursor:pointer">Search User</button>
			</form>

			<p id="searchMessage" ></p>
			<div style="margin-top:20px">
		<table style="border:1px solid black;margin:auto;border-collapse:collapse">
		
		<?php 
			if(isset($_POST['searchBtn']))
			{
				$searchUsername = $_POST['searchUser'];
				$sql = "SELECT * FROM users WHERE LOWER(username) LIKE LOWER('%$searchUsername%')";
				$record = mysqli_query($conn,$sql);
				$isFound = mysqli_num_rows($record);

				if($isFound)
				{
					?>
						<tr style="background-color:lightgreen;color:black;">
							<td style='border:1px solid black;padding:15px'>SR #</td>
							<td style='border:1px solid black;padding:15px'>Username</td>
							<td style='border:1px solid black;padding:15px'>Email</td>
						</tr>

					<?php
					$count=0;
					while ($row = mysqli_fetch_assoc($record)) {
						$count++;
					echo "<tr style='border:1px solid black'>
					<td style='border:1px solid black;padding:15px'>$count</td>
					<td style='border:1px solid black;padding:15px'>$row[username]</td>
					<td style='border:1px solid black;padding:15px'>$row[email]</td>
					</tr>";
					}
				}
				else
				{
					?>
						<p style="color:red">User not found!</p>
					<?php
				}
			
			}
		?>
		</table>
	</div>

	</div>


	
	<hr width="90%">
	


     <br/><br/>
     <div class="allActiveUsers">
     <h1 style="text-align:center">All Active Users</h1>
	<table id="pendingTable" style="margin:30px;border:2px solid black;width:95%;font-size:20px;text-align:center;border-collapse:collapse">
			<tr style="background-color:lightgreen;color:black;">
				<th style="border:1px solid black;padding:15px">SR #</th>
				<th style="border:1px solid black">Username</th>
				<th style="border:1px solid black">Email</th>
                <th style="border:1px solid black">Actions</th>
			</tr>
	     <?php 
	
		     
		     $sql = "SELECT * FROM users WHERE status = 'active' and type = 1";
		     $result = mysqli_query($conn,$sql);
			$count=0;
		     while ($row = mysqli_fetch_assoc($result)) {
				$count++;
                echo "<tr style='border:1px solid black'>
                <td style='border:1px solid black;padding:15px'>$count</td>
                <td style='border:1px solid black'>$row[username]</td>
                <td style='border:1px solid black'>$row[email]</td>
                <td style='border:1px solid black'>

					<input name='user_id' type='hidden' value='$row[id]' />
					<a href='admin-view-user.php?id=$row[id]'> 
						<button  type='submit' name='view' id='view' class='actions' >View</button>
					</a>
					<a href='admin-update-user.php?id=$row[id]'> 
						<button  type='submit' name='edit' id='update' class='actions' >Update</button>
					</a>
					<a href='admin-remove-user.php?id=$row[id]'>
						<button  type='submit' name='remove' id='remove' class='actions' >Remove</button>
					</a>
					
				</td>

                </tr>";
		     }

	    ?>
	</table>
	</div>
	 <!-- <script src="js/signup.js"></script> -->

	 <script>

function temp(){
	alert("hello world");
}

function validateUsername()
{
	let searchUser = document.getElementById("searchUser");
	let searchMessage = document.getElementById("searchMessage");

	if(searchUser.value.trim() == "")
	{
		searchMessage.innerText = "username is required !";
        messageErorr(searchMessage);
        return false;
	}
	return true;
}

function validateSignUp()
{
      let username = document.getElementById("username");
      let email = document.getElementById("email");
      let password = document.getElementById("password");
      let cpassword = document.getElementById("cpassword");
      let message = document.getElementById("message");


      if(username.value == "" || email.value == "" || password.value.trim() == "" || cpassword.value.trim() == "")
      {
            message.innerText = "All fields required !";
            messageErorr(message);
            return false;
      }
      else
      {

            if(/\s/.test(username.value))
            {
                  message.innerText = "Invalid username !";
                  messageErorr(message);
                  return false;
            }
            else{
                  if(/\s/.test(email.value))
                  {
                        message.innerText = "Invalid email !";
                        messageErorr(message);
                        return false;
                  }
                  else{
                        if(password.value != cpassword.value)
                        {
                              message.innerText = "Both passowrd are not same !";
                              messageErorr(message);
                              return false;
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