<?php

// *** Start session variable *** // 
session_start();

// *** Setup Database Connection *** // 
require '../Connection/Connection.php';

// *** Get All required session variable from Signup.php *** // 

// 1. Verification code 
$verification_code = $_SESSION["verification_code"];

// 2. Username 
$username = $_SESSION["username"];

// 3. Email address 
$email = $_SESSION["email"];

// 4. Password 
$password = $_SESSION["password"];

// 5. Mobile number
$mobile = $_SESSION["mobile"];

// *** User enter verification code *** // 
$code = $_POST['verification_code'];

if($code == $verification_code)
{
        // Create unique key id for user //     

        $KeyData = "abcdefghijklmnopqrstuvwxyz" ; 
        $KeyData = str_shuffle($KeyData) ;     

        $Key = substr($KeyData, 0, 7) ;     

        // Create table for user connected email // 
        
        $Connected_email_table_name = $Key."-email" ; 
        
        $Create_user_connected_email_table = "CREATE TABLE `$Connected_email_table_name` 
                                ( 
                                        `Email_key` int NOT NULL AUTO_INCREMENT,
                                        `Email` varchar(100), 
                                        `Password` varchar(100), 
                                        `Email_primary` varchar(100),
                                        PRIMARY KEY(`Email_key`)
                                ) " ; 
        
        $Create_user_connected_email_table = mysqli_query($conn , $Create_user_connected_email_table) ; 
        
        // Create user watchlist table // 
        
        $Watchlist_table_name = $Key."-watchlist";
        
        $Create_watchlist_table = "CREATE TABLE `$Watchlist_table_name`
                                (
                                        `Email_id` int NOT NULL AUTO_INCREMENT, 
                                        `Main_email` varchar(100), 
                                        `Set_email` varchar(100), 
                                        PRIMARY KEY(`Email_id`)
                                )" ; 
                            
        $Create_watchlist_table = mysqli_query($conn, $Create_watchlist_table) ;     

        $Insert_into_userdata =  " INSERT INTO `userdata` (`user_id`, `Username`, `Emailaddress`, `Password`, `Mobilenumber`, `Table_name`) 
                                VALUES (NULL, '$username', '$email', '$password', '$mobile', '$Key') ";    

        $result = mysqli_query($conn,$Insert_into_userdata) ;    

        $cookie_name = "key";
        $cookie_value = $Key ;     

        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/") ;     

        if($result)
        {
                echo "<script type='text/javascript'> 
                alert('Registration Successfully.');
                window.location.replace('../Home.php'); 
                </script>
                ";
                exit();
        }
        else
        {
                echo "<script type='text/javascript'> 
                alert('Error!!.');
                window.location.replace('../signup.php'); 
                </script>
                ";
                exit();
        }
     
}
else
{
	echo "<script type='text/javascript'> 
	alert('verification code Not Matched!!!');
	window.location.href('../Signup.php'); 
	</script>
	";
	exit();
}



?>