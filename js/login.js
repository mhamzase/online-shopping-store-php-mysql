

function validateLogin()
{
      let username = document.getElementById("username");
      let password = document.getElementById("password");
      let message = document.getElementById("message");

      if(username.value == "" || password.value == "")
      {
            message.innerText = "All fields required !";
            message.style.display = "block";
            message.style.color = "red";
            message.style.textAlign = "center";

            return false;
      }

}
