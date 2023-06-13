<?php 

session_start();

$code = $_POST['Code'];

$session_code = $_SESSION["Otp"];

echo $code;
echo $session_code;

if($code == $session_code)
{
	echo "<script type='text/javascript'> 
			alert('Successfully Matched Otp');
			window.location.replace('http://localhost:8081/email-alerts%20projects/change_pw.php'); 
			</script>
			";
			exit();
}
else
{
	echo "<script type='text/javascript'> 
			alert('Otp Not Matched');
			window.location.replace('http://localhost:8081/email-alerts%20projects/forgot_password.php'); 
			</script>
			";
			exit();
}

?>