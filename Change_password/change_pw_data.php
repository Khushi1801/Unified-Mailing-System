<?php 

// *** Setup Database Connection *** // 
require '../Connection/Connection.php';

// *** Start session variable *** //
session_start();

// 1. Get Email 
$email = $_SESSION["email"];

// 2. Password
$password = $_POST["password"];

// 3. Re-enter Password 
$cpassword = $_POST["cpassword"];

if($password == $cpassword)
{
	$sql1 = "UPDATE `userdata` SET `Password`= '$password' WHERE  `Emailaddress` = '$email' ";

	$result1 = mysqli_query($conn,$sql1) or die("query unsuccessful");

	echo "<script type='text/javascript'> 
			alert('Successfully changes password');
			window.location.replace('../Home.php'); 
			</script>
			";
    exit();

}
else
{
	echo "<script type='text/javascript'> 
			alert('Password Not Changed');
			window.location.replace('../change_pw.php'); 
			</script>
			";
	exit();
}





?>