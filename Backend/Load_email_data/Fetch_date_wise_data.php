<?php

// *** Start session *** // 

session_start() ; 

if (!isset($_SESSION["Calender"][$_SESSION["Connected_email"]])){
    $_SESSION["Calender"][$_SESSION["Connected_email"]] = array() ; 
}
else{
    unset($_SESSION["Calender"][$_SESSION["Connected_email"]]) ; 
    $_SESSION["Calender"][$_SESSION["Connected_email"]] = array();  
}

// *** Setup Database connection *** // 

include '../../Connection/Connection.php' ; 

// Setup imap connection // 

$host = '{imap.gmail.com:993/imap/ssl/
    novalidate-cert/norsh}INBOX';
    
// Setup Username and Password
    
$user = $_SESSION["Connected_email"];
$password = $_SESSION["Connected_email_password"];
    
$connection = imap_open("{imap.gmail.com:993/ssl}", $user, $password) ; 

// Fetch user key //

$User_key = $_COOKIE["key"] ; 
$User_email_notification_table = $User_key."-notification" ;

// *** First fetch all notification data *** // 

$Fetch_notification_email_query = "SELECT * FROM  `$User_email_notification_table` WHERE `Notification_main_email` = '$user' " ; 
$Fetch_notification_email_query = mysqli_query($conn , $Fetch_notification_email_query) ; 

// Fetch query data
$Fetch_notification_email_query_data = mysqli_fetch_all($Fetch_notification_email_query, MYSQLI_ASSOC) ; 

// Fetch query row count
$Fetch_notification_email_query_row_count = mysqli_num_rows($Fetch_notification_email_query) ; 

if ($Fetch_notification_email_query_row_count > 0 ){

    // Array which store email data with date wise // 

    $Date_wise_email_data = array() ; 

    // Get today date 
    $Today_date = date('y-m-d');

    // Get Today date time 
    $Today_date_time = strtotime($Today_date) ; 

    // Email vise email uid 
    $Email_wise_uid = array() ; 
    $Email_list = array() ; 

    for($i=0 ; $i<count($Fetch_notification_email_query_data); $i++){
        
        // Get email notification email start date  
        $Email_start_date = $Fetch_notification_email_query_data[$i]["Notification_start_date"] ; 
        $Email_start_date_time = strtotime($Email_start_date) ;

        // Get email notification email end date
        $Email_end_date = $Fetch_notification_email_query_data[$i]["Notification_end_date"] ; 
        $Email_end_date_time = strtotime($Email_end_date) ;  

        // Notification email 
        $Notification_email = $Fetch_notification_email_query_data[$i]["Notification_email"] ; 

        // Create email start date 
        $Email_start_date_create = date_create($Email_start_date);

        if (($Today_date_time >= $Email_start_date_time)  ){
            if ($Email_end_date_time >= $Today_date_time){
                
                // Month information 
                $Month_information = date_format($Email_start_date_create, "M"); 
                
                // Day information 
                $Day = date_format($Email_start_date_create, "d"); 
                
                // Year information 
                $Year = date_format($Email_start_date_create, "Y") ;  

                $Search_option = "UNSEEN FROM ".$Notification_email." SINCE ".$Day."-".$Month_information."-".$Year ; 

                $mails = imap_search($connection, $Search_option) ; 

                if ($mails != NULL){

                    if (!in_array($Notification_email, $Email_list)){

                        // Add email to email list
                        array_push($Email_list, $Notification_email) ; 
                        
                        // Create notification email slot 
                        $Email_wise_uid[$Notification_email] = array() ; 
                    }

                    for($j=0; $j<count($mails); $j++){

                        if (!in_array($mails[$j], $Email_wise_uid[$Notification_email])){
                            array_push($Email_wise_uid[$Notification_email], $mails[$j]) ; 
                        }
                    }
                    
                }
            }
        }

        
    }

    for($i = 0 ; $i<count($Email_list); $i++){
        for($j=0; $j<count($Email_wise_uid[$Email_list[$i]]); $j++){

            // Fetch header information 
            $headers = imap_fetch_overview($connection, $Email_wise_uid[$Email_list[$i]][$j], 0); 
            $headers = json_decode(json_encode($headers),true);
              
            // Fetch from header information        
            $header_info = imap_headerinfo($connection, $Email_wise_uid[$Email_list[$i]][$j]) ;
            $From_address = $header_info->from[0]->mailbox . "@" . $header_info->from[0]->host;
        
            // Fetch email body message 
            $message = imap_fetchbody($connection,  $Email_wise_uid[$Email_list[$i]][$j], '1');
            $finalMessage = trim(quoted_printable_decode($message));

            // Make email to flag to unseen 
            imap_clearflag_full($connection, $Email_wise_uid[$Email_list[$i]][$j], "\\Seen");
             
            array_push($headers, $From_address); 
            array_push($headers, $finalMessage); 
            array_push($_SESSION["Calender"][$_SESSION["Connected_email"]], $headers) ; 
            
        }
    }

    echo "Fetch" ; 

}
else{
    echo "Fetch" ; 
}


?>