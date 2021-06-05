

function validateSignUp()
{
      // let username = document.getElementById("username");
      // let email = document.getElementById("email");
      // let password = document.getElementById("password");
      // let cpassword = document.getElementById("cpassword");
      // let message = document.getElementById("message");

      return false;
      // if(username.value == "" || email.value == "" || password.value.trim() == "" || cpassword.value.trim() == "")
      // {
      //       message.innerText = "All fields required !";
      //       messageErorr(message);
      //       return false;
      // }
      // else
      // {
      //       if(true)
      //       {
      //             message.innerText = "Invalid username !";
      //             messageErorr(message);
      //             return false;
      //       }
      //       else{
      //             if(email.value.trim() == "")
      //             {
      //                   message.innerText = "Invalid email !";
      //                   messageErorr(message);
      //                   return false;
      //             }
      //             else{
      //                   if(password.value != cpassword.value)
      //                   {
      //                         message.innerText = "Both passowrd are not same !";
      //                         messageErorr(message);
      //                         return false;
      //                   }
      //                   else{
      //                         return true;
      //                   }
                       
      //             }
      //       }
      // }

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