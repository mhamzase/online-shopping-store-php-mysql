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
	<title>Update User</title>
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
	</style>
<body>
	<div style="min-height:86vh">
<?php include "header.php" ?>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateSignUp()">
        <h1 style="text-align:center">Update User</h1>
        
    <p id="message" ></p>
    <a href="manage-users.php"><input type="button" value="Go Back"style="margin-left:20px; font-size:20px;cursor:pointer"></a>
		

				
<?php

include "connection.php";


if (isset($_GET['id'])) 
{
    $id = $_GET['id'];
    $record = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $isRecord = mysqli_num_rows($record);

    if ($isRecord) {
        $data = mysqli_fetch_array($record);
        $old_username = $data['username'];
        $old_email = $data['email'];
        $old_password = $data['password'];
    }
}



	if(isset($_POST['update']))
	{	
        $id = $_POST['id'];
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

		
		$sql = "SELECT * FROM users WHERE username = '$username'";
      	$result = mysqli_query($conn,$sql);
		$count=false;
		
		while ($row =  mysqli_fetch_assoc($result)) {
			if($row['username'] == $username)
			{
				continue;
				return false;
			}
			else
			{
				$count = mysqli_num_rows($result);
			}	
		}

		

		if($count)
		{
			?> <br><p class="erorrMessage">username already exist!</p> <?php
		}
		else{
			$sql1 = "SELECT * FROM users WHERE email = '$email'";
      		$result1 = mysqli_query($conn,$sql1);
			$count1 = false;

			while ($row =  mysqli_fetch_assoc($result1)) {
				if($row['email'] == $email)
				{
					continue;
					return false;
				}
				else
				{
					$count1 = mysqli_num_rows($result1);
				}	
			}

			if($count1)
			{
				?> <br> <p class="erorrMessage">email already exist!</p> <?php
			}
			else{
                
				$sql = "UPDATE users SET username = '$username' , email= '$email' , password = '$password' WHERE id=$id";

				mysqli_query($conn,$sql);

                ?>
                        <p style="color:green;text-align:center;font-weight:bold">User updated successfully ! Redirecting...</p>
                    <?php

                    header("Refresh:2 ; url=manage-users.php" );
				
			}
		}
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
						<input id="username" type="text" name="username" placeholder="Username" value="<?PHP echo $old_username ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="email"  type="email" name="email" placeholder="Email" value="<?PHP echo $old_email ?>">
					</td>
				</tr>
				<tr>
					<td>
						<input id="password"  type="password" name="password" placeholder="Password" value="<?PHP echo $old_password ?>">
					</td>
				</tr>
				<tr>
					<td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
					    <button type="submit" name="update" style="padding:10px;cursor:pointer">Update User</button>
					</td>
				</tr>
			</table>
		</div>

		<?php
        }
    ?>

	 </form>

     

     </div>
	</table>

	 <!-- <script src="js/signup.js"></script> -->

	 <script>

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
	 </div>
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