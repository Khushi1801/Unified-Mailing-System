<?php

// *** Start session variable *** // 

session_start() ; 

// *** Setup Database Connection *** // 

require '../../Connection/Connection.php' ; 

// *** Get Email address *** // 

$Email_address = $_POST["email"] ; 
$Email_password = $_POST["password"] ; 
$User_input_code = $_POST["code"] ; 

$Verification_code = $_SESSION["Email_account_verification_code"] ; 

if ($User_input_code == $Verification_code){

    // *** Get User table key *** // 
    
    $User_key = $_COOKIE["key"]; 
    $User_email_table = $User_key."-email" ; 
    
    $Insert_email_account_query = "INSERT INTO `$User_email_table` (`Email_key`, `Email`, `Password`, `Email_primary`) 
                                VALUES (NULL, '$Email_address', '$Email_password', '0') " ; 
    
    $Insert_email_account_query = mysqli_query($conn , $Insert_email_account_query) ; 
    
    echo "Insert" ; 
}
else{
    echo "Incorrect" ; 
}
?>