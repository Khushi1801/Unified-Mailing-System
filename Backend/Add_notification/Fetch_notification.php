<?php

// *** Start session variable *** // 

session_start() ; 

// *** Setup Database connection *** // 

include '../../Connection/Connection.php' ; 

// *** Fetch User key *** // 

$User_key = $_COOKIE["key"] ; 
$User_notification_table_key = $User_key."-notification"; 

// *** Get Current account email address *** // 

$Current_email = $_SESSION["Connected_email"] ; 

// *** Fetch Notification query *** // 

$Fetch_notification_query = "SELECT * FROM `$User_notification_table_key` WHERE `Notification_main_email` = '$Current_email' " ;
$Fetch_notification_query = mysqli_query($conn , $Fetch_notification_query) ; 
$Fetch_notification_query_data = mysqli_fetch_all($Fetch_notification_query, MYSQLI_ASSOC) ; 

if(isset($_SESSION["Notification_email_data"])){
    unset($_SESSION["Notification_email_data"]) ; 
}

// *** Set Notification data to session variable *** // 
$_SESSION["Notification_email_data"] = $Fetch_notification_query_data ; 

echo "Fetch" ; 

?>