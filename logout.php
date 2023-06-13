<?php 
session_start();
unset($_SESSION['valid_email']);
header("Location:signin.php");
exit();

?>