<?php

// *** Start session variable *** // 

session_start() ; 

// *** Setup Database Connection *** // 

include "../../Connection/Connection.php" ; 

// *** Get Post variable *** // 

$Start_date = $_POST["start_date"] ;

$End_date = $_POST["end_date"] ; 

$Email = $_POST["email"] ; 

// *** Get user key *** // 

$User_key = $_COOKIE["key"] ; 
$User_notification_table_name = $User_key."-notification" ; 

// *** Main connected email *** // 

$Main_connected_email = $_SESSION["Connected_email"] ; 

$Email_start_date_time = strtotime($Start_date) ; 
$Email_end_date_time = strtotime($End_date) ; 

if ($Email_start_date_time > $Email_end_date_time){
    echo "Invalid" ; 
}
else{

    // *** Email notification insert query *** // 
    
    $Email_insert_query = "INSERT INTO `$User_notification_table_name` (`Notification_id`, `Notification_start_date`, `Notification_end_date`, `Notification_email`, `Notification_main_email`) 
                        VALUES (NULL, '$Start_date', '$End_date', '$Email', '$Main_connected_email') " ; 
    
    $Email_insert_query = mysqli_query($conn , $Email_insert_query) ;
    
    echo "Notification" ; 
}


?>