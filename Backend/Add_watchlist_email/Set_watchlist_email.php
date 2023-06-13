<?php

// *** Start session variable *** // 

session_start() ; 

// *** Get watchlist main email address *** // 

$Watchlist_main_email = $_POST['watchlist_main_email'] ; 

unset($_SESSION['watchlist_main_email']); 
$_SESSION["watchlist_main_email"] = $Watchlist_main_email ; 
echo $_SESSION['watchlist_main_email'] ; 

?>