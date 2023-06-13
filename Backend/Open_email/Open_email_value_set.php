<?php

// Start session // 

session_start() ; 

// Email value // 

$Email_value = $_POST['i'] ; 
$Option = $_POST['option'] ; 

$_SESSION["Open_email_value"] = $Email_value ; 
$_SESSION["Open_email_option"] = $Option ; 

echo "Update" ; 

?>