<?php

// *** Setup Database connection *** // 

include '../../Connection/Connection.php' ; 

// *** Get user key *** // 

$User_key = $_COOKIE["key"] ; 

// *** Get social handle information *** // 

// 1. Set Twitter username 
$Twitter_username = $_POST['twitter']; 
$_SESSION["Twitter"] = $Twitter_username ; 

// 2. Set Instagram username 
$Instagram_username = $_POST['instagram'] ; 
$_SESSION["Instagram"] = $Instagram_username ; 

// 3. Set Twitter username 
$Facebook_username = $_POST['facebook'] ; 
$_SESSION["Facebook"] = $Facebook_username ; 
 
// *** Update social handle information query *** // 

$Update_social_handle_query = "UPDATE `userdata` SET `Twitter` = '$Twitter_username', `Instagram` = '$Instagram_username', `Facebook` = '$Facebook_username' " ; 
$Update_social_handle_query = mysqli_query($conn, $Update_social_handle_query) ; 

echo "Update" ; 

?>