<?php

// *** Start session variable *** // 

session_start() ; 

// *** Setup Database Connection *** // 

require '../../Connection/Connection.php' ; 

// *** Get Email address *** // 

$Email_address = $_POST['email']; 

// *** Get User table key *** // 

$User_table_key = $_COOKIE["key"] ; 
$User_email_table_key = $User_table_key."-email" ; 

// *** Check this email address already connected or not *** // 

$Check_email_address_query = "SELECT * FROM `$User_email_table_key` WHERE `Email` = '$Email_address'" ; 
$Check_email_address_query = mysqli_query($conn , $Check_email_address_query) ; 

$Check_email_address_query_row_count = mysqli_num_rows($Check_email_address_query) ; 

if ($Check_email_address_query_row_count > 0 ){
    echo "Connected" ; 
}
else{

    // *** Send Verification code to user *** // 
    
    //Create Verification code 
    
    $otp = rand(1000,9999);
            
    // Send Verification code to user on email address 
    
    $apikey = "oJ0rhBML_h72b8-AN4hjcfbwla0c5QyXmNXA9l87cQB";
    $event  = "Otp";
    $value1 = $Email_address;
    $value2 = $otp;
    $value3 = "";
    
    $ch = curl_init();
    
    $postdata = json_encode([
                             "value1" => $value1,
                             "value2" => $value2,
                             "value3" => $value3,
                             ]);
    
    $header = array();
    $header[] = "Content-Type: application/json";
    
    curl_setopt($ch,CURLOPT_URL, "https://maker.ifttt.com/trigger/$event/with/key/$apikey");
    curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    $_SESSION["Email_account_verification_code"] = $otp ; 
    
    echo "Send_email" ; 
}


?>