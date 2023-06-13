<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./Images/logo.png">
    <link rel="stylesheet" href="./Signup/Signup.css">
</head>
<body>

    <div class="Signup" >

        <div class="Input_division">
            
            <!-- Website logo and name div  -->

            <div class="Website_logo_title_div">
                
                <!-- Website logo div -->
                <div class="Website_logo_div">
                    <img src="./Images/logo.png" alt="" class="Website_logo">
                </div>

                <!-- Website name div  -->
                <div class="Website_title">
                    Signup
                </div>
            
            </div>


            <form action="./Signup/signup_data.php" method="POST">

                    <!-- Input field div  -->

                    <div class="Input_option_division">
                        
                        <!-- Username input  -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control Input_option" placeholder="Username" 
                            aria-label="Username" aria-describedby="basic-addon1" name="username" required>
                        </div>
                        
                        <!-- Emailaddress input  -->
                        <div class="input-group mb-3">
                            <input type="email" class="form-control Input_option" placeholder="Emailaddress" 
                            aria-label="Username" aria-describedby="basic-addon1" name="emailaddress" required>
                        </div>

                        <!-- mobile input  -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control Input_option" placeholder="Mobile No" 
                            aria-label="Username" aria-describedby="basic-addon1" name="mobile" maxlength="10" size="10" required>
                        </div>
                         
                        <!-- Password input  -->
                        <div class="input-group mb-3">
                            <input type="password" class="form-control Input_option" placeholder="Password" 
                            aria-label="Username" aria-describedby="basic-addon1" name="password" id="showpassword" required>
                        </div>

                        <!-- Re-enter password input  -->
                        <div class="input-group mb-3">
                            <input type="password" class="form-control Input_option" placeholder="Re-Enter Password" 
                            aria-label="Username" aria-describedby="basic-addon1" name="cpassword"  id="showpassword1" required>
                        </div>
                       
                        <!-- Checkpassword checkbox div  -->
                        <div class="input-group-text Check_password_div">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" onclick="myFunction()">
                            <span class="Check_password_text">Show Password</span>
                        </div>
                       
                        <!-- Signup button  -->
                        <button class="Submit_button" name="signup">Signup</button>
                    
                    </div>

                </form>

                <!-- Login and forget password option div  -->
                <div class="Login_forget_password">
                     
                    <!-- Login option  -->
                    <a href="signin.php" style="text-decoration: none;"><div class="Login">
                        Already have an account?
                    </div></a>

                </div>
                
            </div>


        </div>
        
    </div>
    
    <script>
            
            function myFunction() {
            
            var x = document.getElementById("showpassword");
            var y = document.getElementById("showpassword1");
            
            if (x.type === "password") {
                    x.type = "text";
            } else {
                    x.type = "password";            
            }
                        

            if (y.type === "password") {
                    y.type = "text";
            } else {
                    y.type = "password";
            }
            
            }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>