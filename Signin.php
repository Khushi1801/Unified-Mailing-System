<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="./Signin/Signin.css">
    <link rel="icon" type="image/x-icon" href="./Images/logo.png">
</head>
<body>
    
    <!-- Signin division  -->
    <div class="Signin">

        <div class="Input_division">
            
            <!-- Website logo and name div  -->

            <div class="Website_logo_title_div">
                
                <!-- Website logo div -->
                <div class="Website_logo_div">
                    <img src="./Images/logo.png" alt="image" class="Website_logo">
                </div>

                <!-- Website name div  -->
                <div class="Website_title">
                    Signin
                </div>
            
            </div>


            <!-- Input field div  -->

            <form action="./Signin/signin_data.php" method="POST">

            <div class="Input_option_division">
                 
                <!-- Email input  -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control Input_option" placeholder="Emailaddress"
                    aria-label="Username" aria-describedby="basic-addon1" name="emailaddress">
                </div>
                 
                <!-- Password input  -->
                <div class="input-group mb-3">
                    <input type="password" class="form-control Input_option" placeholder="Password" 
                    aria-label="Username" aria-describedby="basic-addon1" id="showpassword" name="password">
                    
                </div>
                
                <!-- Checkpassword checkbox div  -->
                <div class="input-group-text Check_password_div">
                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" onclick="myFunction()">
                    <span class="Check_password_text">Show Password</span>
                </div>
                
                <!-- Signup button  -->
                <button class="Submit_button" name="signin">Signin</button>

                </form>    

                <!-- Login and forget password option div  -->
                <div class="Login_forget_password">
                     
                    <!-- Login option  -->
                    <a href="signup.php" style="text-decoration:none;"><div class="Login">
                        Create account ?
                    </div></a>
                    
                    <!-- Forget password option  -->
                    <a href="forgot_password.php" style="text-decoration:none;"><div class="forget_password">
                        Forget Password?
                    </div></a>
                
                </div>
                
            </div>

        </div>
        
    </div>

    <script>
            
            function myFunction() {
            
            var x = document.getElementById("showpassword");
           
            if (x.type === "password") {
                    x.type = "text";
            } else {
                    x.type = "password";            
            }
    
            }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>