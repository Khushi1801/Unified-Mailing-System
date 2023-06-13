<?php

// *** Setup Database connection *** // 

include "Connection/Connection.php" ; 

// *** start session *** // 

session_start() ; 

// *** Get User table name key *** //

$User_table_key = $_COOKIE["key"] ; 
$User_watchlist_tablename = $User_table_key."-watchlist"; 
$User_connected_email_tablename = $User_table_key."-email" ; 

// *** Fetch user information from `userdata` table *** // 

$User_information_fetch_query = "SELECT * FROM `userdata` WHERE `Table_name` = '$User_table_key' " ; 
$User_information_fetch_query = mysqli_query($conn, $User_information_fetch_query) ; 
$User_information_fetch_query_data = mysqli_fetch_all($User_information_fetch_query, MYSQLI_ASSOC) ; 

// Get username 
$Username = $User_information_fetch_query_data[0]['Username'] ; 

// Get Emailaddress 
$Email_address = $User_information_fetch_query_data[0]['Emailaddress'] ; 

// Get user mobile number 
$Mobile_number = $User_information_fetch_query_data[0]["Mobilenumber"] ;
$_SESSION["Mobilenumber"] = $Mobile_number ; 

// Get Twitter social handle 
$_SESSION["Twitter"] = $User_information_fetch_query_data[0]["Twitter"] ; 

// Get Instagram social handle 
$_SESSION["Instagram"] = $User_information_fetch_query_data[0]['Instagram'] ; 

// Get Facebook social handle 
$_SESSION['Facebook'] = $User_information_fetch_query_data[0]['Facebook'] ; 

// *** Email information show related variable *** // 

$Email_title ; 
$Email_from_value ; 
$Email_date ; 
$Email_seen_value ; 
$Email_attachment_value ; 
$Email_division_value ; 
$Email_set_value ; 
$Email_data ; 
$Email_division_color ; 

// *** Most recent email information show related variable *** // 

$Most_recent_title; 
$Most_recent_form_value ; 
$Most_recent_date ; 
$Most_recent_seen_value ; 
$Most_recent_division_value ; 
$Most_recent_set_value ; 
$Most_recent_email_data ; 
$Tem_date ; 
$Most_recent_pervious_date = "" ; 
$Most_recent_division_color ; 

// *** Reminder email information show related variable *** // 

$Reminder_email_title ; 
$Reminder_email_from_value ; 
$Reminder_email_date ; 
$Reminder_email_seen_value ; 
$Reminder_email_division_value = -1 ; 
$Reminder_email_set_value ; 
$Previous_reminder_email_value ; 
$Reminder_email_data ; 
$Reminder_email_message ; 
$Reminder_email_division_color ; 
$Reminder_email_index_value ; 

if (!isset($_SESSION["Current_watchlist_email_option"])){
    $_SESSION["Current_watchlist_email_option"] = "All" ; 
}
else{}


// *** Watchlist email show related variable *** // 

$Watchlist_email_list ; 

// *** Fetch connected email *** // 

$Fetch_email_query = "SELECT * FROM `$User_connected_email_tablename` " ; 
$Fetch_email_query = mysqli_query($conn, $Fetch_email_query) ; 
$Fetch_email_query_data = mysqli_fetch_all($Fetch_email_query,MYSQLI_ASSOC) ; 

// ** Store connected email Data ** // 
$Connected_email_data = array() ; 

// *** Store Watchlist email information *** // 
$Watchlist_email ; 

for ($i=0 ; $i<count($Fetch_email_query_data); $i++){
    $Connected_email_data[$i] = [$Fetch_email_query_data[$i]["Email"],$Fetch_email_query_data[$i]["Password"], $Fetch_email_query_data[$i]["Email_primary"]] ; 

    // Fetch all watchlist that connected with this account 

    $Current_email = $Fetch_email_query_data[$i]["Email"] ; 

    $Select_watchlist_email = "SELECT `Set_email` FROM `$User_watchlist_tablename` WHERE `Main_email` = '$Current_email' " ; 
    $Select_watchlist_email = mysqli_query($conn, $Select_watchlist_email) ; 
    $Select_watchlist_email_data = mysqli_fetch_all($Select_watchlist_email , MYSQLI_ASSOC) ; 
    
    // Create container for particular email 
    $Watchlist_email[$Current_email] = array() ; 

    for($j= 0; $j<count($Select_watchlist_email_data) ; $j++){
          
        array_push($Watchlist_email[$Current_email], $Select_watchlist_email_data[$j ]["Set_email"]) ; 
    }

}
$_SESSION["Watchlist_email_data"] = $Watchlist_email ; 
$Connected_email ; 
$Connected_email_password ; 
$Connected_email_primary ; 

$Email_header_data = array(); 

// *** Watchlist email related division *** // 

$Watchlist_main_email ; 
$Watchlist_current_division ; 
$Watchlist_set_email ; 

// *** Open email related variable *** // 

$Open_email_subject ; 
$Open_email_from_value ; 
$Open_email_date ; 
$Open_email_data ; 
$Open_email_set_value ; 

// *** Notification email related show variable *** // 

$Notification_email ; 
$Notification_email_start_date ; 
$Notification_email_end_date ; 


// *** Color array *** // 

$Color_array = array(
    "0" => "#f9bf10" , 
    "1" => "#f45804", 
    "2" => "#0ee1b3", 
    "3" => "#0eb0e1" , 
    "4" => "#5861fe" , 
    "5" => "#710ee1" , 
    "6" => "#3ce10e" , 
    "7" => "#fd6291" , 
    "8" => "#f910bb" , 
    "9" => "#f9bf10"
) ; 

// *** Calender wise email show related variable *** // 

$Date_wise_email_subject ; 
$Date_wise_email_from_value ; 
$Date_wise_email_date ; 
$Date_wise_division_value; 
$Date_wise_email_set_value ; 
$Date_wise_email_seen_value ; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./Home_page/Home.css">
    <script src="https://kit.fontawesome.com/2b5bac5bde.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Mukta&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./Images/logo.png">
    <script src="./Home.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    
    <!-- Connected email information division  -->
    <div id="Connected_email_account">
        
        <div id="Connected_email">
            
            <!-- Connected email close option division  -->
            <div class="Connected_email_close">
                <i class="fa-solid fa-xmark"
                    onclick="Connected_email_close()"></i>
            </div>

            <!-- Particular email information division  -->
        
        
            <?php
                
                global $Connected_email ;
                global $Connected_email_password;
                global $Connected_email_primary ;
                global $Connected_email_data ; 

                for($i= 0 ; $i<count($Connected_email_data); $i++){
                    
                    $Connected_email = $Connected_email_data[$i][0] ; 
                    $Connected_email_password = $Connected_email_data[$i][1];
                    $Connected_email_primary = $Connected_email_data[$i][2]; 
                    ?>

                        <div class="Connected_email_information"> 
                            
                            <?php 
                            global $Connected_email_primary ; 
                            global $Connected_email ; 
                            global $Connected_email_password ; 

                                if ($Connected_email_primary == "1"){
                                    $_SESSION["Connected_email"] = $Connected_email ;
                                    $_SESSION["Connected_email_password"] = $Connected_email_password ;
                                    $_SESSION["watchlist_main_email"] = $_SESSION["Connected_email"] ; 
                                    ?>
                                    <i class="fa-solid fa-check"></i>
                                    <?php
                                }
                            ?>

                            <div class="Connected_email"
                                onclick="Set_primary_key('<?php global $Connected_email; echo $Connected_email; ?>')">
                                <?php global $Connected_email ; echo $Connected_email ; ?>
                            </div>
            
                        </div>

                    <?php
                }
            
            ?>


    
        </div>

    </div>
      
    <!-- Profile information division  -->
    <div id="Profile_information_division">

        <div id="Profile_information">
             
            <!-- Connected email close option division  -->
            <div class="Connected_email_close">
                <i class="fa-solid fa-xmark"
                    onclick="Profile_information_close()"></i>
            </div>
           
            <!-- Username information  -->

            <div class="Userdata_information">
            
                <i class="fa-solid fa-user"></i>
                <div class="Userdata">
                    <?php global $Username; echo $Username ; ?>
                </div>
            
            </div>

            <!-- Email address information  -->

            <div class="Userdata_information">
                <i class="fa-solid fa-envelope" style="color:white; margin-top:auto; margin-bottom:auto;"></i>
                <div class="Userdata">
                    <?php global $Email_address ; echo $Email_address; ?>
                </div>
            </div>

            <!-- Mobile number information  -->
            
            <div class="Userdata_information">
                <i class="fa-solid fa-phone" style="color:white; margin-top:auto; margin-bottom:auto;"></i>
                <div class="Userdata">
                    <?php global $Mobile_number; echo $Mobile_number;  ?>
                </div>
            </div>

            <!-- Twitter social handle information  -->

            <div class="Userdata_information">
                <i class="fa-brands fa-twitter" style="color:white; margin-top:auto; margin-bottom:auto;"></i>
                <div class="Userdata">
                    <?php echo $_SESSION["Twitter"] ;   ?>
                </div>
            </div>

            <!-- Instagram social handle information  -->

            <div class="Userdata_information">
                <i class="fa-brands fa-instagram" style="color:white; margin-top:auto; margin-bottom:auto;"></i>
                <div class="Userdata">
                    <?php echo $_SESSION["Instagram"] ;   ?>
                </div>
            </div>

            <!-- Facebook social handle information  -->

            <div class="Userdata_information">
                <i class="fa-brands fa-facebook" style="color:white; margin-top:auto; margin-bottom:auto;"></i>
                <div class="Userdata">
                    <?php echo $_SESSION["Facebook"];  ?>
                </div>
            </div>


            <div class="Add_social_handle_button"
                onclick="Set_social_handle_division()">
                Add social handle 
            </div>


        </div>
        
        <div id="Social_handle_insert_information">
            
            <!-- Connected email close option division  -->
            <div class="Connected_email_close">
                <i class="fa-solid fa-xmark"
                    onclick="Social_handle_data_close()"></i>
            </div>

            <!-- Twitter social handle input  -->
            <div class="Social_handle_input">
            
                <i class="fa-brands fa-twitter"></i>
                <input type="text" name="" id="Twitter" 
                class="Social_handle_input_information" placeholder="Enter twitter account">
            
            </div>

            <!-- Facebook social handle input  -->
            <div class="Social_handle_input">

                <i class="fa-brands fa-facebook"></i>
                <input type="text" name="" id="Facebook" 
                class="Social_handle_input_information" placeholder="Enter facebook account">

            </div>

            <!-- Instagram social handle input  -->
            <div class="Social_handle_input">

                <i class="fa-brands fa-instagram"></i>
                <input type="text" name="" id="Instagram" 
                class="Social_handle_input_information" placeholder="Enter instagram account">

            </div>

            <div class="Add_social_handle_button"
                onclick="Set_social_handle_information()">
                Save 
            </div>
        
        </div>

    </div>

    <!-- Social handle information division  -->
    <div id="Social_handle_information_division">
        <div id="Social_handle_data"
            style="width:25%">
            <div class="Connected_email_close" >
                <i class="fa-solid fa-xmark"
                    onclick="Social_handle_close()"></i>
            </div>

            <?php
                if ($_SESSION['Social_handle_status'] == "Not available"){
                    ?>
                    <div class="Social_handle_title">
                        Not available
                    </div>
                    <?php             
                }
                else{

                    ?>
                    <div id="Social_handle_icon_list"
                        style="font-size:1.30rem;
                        margin-top:1rem;">
                        <a href="https://twitter.com/<?php echo $_SESSION['Twitter']; ?>"
                            target="_blank"><i class="fa-brands fa-twitter" 
                            style="color:white; 
                            margin-top:auto; 
                            margin-bottom:auto;
                            margin-left:0.60rem;
                            margin-right:0.60rem;
                            "></i></a>
                        <a href="https://www.instagram.com/<?php echo $_SESSION['Instagram']; ?>"
                            target="_blank"><i class="fa-brands fa-facebook" style="color:white; 
                            margin-top:auto; 
                            margin-bottom:auto;
                            margin-left:0.60rem;
                            margin-right: 0.60rem;"></i></a>
                        <a href="https://www.facebook.com/<?php echo $_SESSION['Facebook']; ?>"
                            target="_blank"><i class="fa-brands fa-instagram" style="color:white; 
                            margin-top:auto; 
                            margin-bottom:auto;
                            margin-left:0.60rem;
                            margin-right: 0.60rem;"></i></a>
                    </div>
                    <?php
                }
            ?>

            

        </div>
    </div>
    
    <div id="Home_division">.
         
        <!-- Slidemenu division  -->
        <div id="Slidemenu">

            <div class="Slidemenu_option">

                <div class="Slidemenu_image" onclick="onMenuClick()">
                    <i class="fa-solid fa-bars fa-2x"></i>
                </div>

            </div>
            <div class="Slidemenu_option">

                <div class="Slidemenu_image" onclick="SetDashboard()">
                    <i class="fa-solid fa-chart-bar fa-2x Slidemenu_email" ></i>
                </div>

            </div>
            <div class="Slidemenu_option" onclick="LoadInbox()">

                <div class="Slidemenu_image">
                    <i class="fa-solid fa-envelope fa-2x Slidemenu_email"></i>
                </div>

            </div>
            <div class="Slidemenu_option">

                <div class="Slidemenu_image" onclick="Setaddemail_division()">
                    <i class="fa-solid fa-plus fa-2x"></i>
                </div>

            </div>
            <div class="Slidemenu_option" onclick="SetFavorite_division()">

                <div class="Slidemenu_image">
                    <i class="fa-solid fa-check fa-2x"></i>
                </div>

            </div>
            
        </div>

        <div id="EmailData">
            
            <!-- Navbar division  -->
            <div id="Navbar">
                  
                <!-- Project name  -->
                <div id="Title_option">
    
                    <div id="Navbar_title">
                        Unified mailing system
                    </div>

                    <div id="Current_email_account_information">
                        <?php echo $_SESSION["Connected_email"] ; ?>
                    </div>
        
                </div>
                
                <!-- Username information  -->
                <div id="Navbar_username">
    
                    <div id="UserImage">
                        <i class="fa-solid fa-user fa-2x"></i>
                    </div>
    
                    <div class="dropdown">
                        <button class="dropbtn"><?php global $Username; echo $Username; ?></button>
                        <div class="dropdown-content">
                          <a href="#" onclick="Set_profile_information()">My profile</a>
                          <a href="#" onclick="Logout()">Logout</a>
                        </div>
                    </div>
    
                </div>
    
            </div>

            <div id="Email_content">

                <!-- Dashboard option  -->
                <div id="Dashboard">
                    
                    <!-- Today email count information  -->
                    <div class="Dashboard_option">
                        <div class="Dashboard_option_title">
                            Total link Account
                        </div>
                        <div class="Dashboard_option_data">
                            <?php global $Connected_email_data; echo count($Connected_email_data);  ?>
                        </div>
                    </div>

                    <div class="Dashboard_option">
                        <div class="Dashboard_option_title">
                            Today notification email
                        </div>
                        <div class="Dashboard_option_data">
                            72
                        </div>
                    </div>
                
                </div>
                
                <!-- Add email input option  -->
                <div id="Add_email_option">

                    <div class="Add_email_title">
                        Link your email account
                    </div>

                    <div class="input-group mb-3 Add_email_input_option" >
                        <span class="input-group-text" id="inputGroup-sizing-default" 
                            style="font-size:0.90rem;">Email address</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default" id="Add_account_email">
                    </div>

                    <div class="input-group mb-3 Add_email_input_option" style="margin-top:3rem;" >
                        <span class="input-group-text" id="inputGroup-sizing-default"
                            style="font-size:0.90rem; ">Password</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default" id="Add_account_password">
                    </div>

                    <button type="button" class="btn btn-info Verify_button" onclick="Add_email_account()"
                        >Verify
                    </button>

                </div>

                <!-- Add email verification option division  -->
                <div id="Add_email_verify_option">
                     
                    <!-- Back button option division  -->
                    <div id="Back_button_option_division">
                        <i class="fa-solid fa-arrow-left"
                        onclick="Add_email_back_option()"></i>
                    </div>

                    <div class="Add_email_title">
                        Verify your email account
                    </div>

                    <div class="input-group mb-3 Add_email_input_option" >
                        <span class="input-group-text" id="inputGroup-sizing-default"
                            style="font-size:0.90rem ; ">Verification code</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default" id="Add_email_code">
                    </div>

                    <button type="button" class="btn btn-info Verify_button" style="font-size:0.90rem; "
                        onclick="Verify_email_address()">Add email</button>

                </div>
                 
                <!-- Favorite email list division  -->
                <div id="Favorite_email_list">

                    <div id="Email_account_list">

                        <div id="Watchlist_title">
                            Connected email account
                        </div>
                         
                        <?php

                            global $Watchlist_main_email ; 
                            global $Connected_email_data ; 
                            global $Watchlist_current_division ; 
                            
                            for($i=0; $i<count($Connected_email_data); $i++){
                                $Watchlist_main_email = $Connected_email_data[$i][0]; 
                                $Watchlist_current_division = $i ; 
                                
                                ?>

                                <div class="Watchlist_main_email_account"
                                    onclick="Set_watchlist_email_division('<?php global $Watchlist_main_email ; echo $Watchlist_main_email ;?>',
                                    '<?php global $Watchlist_current_division; echo $Watchlist_current_division ; ?>',
                                    '<?php global $Connected_email_data; echo count($Connected_email_data); ?>')">
                                    <?php global $Watchlist_main_email ; echo $Watchlist_main_email ; ?>
                                </div>

                                <?php
                            }
                        ?>

                    </div>

                    <div id="Email_account_watchlist">
                        
                        <div id="Email_addition_option_division">
                            <input type="email" name="" id="Addition_email" placeholder="Enter emailaddress">
                            <button id="Add_email_button"
                                onclick="Addition_set_email()">Add email</button>
                        </div>

                        <?php
                            
                            global $Watchlist_email ; 
                            global $Watchlist_set_email ; 
 

                            for($i=0; $i<count($Watchlist_email[$_SESSION["watchlist_main_email"]]); $i++){
                                $Watchlist_set_email = $Watchlist_email[$_SESSION['watchlist_main_email']][$i] ; 
                                ?>
                                <div class="Watchlist_set_email_account">
                                    <i class="fa-solid fa-trash"
                                        onclick="Delete_set_email('<?php global $Watchlist_set_email; echo $Watchlist_set_email; ?>')"></i>
                                    <div class="Watchlist_set_email_data">
                                        <?php global $Watchlist_set_email; echo $Watchlist_set_email ; ?>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>

                </div>
                 
                <!-- Calender selection option division  -->

                <div id="Calender_selection_option">

                    <div id="Calender_title_close">

                        <!-- Close button  -->
                        <div id="Set_date_time_close_option"
                            onclick="Set_date_time_div_close()">
                            <i class="fa-solid fa-xmark" style="color:black;"></i>
                        </div>
    
                        <!-- Title information division  -->
                        <div id="Set_email_date_title_division">
                            Set email notification for particular time period 
                        </div>

                    </div>
                     

                    <div id="Date_input_option_division">
                        
                        <!-- Starting date input division  -->

                        <div class="Start_and_end_date_input">
                    
                            <div class="Start_and_end_date_title">
                                Starting Date 
                            </div>
                            <input type="date" name="" id="Start_date" class="Date_input">
                    
                        </div>
                        
                        <!-- Ending date input division  -->
                        
                        <div class="Start_and_end_date_input" style="border-left:1px solid gray;
                        padding-left:0.80rem;">

                            <div class="Start_and_end_date_title">
                                Ending Date
                            </div>
                            <input type="date" name="" id="End_date" class="Date_input">
                        
                        </div>
                    
                    </div>

                    <!-- Add notification and insert email option division  -->
                    
                    <div id="Email_input_submit_button">

                        <div id="Add_email_and_addition_button">

                            <div id="Add_email_button"
                                onclick="Date_input_option()">
                                Add Notification 
                            </div>

                            <input type="email" name="" id="Notification_email" placeholder="Enter email">
                        
                        </div>
                    
                    </div>
                    
                    <div id="Notification_email_list_division">

                        <?php
                        
                            if(isset($_SESSION['Notification_email_data'])){
                                
                                for($i = 0 ; $i<count($_SESSION["Notification_email_data"]); $i++){
                                    
                                    // Notification email
                                    $Notification_email = $_SESSION["Notification_email_data"][$i]["Notification_email"] ; 
                                    
                                    // Notification email start date 
                                    $Notification_email_start_date = $_SESSION["Notification_email_data"][$i]["Notification_start_date"] ; 
                                    
                                    // Notification email end date 
                                    $Notification_email_end_date = $_SESSION["Notification_email_data"][$i]["Notification_end_date"] ; 
                                    
                                    ?>

                                    <div class="Notification_email_list_data">
                                        
                                        <!-- Notification email delete option  -->
                                        <div class="Notification_email_delete" 
                                            onclick="Delete_notification_email('<?php global $Notification_email; echo $Notification_email ; ?>',
                                            '<?php global $Notification_email_start_date ; echo $Notification_email_start_date; ?>', 
                                            '<?php global $Notification_email_end_date?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                        
                                        <!-- Notification email address information  -->
                                        <div class="Notification_email">
                                            <?php global $Notification_email; echo $Notification_email;?>
                                        </div>
                                        
                                        <!-- Notification start date information  -->
                                        <div class="Notification_email_date">Start: <?php global $Notification_email_start_date; echo $Notification_email_start_date; ?></div>
                                    
                                        <!-- Notification email end date information  -->
                                        <div class="Notification_email_date">End : <?php global $Notification_email_end_date; echo $Notification_email_end_date; ?></div>
                                    
                                    </div>

                                    <?php
                                }  
                            }
                        ?>


                    </div>

                </div>

                <div id="Email_list_division">
                     
                    <!-- All option list  -->
                    
                    <div id="All_email_option_division">
                        
                        <!-- Refresh inbox option  -->
                        <div class="All_email_option" onclick="Refresh_Inbox(0)">
                            <i class="fa-sharp fa-solid fa-arrows-rotate"></i>
                            Refresh Inbox 
                        </div>

                        <!-- Connected email account list option  -->
                        <div class="All_email_option" onclick="SetConnected_email_division(1)"  >
                            <i class="fa-solid fa-link"></i>
                                Email account
                        </div>
                       
                        <!-- Reminder email option  -->
                        <div class="All_email_option" onclick="Set_reminder_email_option(2)">
                            <i class="fa-solid fa-bell"></i>
                            Reminder emails 
                        </div>

                        <!-- Recent email option  -->
                        <div class="All_email_option" onclick="Most_recent_email_option(3)">
                            <i class="fa-solid fa-clock"></i>     
                            Recent emails 
                        </div>
                        
                        <!-- Set date wise notification option  -->
                        <div class="All_email_option" onclick="Set_date_wise_alert_division(4)">
                        <i class="fa-solid fa-calendar-days"></i>   
                            Set date wise alert
                        </div>

                        <!-- Check date wise email notification  -->
                        <div class="All_email_option" onclick="Set_date_wise_email_list_function(5)">
                        <i class="fa-solid fa-calendar-days"></i>   
                            Check date wise alert 
                        </div>

                    </div>

                    <!-- Add to watchlist information division  -->
                    <div class="alert alert-primary Alert" role="alert" id="Alert">
                    </div>

                    <div id="Email_content_division">
                     
                        <!-- Email title and Add watchlist division  -->
                        <div id="Email_content_title_like">
                       
                            <?php
                        
                            global $Open_email_subject ; 
                            global $Open_email_from_value ;
                            global $Open_email_date ; 
                            global $Open_email_data ; 
                            global $Watchlist_email ; 
                            
                            if ($_SESSION["Open_email_option"] == "main"){
                                // Set email data for INBOX emails 

                                // Header 
                                $Open_email_subject =  imap_mime_header_decode($_SESSION["Email"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][0]['subject'] ) ; 
                                $Open_email_subject = json_decode(json_encode($Open_email_subject), true) ; 
                                $Open_email_subject = $Open_email_subject[0]["text"] ;

                                // Email from address
                                $Open_email_from_value = $_SESSION["Email"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][1] ; 
                                
                                // Email coming date information 
                                $Open_email_date = $_SESSION["Email"][$_SESSION["Connected_email"]][$_SESSION['Open_email_value']][0]['date'] ; 
                               
                                if (in_array($Open_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                    $Open_email_set_value = 1 ; 
                                }
                                else{
                                    $Open_email_set_value = 0 ; 
                                }
                            }
                            else if ($_SESSION["Open_email_option"] == "reminder"){
                                 
                                // Set email data for reminder emails 

                                // Header 
                                $Open_email_subject =  imap_mime_header_decode($_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][0]['subject'] ) ; 
                                $Open_email_subject = json_decode(json_encode($Open_email_subject), true) ; 
                                $Open_email_subject = $Open_email_subject[0]["text"] ;

                                // Email from address 
                                $Open_email_from_value = $_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][1] ; 
                              
                                // Email coming date information 
                                $Open_email_date = $_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$_SESSION['Open_email_value']][0]['date'] ; 
                               
                                if (in_array($Open_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                    $Open_email_set_value = 1 ; 
                                }
                                else{
                                    $Open_email_set_value = 0 ; 
                                }
                            }
                            else{

                                // Set email data fro recent emails 

                                // Headers
                                $Open_email_subject =  imap_mime_header_decode($_SESSION["Most_recent"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][0]['subject'] ) ; 
                                $Open_email_subject = json_decode(json_encode($Open_email_subject), true) ; 
                                $Open_email_subject = $Open_email_subject[0]["text"] ;

                                // Email from address
                                $Open_email_from_value = $_SESSION["Most_recent"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][1] ; 

                                // Email coming date information 
                                $Open_email_date = $_SESSION["Most_recent"][$_SESSION["Connected_email"]][$_SESSION['Open_email_value']][0]['date'] ; 
                               
                                if (in_array($Open_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                    $Open_email_set_value = 1 ; 
                                }
                                else{
                                    $Open_email_set_value = 0 ; 
                                }
                            }
                            
                        ?>
                       
                        <div id="Email_content_title_like_div">
                            <?php
                            global $Open_email_set_value ; 

                            if ($Open_email_set_value == 0){
                                
                                ?>
                                <i class="fa-regular fa-star" onclick="Add_to_favorite_option('<?php global $Open_email_set_value; echo $Open_email_set_value;?>', 
                                '<?php global $Open_email_from_value; echo $Open_email_from_value ; ?>')"></i>
                                <?php
                            }
                            else{

                                ?>
                                <i class="fa-solid fa-star" onclick="Add_to_favorite_option('<?php global $Open_email_set_value; echo $Open_email_set_value;?>', 
                                '<?php global $Open_email_from_value; echo $Open_email_from_value ; ?>')"></i>
                                <?php
                            }
                            ?>
                            
                            <!-- Email title information  -->

                            <div id="Email_content_title">
                                Subject - <?php global $Open_email_subject ; echo $Open_email_subject ; ?>
                            </div>

                        </div>
                        
                            <div id="Forward_backward_option">
                                
                                <!-- Email backward option  -->
                                <i class="fa-solid fa-caret-left" onclick="Open_email_previous()"></i>
                                
                                <!-- Email forward option  -->
                                <i class="fa-solid fa-caret-right" onclick="Open_email_next()"></i>
                                
                                <!-- Email close option  -->
                                <i class="fa-solid fa-xmark" onclick="Open_email_close()"></i>

                            </div>
                        
                        </div>
                    
                        <!-- Email from address and Date information division  -->
                        <div id="Email_content_from_and_date_information">
                            
                            <!-- Email from address information  -->
                             
                            <div id="Email_content_from">

                                <div class="Email_content_title_information">
                                    FROM : 
                                </div>
                                
                                <div class="Email_content_title_data">
                                    <?php global $Open_email_from_value ; echo $Open_email_from_value ; ?>
                                </div>
                            
                            </div>
                            
                            <!-- Email date information division  -->

                            <div id="Email_content_date">
                            
                                <div class="Email_content_title_information">
                                    DATE : 
                                </div>
                                
                                <div class="Email_content_title_data">
                                    <?php global $Open_email_date ; echo $Open_email_date ;  ?>
                                </div>
                            
                            </div>
                        
                        </div>
                        
                        <!-- Email data information  -->

                        <div id="Email_data"> 
                            <?php
                               
                                if ($_SESSION["Open_email_option"] == "main"){
                                    echo $_SESSION["Email"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][2] ;
                                }
                                else if ($_SESSION["Open_email_option"] == "reminder"){
                                    echo $_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][2] ; 
                                }
                                else{
                                    echo $_SESSION["Most_recent"][$_SESSION["Connected_email"]][$_SESSION["Open_email_value"]][2] ; 
                                }

                            ?>
                        </div>
                
                    </div>
                   
                    <!-- Show inbox load information  -->

                    <div id="Email_list">
                        
                        <?php
                        
                        if (isset($_SESSION["Email"][$_SESSION["Connected_email"]])){
                        
                            global $Email_title ; 
                            global $Email_from_value ; 
                            global $Email_date ; 
                            global $Email_seen_value ; 
                            global $Email_attachment_value ; 
                            global $Email_header_data ; 
                            global $Email_division_value ; 
                            global $Email_set_value ; 
                            global $Watchlist_email ; 
                            global $Email_data ; 

                            $Email_header_data = $_SESSION["Email"][$_SESSION["Connected_email"]] ;
                            $EmailStart = $_SESSION["Email_start"][$_SESSION["Connected_email"]] ; 
                            $EmailEnd = $_SESSION["Email_end"][$_SESSION["Connected_email"]] ; 

                            for($i = $EmailStart; $i<$EmailEnd+1; $i++){
                            
                                $Email_division_value = $i; 

                                // Email title
                                $Email_title =  imap_mime_header_decode($Email_header_data[$i][0]['subject']) ; 
                                $Email_title = json_decode(json_encode($Email_title), true) ; 
                                $Email_title = $Email_title[0]["text"] ; 

                                // Email from value
                                $Email_from_value = $Email_header_data[$i][1] ; 
                             
                                // Email date
                                $Email_date = $Email_header_data[$i][0]["date"] ; 
                             
                                // Email seen value
                                $Email_seen_value = $Email_header_data[$i][0]['seen'] ; 

                                // Email set value 
                                if(in_array($Email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                    $Email_set_value = 1 ; 
                                }
                                else{
                                    $Email_set_value = 0 ; 
                                }

                                ?>  
                                
                                <div class="Email_option_div"  >
                                      
                                    <!-- Email subject and other option division  -->

                                    <div class="Subject_and_option" style="
                                        background-color: <?php 
                                        global $Email_division_value ; 
                                        
                                        if ($Email_division_value %2 == 0){
                                            echo "#5F6F94" ; 
                                        }
                                        else{
                                            echo "#7D6E83" ; 
                                        }
                                        ?> 
                                    ">
                                    
                                        <!-- Email index information  -->

                                        <div class="Email_index" style="background-color:rgb(248, 248, 248)">
                                            <div class="Email_index_data">
                                                <?php global $Email_division_value ; echo $Email_division_value + 1 ; ?>
                                            </div>
                                        </div>
                                    
                                        <!-- Email subject information  -->

                                        <div class="Subject_title_data">
                                            <div class="Subject_title">Subject:</div>
                                            <div class="Subject_data"><?php global $Email_title; echo utf8_decode($Email_title) ; ?></div>
                                        </div>
                                
                                        <!-- Email other option division  -->

                                        <div class="Subject_option">

                                            <!-- Email seen or not information  -->

                                            <i class="fa-solid fa-eye Option" style="color:
                                                <?php
                                                global $Email_seen_value ; 
                                                if ($Email_seen_value == "1"){
                                                    echo "#ffd088"; 
                                                }
                                                else{
                                                    echo "white" ; 
                                                }
                                                ?>">
                                            </i>
                                                    
                                            <!-- Email add to watchlist option  -->

                                            <i class="fa-solid fa-heart Option" style="color: 
                                                <?php
                                                
                                                global $Watchlist_email ; 
                                                global $Email_from_value ; 

                                                if ($Email_set_value == 1){
                                                    echo "#ffd088";
                                                }
                                                else{
                                                    echo "white" ; 
                                                }
                                                ?>" onclick="Add_to_favorite_option('<?php global $Email_set_value ; echo $Email_set_value ; ?>', 
                                                '<?php global $Email_from_value ; echo $Email_from_value ; ?>')">
                                            </i>
                                        
                                            <!-- Email share option  -->
                                            <i class="fa-solid fa-share-nodes"
                                                onclick="Fetch_social_handle_information('<?php global $Email_from_value; echo $Email_from_value; ?>')"></i>
                                        
                                        </div>
                                
                                    </div>
                                
                                    <!-- Email from address and Email date information  -->

                                    <div class="From_and_date_option">
                                    
                                        <!-- Email from address information  -->

                                        <div class="From_option">
                                            <div class="From_date_title">FROM : </div>
                                            <div class="From_date_data"><?php global $Email_from_value; echo $Email_from_value ; ?></div>
                                        </div>
                                        
                                        <!-- Email date information  -->

                                        <div class="Date_option">
                                            <div class="From_date_title">DATE : </div>
                                            <div class="From_date_data"><?php global $Email_date ; echo $Email_date ; ?></div>
                                        </div>
                                    
                                    </div>
                                
                                    <!-- Email content division  -->

                                    <div class="Email_content">
                                
                                        <div class="Email_content_title">
                                            Email information 
                                        </div>
                                
                                        <div class="View_email_option"  onclick="Open_email('<?php global $Email_division_value; echo $Email_division_value ;?>', 
                                                                                'main')">
                                            View Email
                                        </div>
                                    
                                    </div>
                                
                                </div>

                            <?php
                        }

                        ?>

                        <div id="Load_more_opiton_div">
                            
                            <button type="button" class="btn btn-primary Next_pervious_button" onclick="NextButton()">
                                Next
                            </button>
                            
                            <button type="button" class="btn btn-primary Next_pervious_button" onclick="EndButton()">
                                Previous
                            </button>
                        
                        </div>
                         
                        <?php
                        
                        }
                    
                        ?>

                    </div>

                    <!-- Email load animation division  -->
                     
                    <div id="Email_load">

                        <div class="d-flex justify-content-center">
                        
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                        </div>

                    </div>

                    <!-- Reminder email information division  -->

                    <div id="Reminder_email">

                        <!-- Set Watchlist email list  -->

                        <div id="Reminder_email_list">
                            
                            <?php
                                global $Watchlist_email_list ; 

                                for($i=0 ; $i<count($_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]]); $i++){
                                    $Watchlist_email_list = $_SESSION["Watchlist_email_data"][$_SESSION["Connected_email"]][$i] ; 
                                    ?>
                                
                                    <div class="Reminder_email_list_option" onclick="Set_watchlist_email('<?php global $Watchlist_email_list; echo $Watchlist_email_list ; ?>')">
                                        <?php global $Watchlist_email_list ; echo $Watchlist_email_list ; ?>
                                    </div>
                                <?php
                            }
                            ?>
                            
                        </div>

                        <div id="Reminder_email_list_division">
                            <?php
                                
                                if(isset($_SESSION["Most_reminder"][$_SESSION["Connected_email"]])){
                                
                                    global $Reminder_email_title ;
                                    global $Reminder_email_from_value ; 
                                    global $Reminder_email_date; 
                                    global $Reminder_email_seen_value ; 
                                    global $Reminder_email_division_value ; 
                                    global $Reminder_email_set_value ; 
                                    global $Reminder_email_data ; 
                                    global $Watchlist_email ; 
                                    global $Reminder_email_division_color ; 
                                    global $Reminder_email_message ; 
                                    global $Reminder_email_index_value ; 
                                    global $Color_array ; 
    
                                    for($i=0 ; $i<count($_SESSION["Most_reminder"][$_SESSION["Connected_email"]]); $i++){
                                    
                                        $Reminder_email_data = $_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$i] ; 
                                        $Reminder_email_from_value = $Reminder_email_data[1] ; 
                                        $Reminder_email_index_value = $i ; 
        
                                        if ($_SESSION["Current_watchlist_email_option"] == "All"){
         
                                            $Reminder_email_division_value = $Reminder_email_division_value + 1; 

                                            // Email title  
                                            $Reminder_email_title = imap_mime_header_decode($Reminder_email_data[0]["subject"]) ; 
                                            $Reminder_email_title = json_decode(json_encode($Reminder_email_title), true) ; 
                                            $Reminder_email_title = $Reminder_email_title[0]["text"] ;
        
                                            // Email date 
                                            $Reminder_email_date = $Reminder_email_data[0]['date'] ; 
        
                                            // Email seen value 
                                            $Reminder_email_seen_value = $Reminder_email_data[0]['seen'] ; 
        
                                            // Email set value 
                                            if (in_array($Reminder_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                                $Reminder_email_set_value = 1 ; 
                                            }
                                            else{
                                                $Reminder_email_set_value = 0 ; 
                                            }
                                            ?>
            
                                            <?php
                                            
                                            global $Previous_reminder_email_value ; 
                                            global $Reminder_email_from_value ; 
            
                                            // Set Email index division
        
                                            if ($Previous_reminder_email_value != $Reminder_email_from_value){
                                                $Previous_reminder_email_value = $Reminder_email_from_value ; 
                                                ?>
                                                <div class="Date_information_division">
                                                    <?php global $Reminder_email_from_value; echo $Reminder_email_from_value ; ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
            
                                            <div class="Email_option_div" >
                                                 
                                                <!-- Email subject and other option division  -->
        
                                                <div class="Subject_and_option" style="
                                                    background-color: <?php 
                                                    global $Reminder_email_division_value ; 
        
                                                    if ($Reminder_email_division_value %2 == 0){
                                                        echo "#5F6F94" ; 
                                                    }
                                                    else{
                                                        echo "#7D6E83" ; 
                                                    }
                                                    ?> 
                                                    ">

                                                    <!-- Email index information  -->

                                                    <div class="Email_index" style="background-color:rgb(248, 248, 248)">
                                                        <div class="Email_index_data">
                                                            <?php global $Reminder_email_division_value ; echo $Reminder_email_division_value + 1 ; ?>
                                                        </div>
                                                    </div>

                                        
                                                    <!-- Email subject information  -->
                                         
                                                    <div class="Subject_title_data">
                                                        <div class="Subject_title">Subject:</div>
                                                        <div class="Subject_data"><?php global $Reminder_email_title; echo utf8_decode($Reminder_email_title) ; ?></div>
                                                    </div>
                                        
                                                    <!-- Email other option division   -->
        
                                                    <div class="Subject_option">
            
                                                       <!-- Email seen or not option  -->
        
                                                        <i class="fa-solid fa-eye Option" style="color:
                                                            <?php
                                                            global $Reminder_email_seen_value ; 
                                                            if ($Reminder_email_seen_value == "1"){
                                                                echo "#ffd088"; 
                                                            }
                                                            else{
                                                                echo "white" ; 
                                                            }
                                                            ?>">
                                                        </i>
            
                                                        <!-- Email add to watchlist option  -->
        
                                                        <i class="fa-solid fa-heart Option" style="color: 
                                                            <?php
                                                            
                                                            global $Watchlist_email ; 
                                                            global $Reminder_email_set_value ; 
            
                                                            if ($Reminder_email_set_value == 1){
                                                                echo "#ffd088";
                                                            }
                                                            else{
                                                                echo "white" ; 
                                                            }
                                                            ?>" onclick="Add_to_favorite_option('<?php global $Reminder_email_set_value ; echo $Reminder_email_set_value ; ?>', 
                                                            '<?php global $Reminder_email_from_value ; echo $Reminder_email_from_value ; ?>')">
                                                        </i>
                                                        
                                                        <!-- Email share option  -->
        
                                                        <i class="fa-solid fa-share-nodes"></i>
                                                    
                                                    </div>
        
                                                </div>
                                                
                                                <!-- Email from address and date information division  -->
        
                                                <div class="From_and_date_option">
                                        
                                                    <div class="From_option">
                                                        <div class="From_date_title">FROM : </div>
                                                        <div class="From_date_data"><?php global $Reminder_email_from_value; echo $Reminder_email_from_value ; ?></div>
                                                    </div>    
                                               
                                                    <div class="Date_option">
                                                        <div class="From_date_title">DATE : </div>
                                                        <div class="From_date_data"><?php global $Reminder_email_date ; echo $Reminder_email_date ; ?></div>
                                                    </div>
        
                                                </div>
                                                
        
                                                <!-- Email content information division  -->
                                        
                                                <div class="Email_content">
                                        
                                                    <div class="Email_content_title">
                                                        Email information
                                                    </div>
                                
                                                    <div class="View_email_option"  onclick="Open_email('<?php global $Reminder_email_index_value; echo $Reminder_email_index_value; ?>', 
                                                                                'reminder')">
                                                        View Email
                                                    </div>
                                    
                                                </div>
        
                                            
                                            </div>
                                        
                                            <?php
                                         
                                        }
                                    
                                        else if ($_SESSION["Current_watchlist_email_option"] == $Reminder_email_from_value){
    
                                            $Reminder_email_division_value = $Reminder_email_division_value + 1; 
                                        
                                            $Reminder_email_data = $_SESSION["Most_reminder"][$_SESSION["Connected_email"]][$i] ; 
        
                                            // Email title  
                                            $Reminder_email_title = imap_mime_header_decode($Reminder_email_data[0]["subject"]) ; 
                                            $Reminder_email_title = json_decode(json_encode($Reminder_email_title), true) ; 
                                            $Reminder_email_title = $Reminder_email_title[0]["text"] ;
        
                                            // Email date 
                                            $Reminder_email_date = $Reminder_email_data[0]['date'] ; 
        
                                            // Email seen value 
                                            $Reminder_email_seen_value = $Reminder_email_data[0]['seen'] ; 
        
                                            // Email set value 
                                            if (in_array($Reminder_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                                $Reminder_email_set_value = 1 ; 
                                            }
                                            else{
                                                $Reminder_email_set_value = 0 ; 
                                            }
                                            ?>
            
                                            <?php
                                            
                                            global $Previous_reminder_email_value ; 
                                            global $Reminder_email_from_value ; 
            
                                            if ($Previous_reminder_email_value != $Reminder_email_from_value){
                                                $Previous_reminder_email_value = $Reminder_email_from_value ; 
                                                ?>
                                                <div class="Date_information_division">
                                                    <?php global $Reminder_email_from_value; echo $Reminder_email_from_value ; ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
            
                                            <div class="Email_option_div" >
                                            
                                                <!-- Email subject and other option division  -->
        
                                                <div class="Subject_and_option" style="
                                                    background-color: <?php 
                                                    global $Reminder_email_division_value ; 
        
                                                    if ($Reminder_email_division_value %2 == 0){
                                                        echo "#6E85B7" ; 
                                                    }
                                                    else{
                                                        echo "#395B64" ; 
                                                    }
                                                    ?> 
                                                "> 
                                                    
                                                    <!-- Email subject information division  -->
                                             
                                                    <div class="Subject_title_data">
                                                        <div class="Subject_title">Subject:</div>
                                                        <div class="Subject_data"><?php global $Reminder_email_title; echo utf8_decode($Reminder_email_title) ; ?></div>
                                                    </div>
        
                                                    <!-- Email other option division  -->
                                            
                                                    <div class="Subject_option">
            
                                                    <i class="fa-solid fa-eye Option" style="color:
                                                        <?php
                                                        global $Reminder_email_seen_value ; 
                                                        if ($Reminder_email_seen_value == "1"){
                                                            echo "#ffd088"; 
                                                        }
                                                        else{
                                                            echo "white" ; 
                                                        }
                                                        ?>">
                                                    </i>
            
                                                    <i class="fa-solid fa-heart Option" style="color: 
                                                        <?php
                                                        
                                                        global $Watchlist_email ; 
                                                        global $Reminder_email_set_value ; 
            
                                                        if ($Reminder_email_set_value == 1){
                                                            echo "#ffd088";
                                                        }
                                                        else{
                                                            echo "white" ; 
                                                        }
                                                        ?>" onclick="Add_to_favorite_option('<?php global $Email_set_value ; echo $Email_set_value ; ?>', 
                                                        '<?php global $Email_from_value ; echo $Email_from_value ; ?>')">
                                                    </i>
                                                    
                                                    <i class="fa-solid fa-share-nodes"></i>
                                                    </div>
                                            
                                                </div>
        
                                                <!-- Email from address and date information  -->
                                            
                                                <div class="From_and_date_option">
                                            
                                                    <div class="From_option">
                                                        <div class="From_date6354757251_title">FROM : </div>
                                                        <div class="From_date_data"><?php global $Reminder_email_from_value; echo $Reminder_email_from_value ; ?></div>
                                                    </div>
                                                    
                                                    <div class="Date_option">
                                                        <div class="From_date_title">DATE : </div>
                                                        <div class="From_date_data"><?php global $Reminder_email_date ; echo $Reminder_email_date ; ?></div>
                                                    </div>
                                                
                                                </div>
        
                                                <!-- Email content information division  -->
                                            
                                                <div class="Email_content">
                                            
                                                    <div class="Email_content_title">
                                                        Email information
                                                    </div>
                                            
                                                    <div class="View_email_option"  onclick="Open_email('<?php global $Reminder_email_index_value; echo $Reminder_email_index_value; ?>', 
                                                                                'reminder')">
                                                        View Email
                                                    </div>
                                                
                                                </div>
                                            
                                            </div>
                                            <?php
                                        }
        
                                        else{}
                                    
                                    }
    
                                }
                             
                            ?>
                        </div>

                    </div>

                    <div id="Date_wise_email">
                        <?php
                            
                            global $Date_wise_email_subject; 
                            global $Date_wise_email_from_value ; 
                            global $Date_wise_email_date ; 
                            global $Date_wise_division_value ; 
                            global $Watchlist_email ; 

                            if (isset($_SESSION["Calender"][$_SESSION["Connected_email"]])){
                             
                                for($i=0; $i<count($_SESSION["Calender"][$_SESSION["Connected_email"]]); $i++){
                                    
                                    // Set email for Date wise email information

                                    $Date_wise_email_subject = imap_mime_header_decode($_SESSION["Calender"][$_SESSION["Connected_email"]][$i][0]['subject']) ; 
                                    $Date_wise_email_subject = json_decode(json_encode($Date_wise_email_subject), true) ; 
                                    $Date_wise_email_subject = $Date_wise_email_subject[0]["text"] ; 

                                    // Email from address 
                                    $Date_wise_email_from_value = $_SESSION['Calender'][$_SESSION["Connected_email"]][$i][1];

                                    // Email coming date information 
                                    $Date_wise_email_date = $_SESSION["Calender"][$_SESSION["Connected_email"]][$i][0]['date'] ; 

                                    // Date wise email seen or not value
                                    $Date_wise_email_seen_value = $_SESSION["Calender"][$_SESSION["Connected_email"]][$i][0]['seen'] ;  


                                    if (in_array($Date_wise_email_from_value, $Watchlist_email[$_SESSION["Connected_email"]])){
                                        $Date_wise_email_set_value = 1 ; 
                                    }
                                    else{
                                        $Date_wise_email_set_value = 0 ; 
                                    }

                                    $Date_wise_division_value = $i ; 

                                    ?>
                                    <div class="Email_option_div"  >
                                      
                                        <!-- Email subject and other option division  -->
  
                                        <div class="Subject_and_option" style="
                                            background-color: <?php 
                                            global $Date_wise_division_value ; 
                                          
                                            if ($Date_wise_division_value %2 == 0){
                                              echo "#5F6F94" ; 
                                            }
                                            else{
                                              echo "#7D6E83" ; 
                                            }
                                           ?> 
                                            ">
                                      
                                            <!-- Email index information  -->
  
                                            <div class="Email_index" style="background-color:rgb(248, 248, 248)">
                                                <div class="Email_index_data">
                                                    <?php global $Date_wise_division_value ; echo $Date_wise_division_value + 1 ; ?>
                                                </div>
                                           </div>
                                      
                                            <!-- Email subject information  -->
  
                                            <div class="Subject_title_data">
                                                <div class="Subject_title">Subject:</div>
                                                <div class="Subject_data"><?php global $Date_wise_email_subject; echo utf8_decode($Date_wise_email_subject) ; ?></div>
                                            </div>
                                  
                                            <!-- Email other option division  -->
  
                                            <div class="Subject_option">
  
                                                <!-- Email seen or not information  -->
  
                                                <i class="fa-solid fa-eye Option" style="color:
                                                    <?php
                                                    global $Date_wise_email_seen_value ; 
                                                    if ($Date_wise_email_seen_value == "1"){
                                                        echo "#ffd088"; 
                                                    }
                                                    else{
                                                        echo "white" ; 
                                                    }
                                                    ?>">
                                                </i>
                                                      
                                                <!-- Email add to watchlist option  -->
  
                                                <i class="fa-solid fa-heart Option" style="color: 
                                                    <?php
                                                    
                                                    global $Date_wise_email_set_value ; 
  
                                                    if ($Date_wise_email_set_value == 1){
                                                        echo "#ffd088";
                                                    }
                                                    else{
                                                        echo "white" ; 
                                                    }
                                                    ?>" onclick="Add_to_favorite_option('<?php global $Email_set_value ; echo $Email_set_value ; ?>', 
                                                    '<?php global $Email_from_value ; echo $Email_from_value ; ?>')">
                                                </i>
                                          
                                                <!-- Email share option  -->
                                                <i class="fa-solid fa-share-nodes"></i>
                                          
                                            </div>
                                  
                                        </div>
                                  
                                        <!-- Email from address and Email date information  -->
  
                                        <div class="From_and_date_option">
                                      
                                            <!-- Email from address information  -->
  
                                            <div class="From_option">
                                                <div class="From_date_title">FROM : </div>
                                                <div class="From_date_data"><?php global$Date_wise_email_from_value; echo$Date_wise_email_from_value ; ?></div>
                                            </div>
                                          
                                            <!-- Email date information  -->
  
                                            <div class="Date_option">
                                                <div class="From_date_title">DATE : </div>
                                                <div class="From_date_data"><?php global $Date_wise_email_date ; echo $Date_wise_email_date ; ?></div>
                                            </div>
                                      
                                        </div>
                                  
                                        <!-- Email content division  -->
  
                                        <div class="Email_content">
                                  
                                            <div class="Email_content_title">
                                                Email information 
                                            </div>
                                  
                                            <div class="View_email_option"  onclick="Open_email('<?php global $Email_division_value; echo $Email_division_value ;?>', 
                                                                                    'main')">
                                                View Email
                                            </div>
                                      
                                        </div>
                                  
                                  </div>
                                    <?php
                                }
                            }

                        ?>
                    </div>
                     
                    <!-- Most recent email information division  -->

                    <div id="Most_recent_email">
   
                        <!-- Unseen mail fro 7 days information title  -->
                        <div id="Unseen_mail_information_title">
                            Unseen emails from 7 days  
                        </div>

                        <?php
                        
                            global $Most_recent_title ; 
                            global $Most_recent_form_value ; 
                            global $Most_recent_date ; 
                            global $Most_recent_seen_value ; 
                            global $Most_recent_division_value ; 
                            global $Most_recent_set_value ; 
                            global $Most_recent_email_data ; 
                            global $Watchlist_email ; 
                            global $Color_array ; 

                            for($i=0; $i<count($_SESSION["Most_recent"][$_SESSION["Connected_email"]]); $i++){
                             
                                $Most_recent_division_value = $i ; 
                                $Most_recent_email_data = $_SESSION["Most_recent"][$_SESSION["Connected_email"]][$i] ; 

                                // Set Recent email division value 
                                $Most_recent_division_color = $Color_array[(($Most_recent_division_value + 1) % 10 )] ; 

                                // Email title 
                                $Most_recent_title = imap_mime_header_decode($Most_recent_email_data[0]['subject']) ; 
                                $Most_recent_title = json_decode(json_encode($Most_recent_title), true) ; 
                                $Most_recent_title = $Most_recent_title[0]['text'] ; 
                                 
                                $Most_recent_form_value = $Most_recent_email_data[0]["from"] ; 

                                $Most_recent_date = $Most_recent_email_data[0]["date"] ; 

                                $Most_recent_seen_value = $Most_recent_email_data[0]['seen'] ; 

                                if(in_array($Most_recent_form_value, $Watchlist_email[$_SESSION["Connected_email"]] )){
                                    $Most_recent_set_value = 1; 
                                }
                                else{
                                    $Most_recent_set_value = 0 ; 
                                }

                                ?>   
                                
                                <!-- Set date title information division  -->

                                <?php
                                global $Most_recent_pervious_date ; 
                                global $Tem_date ;  
                                
                                $Tem_date = $Most_recent_date ; 
                                $Tem_date = strtotime($Tem_date) ; 
                                $Tem_date = date('d/M/Y', $Tem_date);

                                if ($Most_recent_pervious_date != $Tem_date){
                                    $Most_recent_pervious_date = $Tem_date ; 
                                    ?>
                        
                                    <div class="Date_information_division">
                                        <?php global $Tem_date ; echo $Tem_date ; ?>
                                    </div>

                                    <?php
                                }
                                ?>

                                <div class="Email_option_div" >
                                    
                                    <div class="Subject_and_option" style="
                                        background-color: <?php 
                                        global $Most_recent_division_value ; 
    
                                        if ($Most_recent_division_value %2 == 0){
                                            echo "#5F6F94" ; 
                                        }
                                        else{
                                            echo "#7D6E83" ; 
                                        }
                                        ?> 
                                    ">   
                                         
                                        <!-- Email index information  -->

                                        <div class="Email_index" style="background-color:rgb(248, 248, 248); ">
                                            <div class="Email_index_data">
                                                <?php global $Most_recent_division_value ; echo $Most_recent_division_value + 1; ?>
                                            </div>
                                        </div>
                                
                                        <!-- Email subject title information   -->

                                        <div class="Subject_title_data">

                                            <div class="Subject_title">Subject:</div>
                                            <div class="Subject_data"><?php global $Most_recent_title; echo utf8_decode($Most_recent_title) ; ?></div>
                                        
                                        </div>
                                
                                        <!-- Email other option  -->

                                        <div class="Subject_option">
    
                                            <!-- Seen or unseen email option  -->
                                            
                                            <i class="fa-solid fa-eye Option" style="color:
                                                <?php
                                                global $Most_recent_seen_value ; 
                                                if ($Most_recent_seen_value == "1"){
                                                    echo "#ffd088"; 
                                                }
                                                else{
                                                    echo "white" ; 
                                                }
                                                ?>">
                                            </i>

                                            <!-- Email add to watchlist option  -->
    
                                            <i class="fa-solid fa-heart Option" style="color: 
                                                <?php
                                                
                                                global $Watchlist_email ; 
                                                global $Most_recent_set_value ; 
    
                                                if ($Most_recent_set_value == 1){
                                                    echo "#ffd088";
                                                }
                                                else{
                                                    echo "white" ; 
                                                }
                                                ?>" onclick="Add_to_favorite_option('<?php global $Most_recent_set_value; echo $Most_recent_set_value; ?>', 
                                                '<?php global $Most_recent_form_value; echo $Most_recent_form_value;  ?>')">
                                            </i>
                                            
                                            <!-- Email social handle option  -->
                                            <i class="fa-solid fa-share-nodes"></i>
                                        
                                        </div>
                                
                                    </div>
                                
                                    <!-- Email from address and date information  -->

                                    <div class="From_and_date_option">
                                
                                        <!-- Email from address information  -->
                                       
                                        <div class="From_option">

                                            <div class="From_date_title">FROM : </div>
                                            <div class="From_date_data"><?php global $Most_recent_form_value; echo $Most_recent_form_value ; ?></div>
                                        
                                        </div>
                                        
                                        <!-- Email date information  -->
                                        
                                        <div class="Date_option">
                                        
                                            <div class="From_date_title">DATE : </div>
                                            <div class="From_date_data"><?php global $Most_recent_date ; echo $Most_recent_date ; ?></div>
                                        
                                        </div>
                                    
                                    </div>

                                    <!-- Email content information  -->
                                
                                    <div class="Email_content">
                                
                                        <div class="Email_content_title">
                                            Email information
                                        </div>
                                
                                        <div class="View_email_option"  onclick="Open_email('<?php global $Most_recent_division_value; echo $Most_recent_division_value; ?>', 
                                                                        'recent')">
                                            View Email
                                        </div>

                                    </div>
                                
                                </div>

                            <?php
                        }
                        ?>
                    </div>

                </div>

            </div>

        </div>
        
    </div>
</body>
</html>