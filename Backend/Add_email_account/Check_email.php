<?php

// Start session variable // 

session_start() ; 

$Email = $_POST["email"]; 
$Table_name = $_COOKIE['key']; 

require '../../Connection/Connection.php';

$User_email_table_name = $Table_name.'-email'; 

$Set_zero_query = "UPDATE `$User_email_table_name` SET `Email_primary` = '0' "; 
$Set_zero_query = mysqli_query($conn, $Set_zero_query); 

$Update_primary_email_query = "UPDATE `$User_email_table_name` SET `Email_primary` = '1' WHERE `Email` = '$Email' "; 
$Update_primary_email_query = mysqli_query($conn, $Update_primary_email_query); 

echo "Update" ; 

?>