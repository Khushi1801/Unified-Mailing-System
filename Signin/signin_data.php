<?php

session_start();
require '../Connection/Connection.php';

if(!isset($_POST['signin']))
{
	header("Location:signin.php");
	exit();
}

$email = $_POST['emailaddress'];
$password = $_POST['password'];

$sql1 = "SELECT * FROM `userdata` WHERE  `Emailaddress` ='$email' AND `Password` = '$password'";

$result1 = mysqli_query($conn,$sql1) ;

if(mysqli_num_rows($result1)>0) 
{
         
	    $result_data = mysqli_fetch_all($result1, MYSQLI_ASSOC); 
		
		$User_table_name = $result_data[0]['Table_name']; 
		
		setcookie("key", $User_table_name, time() + 86400*30, "/") ; 
		
		$_SESSION['valid_email'] = $email;

		echo "<script type='text/javascript'> 
			alert('Successfully Login.');
			window.location.replace('../Home.php'); 
			</script>
			";
			exit();
}
else
{

	echo "<script type='text/javascript'> 
			alert('SomeThing Wrong!!!');
			window.location.replace('./signin.php'); 
			</script>
			";
			exit();
}


?>