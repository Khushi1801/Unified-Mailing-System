<?php

// *** Start session *** // 
session_start();

// *** Setup Database Connection *** // 
require '../Connection/Connection.php';

if(!isset($_POST['signup']))
{
	header("Location:signup.php");
	exit();
}

// *** Get require variable *** //

// 1. Username
$username = $_POST['username'];

// 2. Emailaddress 
$email = $_POST['emailaddress'];

// 3. Password 
$password = $_POST['password'];

// 4. Re-enter Password 
$cpassword = $_POST['cpassword'];

// 5. Mobile number 
$mobile = $_POST['mobile'];

if($password === $cpassword)
{

	$Fetch_email_query = "SELECT * FROM `userdata` WHERE  `Emailaddress` = '$email' ";

	$result1 = mysqli_query($conn , $Fetch_email_query) or die("query unsuccessful");

	if(mysqli_num_rows($result1)>0)
	{
		// Navigate to Signin page 

		echo "<script type='text/javascript'> 
			alert('Account is Already Created. Please Singin!!!');
			window.location.replace('./signin.php'); 
			</script>
			";
		exit();
	}
	else
	{
		//Create Verification code 
		$otp = rand(1000,9999);
        
		// Send Verification code to user on email address 
		$apikey = "oJ0rhBML_h72b8-AN4hjcfbwla0c5QyXmNXA9l87cQB";
		$event  = "Otp";
		$value1 = $email;
		$value2 = $otp;
		$value3 = "";

		$ch = curl_init();

		$postdata = json_encode([
		                         "value1" => $value1,
		                         "value2" => $value2,
		                         "value3" => $value3,
		                         ]);

		$header = array();
		$header[] = "Content-Type: application/json";

		curl_setopt($ch,CURLOPT_URL, "https://maker.ifttt.com/trigger/$event/with/key/$apikey");
		curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

		$result = curl_exec($ch);
		curl_close($ch);

		// *** Set All variable value into session variable *** // 
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
		$_SESSION['mobile'] = $mobile;
		$_SESSION['verification_code'] = $otp;

		// Navigate to signup_verification page 

		echo "<script type='text/javascript'> 
			alert('Verification Code will be send on Email.');
			window.location.replace('../signup_verification.php'); 
			</script>
			";
		exit();

	}
}
else
{
	echo "<script type='text/javascript'> 
		alert('Password Does not matched!!.');
		window.location.replace('../signup.php'); 
		</script>
	";
		exit();
}


?>