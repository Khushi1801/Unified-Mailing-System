<?php 

// *** Setup Database connection *** // 
require '../Connection/Connection.php';

// *** Start session variable *** // 
session_start();

if(!isset($_POST['verifycode']))
{
	header("Location:forgotpw.php");
	exit();
}

// 1. Get Emailaddress 
$email = $_POST['emailaddress'];

$sql1 = "SELECT * FROM `userdata` WHERE  `Emailaddress` ='$email'";

$result1 = mysqli_query($conn,$sql1) or die("query unsuccessful");

if(mysqli_num_rows($result1)>0)
{

    $otp = rand(1000,9999);
    
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
    
    $_SESSION['email'] = $email;
    $_SESSION["Otp"] = $otp;
    	 	
    echo "<script type='text/javascript'> 
    			alert('Successfully Send the Otp');
    			window.location.replace('./verification_code.php'); 
    			</script>
    			";
    			exit();

}
else
{
	echo "<script type='text/javascript'> 
			alert('Account Not Created. Please First Create Account');
			window.location.replace('../signup.php'); 
			</script>
			";
			exit();
}


?>
