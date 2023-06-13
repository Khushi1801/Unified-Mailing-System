<?php

// *** Setup Database connection *** // 

require "../../Connection/Connection.php" ; 

// *** Start session variable *** // 

session_start( ) ; 

// *** Get require variable *** //

$Watchlist_main_email = $_SESSION["watchlist_main_email"] ; 

$Delete_email_value = $_POST["email"] ; 

$UserTable_name = $_COOKIE["key"] ; 
$UseTable_watchlist_tablename = $UserTable_name."-watchlist" ; 

$Delete_email_value = "DELETE FROM `$UseTable_watchlist_tablename` WHERE `Main_email` = '$Watchlist_main_email' AND `Set_email` = '$Delete_email_value' "; 

$Delete_email_value = mysqli_query($conn , $Delete_email_value) ; 

echo 'Delete' ; 

?>