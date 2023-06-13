<?php

// *** Start session variable *** // 

session_start() ; 

if (!isset($_SESSION["Most_reminder"][$_SESSION["Connected_email"]])){
    $_SESSION["Most_reminder"][$_SESSION["Connected_email"]] = array() ; 
    $_SESSION["Reminder_notification"] = array() ; 
}
else{
    unset($_SESSION['Most_reminder'][$_SESSION["Connected_email"]]); 
    $_SESSION["Most_reminder"][$_SESSION["Connected_email"]] = array() ;
    
    unset($_SESSION["Reminder_notification"]) ; 
    $_SESSION["Reminder_notification"] = array() ; 
}

// Setup imap connection 

$host = '{imap.gmail.com:993/imap/ssl/
    novalidate-cert/norsh}INBOX'; 

// Setup Username and Password 

$user = $_SESSION["Connected_email"];
$password = $_SESSION["Connected_email_password"];

$conn = imap_open("{imap.gmail.com:993/ssl}", $user, $password) ; 

// Fetch watchlist email 

$Watchlist_email_data = $_SESSION["Watchlist_email_data"] ; 

$Search_value ;  

$_SESSION["Most_recent_mail_id"] = array(); 

// $Option = $_POST["option"] ; 

for($i=0 ; $i<count($Watchlist_email_data[$_SESSION["Connected_email"]]); $i++){

    // Read watchlist email first 
    $email = $Watchlist_email_data[$_SESSION["Connected_email"]][$i] ; 
    
    // Create Search value 
    $Search_value = "UNSEEN FROM ".$email ;

    $mails = imap_search($conn , $Search_value);

    if ($mails != NULL){
        array_push($_SESSION["Most_recent_mail_id"], $mails) ; 
        
        $Notification_array = array($email, count($mails)) ; 

        array_push($_SESSION["Reminder_notification"], $Notification_array) ; 
    }
    
}

$_SESSION["Current_watchlist_email_option"] = "All" ;

for($i=0; $i<count($_SESSION["Most_recent_mail_id"]); $i++){

    for ($j=0 ; $j<count($_SESSION["Most_recent_mail_id"][$i]); $j++){

        // Fetch header information 
        $headers = imap_fetch_overview($conn, $_SESSION["Most_recent_mail_id"][$i][$j], 0 ) ; 
        $headers = json_decode(json_encode($headers), true) ; 

        // Fetch header information 
        $header_info = imap_headerinfo($conn, $_SESSION["Most_recent_mail_id"][$i][$j]) ; 
        $From_address = $header_info->from[0]->mailbox . "@" . $header_info->from[0]->host;

        // Fetch email body         
        $message = imap_fetchbody($conn, $_SESSION["Most_recent_mail_id"][$i][$j], '1');
        $finalMessage = trim(quoted_printable_decode($message));

        // // Make email to unseen 
        imap_clearflag_full($conn, $_SESSION["Most_recent_mail_id"][$i][$j], "\\Seen");
    
        array_push($headers, $From_address) ; 
        array_push($headers, $finalMessage) ; 
        array_push($_SESSION["Most_reminder"][$_SESSION["Connected_email"]], $headers) ; 
    }
    
}
echo "Insert" ; 

?>