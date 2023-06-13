<?php

include '../../Connection/Connection.php' ; 

session_start() ; 

$User_email_address = $_POST['email'] ; 
$Fetch_userdata_query = "SELECT `Twitter`, `Instagram`, `Facebook` FROM `userdata` WHERE `Emailaddress`= '$User_email_address'";
$Fetch_userdata_query = mysqli_query($conn , $Fetch_userdata_query) ; 
$Fetch_userdata_query_result = mysqli_fetch_all($Fetch_userdata_query, MYSQLI_ASSOC) ; 

if ($_SESSION['Twitter'] == ""){
    $_SESSION['Social_handle_status'] = "Not available" ; 
}
else{

    $_SESSION['Instagram'] = $Fetch_userdata_query_result[0]['Instagram']; 
    $_SESSION['Twitter'] = $Fetch_userdata_query_result[0]['Twitter'] ; 
    $_SESSION['Facebook'] = $Fetch_userdata_query_result[0]['Facebook'] ; 
}

echo "Fetch" ; 


?>