<?php

// *** Start session variable *** // 

session_start() ; 

// *** Get set email address value *** // 

$Set_emailaddress = $_POST["email"] ; 

$_SESSION["Current_watchlist_email_option"] = $Set_emailaddress ; 

echo "Set" ; 

?>