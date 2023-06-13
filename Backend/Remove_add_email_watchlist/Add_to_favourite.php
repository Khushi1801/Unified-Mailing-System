<?php

// Start session variable // 

session_start() ; 

// Setup Database Connection 

require "../../Connection/Connection.php"; 

$Main_email = $_SESSION["Connected_email"] ; 
$Set_email = $_POST["email"] ; 
$Option_value = $_POST['option'] ; 

$UserKey = $_COOKIE["key"]; 
$User_watchlist_tablename = $UserKey."-watchlist" ; 

if ($Option_value == "0"){
    $Insert_email_query = "INSERT INTO `$User_watchlist_tablename` (`Email_id`, `Main_email`, `Set_email`) 
                    VALUES (NULL, '$Main_email', '$Set_email') ";
  
    $Insert_email_query = mysqli_query($conn , $Insert_email_query) ; 

    array_push($_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]], $Set_email) ; 

    echo "Update" ; 
}
else{
    $Remove_email_query = "DELETE FROM `$User_watchlist_tablename` WHERE `Main_email` = '$Main_email' AND `Set_email` = '$Set_email' " ; 
    $Remove_email_query = mysqli_query($conn, $Remove_email_query) ; 
    
    $Unset_value = 0 ; 

    for($i=0; $i<count($_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]]) ; $i++){
        if ($_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]][$i] == $Set_email){
            $Unset_value = $i ; 
            break ; 
        }        
    }

    unset($_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]][$Unset_value]) ; 

    echo "Update" ; 
}
?>