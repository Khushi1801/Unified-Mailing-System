<?php

// *** Start session variable *** // 

session_start() ; 

// *** Get open email value *** // 

$Open_email = $_SESSION['Open_email_value'] ; 

$Open_email = $Open_email - 1 ; 

if ($Open_email < 0 ){
    $Open_email = 0 ; 
    $_SESSION["Open_email_value"] = $Open_email ; 
}
else{
    $_SESSION['Open_email_value'] = $Open_email ; 
}

echo "Update" ; 
?>