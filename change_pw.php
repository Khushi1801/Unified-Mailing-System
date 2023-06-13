<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="./Change_password/change_pw.css">
    <link rel="icon" type="image/x-icon" href="./Images/logo.png">
</head>
<body>
    
    <!-- Change password option division  -->

    <div class="changepw">

        <div class="Input_division">
            
            <!-- Website logo and name div  -->

            <div class="Website_logo_title_div">
                
                <!-- Website logo div -->
                <div class="Website_logo_div">
                    <img src="./Images/logo.png" alt="" class="Website_logo">
                </div>

                <!-- Website name div  -->
                <div class="Website_title">
                    Change Password
                </div>
            
            </div>


            <form action="./Change_password/change_pw_data.php" method="POST">
            <!-- Input field div  -->

            <div class="Input_option_division">
                  
                <!-- Password input  -->
                <div class="input-group mb-3">
                    <input type="password" class="form-control Input_option" placeholder="Enter New Password" 
                    aria-label="Username" aria-describedby="basic-addon1" name="password" required>
                    
                </div>
                <!-- Reenter password input  -->
                <div class="input-group mb-3">
                    <input type="password" class="form-control Input_option" placeholder="Re-Enter Password" 
                    aria-label="Username" aria-describedby="basic-addon1" name="cpassword" required>
                </div>
            
                <!-- Change Password button  -->
                <button class="Submit_button" name="updatepw">Change Password</button>

                </form>
                
            </div>


        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>