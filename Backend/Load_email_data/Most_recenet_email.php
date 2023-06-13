<?php

// *** Start session variable *** // 

session_start() ; 

if (!isset($_SESSION["Most_recent"][$_SESSION["Connected_email"]])){
    $_SESSION["Most_recent"][$_SESSION["Connected_email"]] = array() ; 
}
else{}

// Setup imap connection 

$host = '{imap.gmail.com:993/imap/ssl/
    novalidate-cert/norsh}INBOX';

// Setup Username and Password 

$user = $_SESSION["Connected_email"];
$password = $_SESSION["Connected_email_password"];

$conn = imap_open("{imap.gmail.com:993/ssl}", $user, $password) ; 

// Get Current Date and Time and 
// Get before 7days date 

date_default_timezone_set("America/New_York"); 
$Month = date("m") ; 
$Year = date("Y") ; 
$Day = date("d") ; 

$Date_string = $Year."-".$Month."-".$Day ; 
$date=date_create($Date_string);

date_sub($date,date_interval_create_from_date_string("5 days"));

$Month_description = date_format($date, "M") ; 
$Day = date_format($date, "d") ; 
$Year = date_format($date, "Y") ; 

if (count($_SESSION["Most_recent"][$_SESSION["Connected_email"]]) > 1){
    $_SESSION["Unseen_email_count"] = count($_SESSION["Most_recent"][$_SESSION["Connected_email"]]) ; 
    echo "Fetch" ; 
}
else{
    // *** Create search value *** // 

    $SearchValue = "UNSEEN SINCE ".$Day."-".$Month_description."-".$Year ; 
    
    // *** Find emails data *** // 
    
    $mails = imap_search($conn , $SearchValue) ; 
    $_SESSION["Unseen_email_count"] = count($mails) ; 
    
    for($i=0; $i<count($mails); $i++){
        
        // Headers information 
        $headers = imap_fetch_overview($conn, $mails[$i], 0); 
        $headers = json_decode(json_encode($headers),true);
        
        // Fetch from address information 
        $header_info = imap_headerinfo($conn, $mails[$i]) ; 
        $From_address = $header_info->from[0]->mailbox . "@" . $header_info->from[0]->host;
        
        // Fetch email body message 
        $message = imap_fetchbody($conn, $mails[$i], '1');
        $finalMessage = trim(quoted_printable_decode($message));
    
        // Make email to again unseen 
        imap_clearflag_full($conn, $mails[$i], "\\Seen");

        array_push($headers, $From_address) ; 
        array_push($headers, $finalMessage) ; 
        array_push($_SESSION["Most_recent"][$_SESSION["Connected_email"]], $headers) ; 
    }
    
    echo "Fetch" ; 
}

?>