<?php

// Start session // 

session_start() ; 

if (!isset($_SESSION["Email"][$_SESSION["Connected_email"]])){

    $_SESSION["Email"][$_SESSION["Connected_email"]] = array() ; 
} 

// Setup imap connection // 

$host = '{imap.gmail.com:993/imap/ssl/
novalidate-cert/norsh}INBOX';

// Setup Username and Password

$user = $_SESSION["Connected_email"];
$password = $_SESSION["Connected_email_password"];

$conn = imap_open("{imap.gmail.com:993/ssl}", $user, $password) ; 

// Option for fetch Data 

$Option =  $_POST["option"] ; 

if (!isset($_SESSION["Email_uid"][$_SESSION["Connected_email"]])){
    
    $mails = imap_search($conn, "UNSEEN") ; 
    $_SESSION["Email_uid"][$_SESSION["Connected_email"]] = $mails ; 
    
}
else{}

if (!isset($_SESSION["Email_start"][$_SESSION["Connected_email"]])){

    $_SESSION["Email_start"][$_SESSION["Connected_email"]] = 0 ; 
    
    if (count($_SESSION["Email_uid"][$_SESSION["Connected_email"]]) > 30){
        $_SESSION["Email_end"][$_SESSION["Connected_email"]] = 30 ; 
    }
    else{
        $_SESSION["Email_end"][$_SESSION["Connected_email"]] = count($_SESSION["Email_uid"][$_SESSION["Connected_email"]]) ; 
    }
    
}

if ($Option == "Start"){

    if (count($_SESSION['Email'][$_SESSION["Connected_email"]]) > 1){
    
        echo "Complete"; 
    
    }

    else{

        $StartValue = $_SESSION["Email_start"][$_SESSION["Connected_email"]] ; 
        $EndValue = $_SESSION["Email_end"][$_SESSION["Connected_email"]] ; 
        $mails = $_SESSION["Email_uid"][$_SESSION["Connected_email"]] ; 

        for($i=$StartValue ; $i<$EndValue+1; $i++){

            // Fetch header
            $headers = imap_fetch_overview($conn, $mails[$i], 0); 
            $headers = json_decode(json_encode($headers),true);
            
            // Fetch header info 
            $header_info = imap_headerinfo($conn, $mails[$i]) ;
            $From_address = $header_info->from[0]->mailbox . "@" . $header_info->from[0]->host;
            
            // Fetch email body 
            $message = imap_fetchbody($conn, $mails[$i], '1');
            $finalMessage = trim(quoted_printable_decode($message));

            array_push($headers, $From_address) ; 
            array_push($headers, $finalMessage) ; 
            array_push($_SESSION['Email'][$_SESSION['Connected_email']], $headers) ;
        }
        
        echo "Complete" ; 
    
    }
}
 
else if ($Option == "Next"){

    $StartValue = $_SESSION["Email_end"][$_SESSION["Connected_email"]] ; 

    if ($StartValue+30 > count($_SESSION["Email_uid"][$_SESSION["Connected_email"]])){
        $EndValue = count($_SESSION["Email_uid"][$_SESSION["Connected_email"]]) ; 
    }
    else{
        $EndValue = $StartValue + 30 ; 
    }

    $_SESSION["Email_start"][$_SESSION["Connected_email"]] = $StartValue ; 
    $_SESSION["Email_end"][$_SESSION["Connected_email"]] = $EndValue ; 
    $mails = $_SESSION["Email_uid"][$_SESSION["Connected_email"]] ; 

    for($i=$StartValue ; $i<$EndValue+1; $i++){

        // Fetch header information 
        $headers = imap_fetch_overview($conn, $mails[$i], 0); 
        $headers = json_decode(json_encode($headers),true);
        
        // Fetch from header information        
        $header_info = imap_headerinfo($conn, $mails[$i]) ;
        $From_address = $header_info->from[0]->mailbox . "@" . $header_info->from[0]->host;
        
        // Fetch email body 
        $message = imap_fetchbody($conn, $mails[$i], '1');
        $finalMessage = trim(quoted_printable_decode($message));

        array_push($headers, $From_address) ; 
        array_push($headers, $message) ; 
        array_push($_SESSION['Email'][$_SESSION['Connected_email']], $headers) ; 
    }

    echo "Complete" ; 

}

else{

    $StartValue = $_SESSION["Email_start"][$_SESSION["Connected_email"]] ; 
    $EndValue = $_SESSION["Email_start"][$_SESSION["Connected_email"]] ; 

    if ($StartValue < 0 ){
        
        $StartValue = 0 ; 
    }
    else{
        $StartValue = $StartValue - 30 ; 
    }

    $_SESSION["Email_start"][$_SESSION['Connected_email']] = $StartValue ; 
    $_SESSION["Email_end"][$_SESSION['Connected_email']] = $EndValue ; 


    echo "Complete" ; 
}



?>