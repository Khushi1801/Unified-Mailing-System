<?php

// *** Start session variable *** //

session_start() ; 

// *** Setup Database Connection *** // 

include '../../Connection/Connection.php' ; 

// *** Get main connected email address *** // 

$Main_connected_email = $_SESSION["Connected_email"] ; 

$Notification_email = $_POST["email"] ; 
$Notification_start_date = $_POST["start_date"] ; 
$Notification_end_date = $_POST["end_date"] ; 

// *** User key *** // 

$User_key = $_COOKIE['key'];
$User_notification_table_name = $User_key.'-notification' ; 

// *** Delete notification email query *** // 

$Delete_notification_email_query = "DELETE FROM `$User_notification_table_name` WHERE `Notification_main_email` = '$Main_connected_email' AND `Notification_email` = '$Notification_email' AND `Notification_start_date` = '$Notification_start_date' AND `Notification_end_date` = '$Notification_end_date'" ; 
$Delete_notification_email_query = mysqli_query($conn, $Delete_notification_email_query) ; 

echo "Delete" ; 

?>