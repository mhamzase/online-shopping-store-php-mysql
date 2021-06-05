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
</head>
<body>

	
<?php include "header.php";
include "connection.php"; ?>

	<div style="min-height:59vh">
	 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateEmail()">
		<div class="login">
			<h2 class="heading">Forgot Password</h2>
            <p id="message"></p>

            <?php
                


                if(isset($_POST['sendEmail']))
                {
                    $email = mysqli_real_escape_string($conn, $_POST['email']);

                    $sql = "SELECT * FROM users WHERE email = '$email'";

                    $result = mysqli_query($conn,$sql);
                    $isEmail = mysqli_num_rows($result);

                    if($isEmail)
                    {
                        $to_email = "mhamzasulehri143@gmail.com";
                        $subject = "Simple Email Test via PHP";
                        $body = "Hi, This is test email send by PHP Script";
                        $headers = "From: mhamzasulehri143@gmail.com";

                        if (mail($to_email, $subject, $body, $headers)) {
                            echo "Email successfully sent to $to_email...";
                        } else {
                            echo "Email sending failed...";
                        }
                            ?>
                                <p style="color:green;text-align:center">Please check your email to reset password!</p>
                            <?php
                            $_POST['email'] = "";
                    }
                    else{
                         ?>
                            <p style="color:red;text-align:center">Email doesn't exist in our database!</p>
                         <?php
                    
                    }
                }




                mysqli_close($conn);
                ?>



			<table>
				<tr>
					<td>
						<input id="email" type="email" name="email" placeholder="Email" value="<?PHP if(isset($_POST['sendEmail'])) echo htmlspecialchars($_POST['email']); ?>">
					</td>
				</tr>
				<tr>
					<td>
					<button type="submit" name="sendEmail" >Send Email</button>		
					</td>
				</tr>
			</table>
		</div>
	 </form>







	 <script src="js/login.js"></script>
     <script>
        function validateEmail(){
            var email = document.getElementById("email");
            var message = document.getElementById("message");

            if(email.value.trim() == '')
            {
                message.innerText = "Email is required!";
                messageError(message);
                return false;
            }
            else
            {
                return true;
            }
        }


        function messageError(message)
        {
            message.style.color = "red";
            message.style.textAlign = "center";
        }
     </script>
     </div>
      <?php 
	 
	 include "footer.php";
 ?>
 
</body>
</html>