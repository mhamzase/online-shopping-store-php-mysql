<?php
include "connection.php";

session_start();

if(isset($_SESSION['username']))
{
    $sql = mysqli_query($conn,"SELECT * FROM users WHERE username = '$_SESSION[username]'");
    $fetch_data = mysqli_fetch_assoc($sql);
    $user_type = $fetch_data['type'];
    if($user_type == 1)
    {
        ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin dashboard</title>
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
			color:green;
			text-align:center;
		}
        .profile, .changePassword{
            text-align:center;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        input{
            width:250px;
            height:30px;
            font-size:15px;
			margin:2px;
        }
        #user-profile
        {
            border:2px solid gray;
            padding:50px;
            border-radius:20px;
            width:60%;
        }
        #user-profile tr td{
            border:1px solid gray;
        }
        #udpateProfile{
            text-align:center;
            background-color:#4287f5;
            cursor:pointer;
            color:white;
            border:none;
            margin-top:40px;
        }
        #user-profile input{
            width:98%;
            border:none;
            outline:none;
        }
        .avatar {
            vertical-align: middle;
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        .custom-file-input {
            color: transparent;
            margin-left:40%;
            margin-bottom:30px;
        }
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }
        .custom-file-input::before {
            content: 'Update profile picture';
            color: black;
            display: inline-block;
            background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }
        .custom-file-input:hover::before {
            border-color: black;
        }
        .custom-file-input:active {
            outline: 0;
        }
        .custom-file-input:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
        }
        
	</style>
<body>
		<?php include "header.php" ?>

    <p style="font-size:30px;font-weight:bold;text-align:center;color:black">Profile</p>
	<p id="message" ></p>

	<?php

include "connection.php";

        if (isset($_GET['id'])) 
        {
            $id = $_GET['id'];
            $record = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
            $isRecord = mysqli_num_rows($record);

            if ($isRecord) {
                $data = mysqli_fetch_array($record);
                $old_username = $data['username'];
                $old_email = $data['email'];
                $old_status = $data['status'];
                $old_phone= $data['phone'];
                $old_city = $data['city'];
                $old_address = $data['address'];
                $old_profile_picture= $data['profile_picture'];
            }
        }

        if(isset($_POST['updateProfile']))
        {
        
            $id = $_POST['id'];
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);

            
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn,$sql);
            $count=false;
            
            while ($row =  mysqli_fetch_assoc($result)) {
                if($username == $row['username'])
                {
                    continue;
                }
                else
                {
                    $count = mysqli_num_rows($result);
                }	
            }

		

            if($count)
            {
                $_POST['username'] = $username;
                ?> <br><p class="erorrMessage">username already exist!</p> <?php
            }
            else
            {
                $sql1 = "SELECT * FROM users WHERE email = '$email'";
                $result1 = mysqli_query($conn,$sql1);
                $count1 = false;

                while ($row =  mysqli_fetch_assoc($result1)) 
                {
                    if($email == $row['email'])
                    {
                        continue;
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
                else
                {
                    $var1 = rand(111,999);  // generate random number in $var1 variable
                    $var2 = md5($var1);     // convert $var3 using md5 function and generate 32 characters hex number

                    $target_dir = "profiles/";
                    if($_FILES["profile_picture"]["name"] == "")
                    {
                        $target_file = $old_profile_picture;
                        if($target_file == "profiles/default.png")
                        {
                            goto updateProfile;
                        }

                    }
                    else
                    {
                        $target_file = $target_dir.$var2 .".". basename($_FILES["profile_picture"]["name"]);
                    }
                    
                    $uploadOk = 1;

                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    

                    
                    
                    // Check if image file is a actual image or fake image
                    if($_FILES["profile_picture"]["name"] == "")
                    {
                        $check = true;
                    }
                    else
                    {
                        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
                    }

                    if($check !== false)
                    {
                        
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
                        {
                            ?>
                            <p style="color:red;text-align:center">Sorry, only JPG, JPEG & PNG files are allowed.</p>
                            <?php
                            $uploadOk = 0;
                        }
                        else
                        {
                            
                            if(move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file))
                            {   
                                updateProfile:
                                $sql = "UPDATE users SET profile_picture = '$target_file', username = '$username' , email= '$email' , phone = '$phone' , city = '$city' , address = '$address' WHERE id=$id";

                                if(mysqli_query($conn,$sql))
                                {
                                    $_SESSION['username'] = $username;
                                    ?>
                                    <p style="color:green;text-align:center;font-weight:bold">Profile Updated successfully !</p>
                                    <?php
                                }
                                $record = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
                                $isRecord = mysqli_num_rows($record);

                                if ($isRecord) {
                                    $data = mysqli_fetch_array($record);
                                    $old_username = $data['username'];
                                    $old_email = $data['email'];
                                    $old_status = $data['status'];
                                    $old_phone= $data['phone'];
                                    $old_city = $data['city'];
                                    $old_address = $data['address'];
                                    $old_profile_picture= $data['profile_picture'];
                                }
                                
                            }
                        }
                    }
                    else{
                        ?>
                            <p style="color:red;text-align:center">File is not an image.</p>
                        <?php
                        $uploadOk = 0;
                    }
                        // header("Location: user-profile.php?id=$id");
			    }
		    }
        }

        ?>
        <form action="" method="post" onsubmit="return validateProfile()" enctype="multipart/form-data">
            <div class="profile">	 
                <table id="user-profile">
                    <tr>
                        <td style="border:none;" colspan="2" >
                            <?php 
                                if($old_profile_picture == null || $old_profile_picture== "")
                                {
                                    ?>
                                        <img src="profiles/default.png" alt="Avatar" class="avatar">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <img src="<?php echo $old_profile_picture;?>" alt="Avatar" class="avatar">
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;" colspan="2" >
                            <input type="file" name="profile_picture" id="profile_picture" class="custom-file-input">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="username"><b>Username</b></label>
                        </td>
                        <td>
                            <input id="username" type="text" name="username" placeholder="username*" value="<?PHP echo $old_username; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email"><b>Email</b></label>
                        </td>
                        <td>
                            <input id="email" type="email" name="email" placeholder="email*" value="<?PHP echo $old_email ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="status"><b>Status</b></label>
                        </td>
                        <td>
                            <input id="status" type="text" name="status"  value="<?PHP echo $old_status ?>" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="phone"><b>Phone</b></label>
                        </td>
                        <td>
                            <input id="phone" type="number" name="phone"  value="<?PHP echo $old_phone ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="city"><b>City</b></label>
                        </td>
                        <td>
                            <input id="city" type="text" name="city"  value="<?PHP echo $old_city?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="address"><b>Address</b></label>
                        </td>
                        <td>
                            <input id="address" type="text" name="address"  value="<?PHP echo $old_address ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input id="udpateProfile" type="submit" name="updateProfile" value="Update Profile"> 
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <p style="font-size:30px;font-weight:bold;text-align:center ">Change Password</p>
        <?php 
        

        
        if(isset($_POST['changePassword']))
        {
        
            $username = $_SESSION['username'];
            $currentPassword = mysqli_real_escape_string($conn, $_POST['currentPassword']);
            $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
            
            $sql = "SELECT password FROM users WHERE username = '$username'";
            $result = mysqli_query($conn,$sql);
            $user_db_password = mysqli_fetch_assoc($result);

		

            if($currentPassword == $newPassword)
            {
                ?> <br><p class="erorrMessage">Your new password is already in use!</p> <?php
            }
            elseif($currentPassword == $user_db_password['password']){
                $result2 = mysqli_query($conn,"UPDATE users SET password = '$newPassword' WHERE username = '$username'");
                ?> <br><p class="successMessage">Password Changed Successfully!</p> <?php
            }
            else
            {
                ?> <br><p class="erorrMessage">Current password is wrong!</p> <?php

                // header("Location: user-profile.php?id=$id");
			}
        }
        
        ?>
       <p style="font-size:30px;font-weight:bold;text-align:center;color:black">Change Password</p>
        <p id="passwordMessage" ></p>
        <form action="" method="post" onsubmit=" return validateChangePassword()">
            <div class="changePassword">
            <table id="user-profile">
                    <tr>
                        <td>
                            <label for="currentPassword"><b>Current Passoword</b></label>
                        </td>
                        <td>
                            <input id="currentPassword" type="password" name="currentPassword" placeholder="Current password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="newPassword"><b>New password</b></label>
                        </td>
                        <td>
                            <input id="newPassword" type="password" name="newPassword" placeholder="New password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="confirmPassword"><b>Confirm Password</b></label>
                        </td>
                        <td>
                            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm password" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none">
                            <!-- <input type="hidden" name="id" value="<?php echo $id; ?>"> -->
                            <!-- <input id="udpateProfile" type="submit" name="updateProfile" value="Update Profile"> -->
                            <input id="udpateProfile" type="submit" name="changePassword" value="Change Password" style="background-color:#4287f5;cursor:pointer;color:white;border:none">  
                        </td>
                    </tr>
                </table>			
            </div>
        </form>
	 <script>


function validateProfile()
{
      var username = document.getElementById("username");
      var email = document.getElementById("email");
      var message = document.getElementById("message");


      if(username.value.trim() == "" || email.value.trim() == "" )
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
					return true;
				} 
            }
      }

}


function validateChangePassword()
{
      var newPassword = document.getElementById("newPassword");
      var confirmPassword = document.getElementById("confirmPassword");
      var passwordMessage = document.getElementById("passwordMessage");


      if(newPassword.value != confirmPassword.value)
      {
        passwordMessage.innerText = "new password & confirm password don't matching... !";
        messageErorr(passwordMessage);
        return false;
      }
      else
      {
          return true;
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
        header("Location: admin-dashboard.php");
    }
}
else{
	header("Location: login.php");
}
?>