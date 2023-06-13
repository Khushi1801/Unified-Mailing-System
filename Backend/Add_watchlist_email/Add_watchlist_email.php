<?php

// *** Setup Database connection *** // 

require "../../Connection/Connection.php" ; 

// *** Start session variable *** // 

session_start() ; 

// 1. Get Watchlist main email 

$Watchlist_main_email = $_SESSION["watchlist_main_email"] ; 

// 2. Get Addition set email 

$Watchlist_set_email = $_POST["set_email"] ; 

// 3. Get User connection key 

$UserTable_key = $_COOKIE["key"] ; 
$User_watchlist_tablename = $UserTable_key."-watchlist" ; 

// Insert data into Table 

$Insert_watchlist_email_query = "INSERT INTO `$User_watchlist_tablename` (`Email_id`, `Main_email`, `Set_email`) 
                        VALUES (NULL, '$Watchlist_main_email', '$Watchlist_set_email')" ; 

$Insert_watchlist_email_query = mysqli_query($conn , $Insert_watchlist_email_query) ; 

echo "Insert-data" ; 
?>