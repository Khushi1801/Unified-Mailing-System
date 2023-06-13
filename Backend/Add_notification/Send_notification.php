<?php

// *** Start session variable *** // 

session_start() ; 

require_once 'C:\xampp\htdocs\Project\vendor\autoload.php'; 
 
use Twilio\Rest\Client; 

// === Create Notification message === // 

$Message = "You have notification \n" ; 

for($i=0; $i<count($_SESSION["Reminder_notification"]); $i++){
    
    if ($i < 1 ){

        $Email_address = $_SESSION["Reminder_notification"][$i][0] ; 
        $Notification_count = $_SESSION["Reminder_notification"][$i][1] ; 
    
        $Message = $Message."from ".$Email_address." and " ; 
    
    }
    else{
        break ; 
    }
    
}

$Message = $Message."other accounts " ; 

// === Stop Notification message === // 

if (!isset($_COOKIE["reminder_notification"])){

    // User mobile number 
    $User_mobile_number = $_SESSION["Mobilenumber"] ; 

    function Send_order_information($Information ,$Information_send_mobile_number ){
        $fields = array(
        "sender_id" => "TXTIND",
        "message" => $Information,
        "route" => "v3",
        "numbers" => $Information_send_mobile_number,
        );
    
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: WFVyc8vmqoHP1g7K9wOM2istjNbQ3hXaDeJIlZR4n0zGdA5Lrpr1wJlFfgXj0Y6tvZTGqUzCs4kemxD2",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    }
    Send_order_information($Message , $User_mobile_number) ; 
 
    // === Send Whatsapp message === // 

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
 

    $cookie_name = "reminder_notification" ; 
    $cookie_value = 1 ; 

    setcookie($cookie_name, $cookie_value, time() + (86400 * 2), "/") ;

    echo "Set" ; 
}

else{
    echo "Set"  ; 
}


?>