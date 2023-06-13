<?php

// *** Start session variable *** // 

session_start() ; 

// *** Get Open email value *** // 

$Open_email_value = $_SESSION["Open_email_value"] ; 

if (count($_SESSION["Email"][$_SESSION["Connected_email"]]) < $Open_email_value){
    $Open_email_value = 0 ; 
    $_SESSION["Open_email_value"] = $Open_email_value; 
}
else{
    $Open_email_value = $Open_email_value + 1 ; 
    $_SESSION["Open_email_value"] = $Open_email_value ; 
}

echo "Update" ; 

?>