<?php 

require_once 'C:\xampp\htdocs\Project\vendor\autoload.php'; 
 
use Twilio\Rest\Client; 

$User_mobile_number = "6354757251" ; 
$Message = "Keyur" ; 

$sid    = "AC0f3e002edc872717fb8713914cfe2f92"; 
    $token  = "1df28887b95e3934bf7b8e6f793a7f47"; 
    $twilio = new Client($sid, $token); 
  
    $User_mobile_number = "+91".$User_mobile_number ; 

    $message = $twilio->messages 
                ->create("whatsapp:".$User_mobile_number, // to 
                    array( 
                        "from" => "whatsapp:+14155238886",       
                        "body" => $Message
                    ) 
);

?>