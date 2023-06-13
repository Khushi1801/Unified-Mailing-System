function SetDashboard(){

    $(document).ready(function(){
        $("#Dashboard").show() ; 
        $("#Add_email_option").hide() ; 
        $("#Add_email_verify_option").hide() ; 
        $("#Email_content_division").hide() ; 
        $("#Favorite_email_list").hide() ; 
        $('#Email_list_division').hide() ; 
        $("#Current_email_account_information").hide() ; 
    }); 
}

function Setaddemail_division(){
    $(document).ready(function(){
        $("#Dashboard").hide() ; 
        $("#Add_email_option").show();
        $("#Add_email_verify_option").hide() ; 
        $("#Email_content_division").hide() ; 
        $("#Favorite_email_list").hide() ; 
        $("#Email_list_division").hide() ; 
        $("#Current_email_account_information").hide() ; 
    }); 
}

function SetFavorite_division(){
    $(document).ready(function(){
        $("#Dashboard").hide() ; 
        $("#Add_email_option").hide();
        $("#Add_email_verify_option").hide() ; 
        $("#Email_content_division").hide() ; 
        $("#Email_list_division").hide() ; 
        $("#Current_email_account_information").hide() ; 
        document.getElementById("Favorite_email_list").style.display = "flex" ; 
    }); 
}

function Connected_email_close(){
    $("#Connected_email_account").hide() ; 
}

function SetConnected_email_division(){

    $(document).ready(function(){
        $("#Connected_email_account").css("display", "flex") ; 
        $("#Connected_email").load(location.href+" #Connected_email>*","");
    }) ; 
}

let Email_function_option = 5  ; 

function Set_background_color_to_option_button(m){
    for(let i = 0 ; i<Email_function_option; i++){
        if (i == m){
            document.getElementsByClassName("All_email_option")[i].style.backgroundColor = "#5e9aaa" ; 
        }
        else{
            document.getElementsByClassName("All_email_option")[i].style.backgroundColor = "#395B64" ; 
        }
    }
}

let open_division = null ; 

function LoadInbox(){
    open_division = "list" ; 
    document.getElementById("Dashboard").style.display = "none"; 
    document.getElementById("Add_email_option").style.display = "none" ; 
    document.getElementById("Email_list_division").style.display = "block" ; 

    Set_background_color_to_option_button(10) ; 

    $(document).ready(function(){
        
        $("#Most_recent_email").hide() ; 
        $("#Reminder_email").hide() ; 
        $("#Email_list").hide() ; 
        $("#Email_load").show() ; 
        $("#Favorite_email_list").hide() ; 
        $("#Add_email_verify_option").hide() ;
        $("#Current_email_account_information").show() ; 
        $("#Date_wise_email").hide() ; 

        $.post('./Backend/Load_email_data/Fetch_data.php', {option:"Start"}, function(data){
            if (data == "Complete"){
                $("#Email_list").load(location.href+" #Email_list>*","");
                $("#Email_list").show() ; 
                $("#Email_load").hide() ;
            
            } 
        }); 
    }) ; 

}

function Refresh_Inbox(m){

    Set_background_color_to_option_button(m) ; 

    $(document).ready(function(){
        $("#Email_content_division").hide() ; 
        $("#Reminder_email").hide() ; 
        $("#Most_recent_email").hide() ; 
        $("#Date_wise_email").hide() ; 
        $("#Email_list").show() ; 
        $("#Email_list").load(location.href+" #Email_list>*","");
    }); 
}

function Set_reminder_email_option(m){
    
    Set_background_color_to_option_button(m) ; 

    open_division = "reminder" ; 

    $(document).ready(function(){
        $("#Email_list").hide() ; 
        $("#Most_recent_email").hide() ; 
        $("#Reminder_email").hide() ; 
        $("#Date_wise_email").hide() ; 
        $("#Email_load").show() ; 

        $.post("./Backend/Load_email_data/Fetch_reminder_data.php", {"option":"Reminder"}, function(data){
            if(data == "Insert"){
                $("#Email_load").hide() ; 
                $("#Reminder_email").show() ; 
                $("#Reminder_email").load(location.href+" #Reminder_email>*","");
            }
        }) ;
         
        $.post("./Backend/Add_notification/Send_notification.php", function(data){
        }) ;
         
    }); 
}

function Most_recent_email_option(m){

    Set_background_color_to_option_button(m)  ; 

    open_division = "recent" ; 

    $(document).ready(function(){
        $("#Email_list").hide() ; 
        $("#Most_recent_email").hide() ; 
        $("#Reminder_email").hide() ; 
        $("#Date_wise_email").hide() ; 
        $("#Email_load").show() ; 
        
        $.post("./Backend/Load_email_data/Most_recenet_email.php", {"option":"Most_recent"}, function(data){
            if (data == "Fetch"){
                $("#Email_load").hide() ; 
                $("#Most_recent_email").load(location.href+" #Most_recent_email>*","");
                $("#Most_recent_email").show() ; 
            }
        });

        $.post("./Backend/Add_notification/Recent_email_notification.php", function(data){}); 

    }) ;
}

function NextButton(){

    $(document).ready(function(){

        $("#Email_list").hide() ; 
        $("#Email_load").show() ; 

        $.post('./Backend/Load_email_data/Fetch_data.php', {option:"Next"}, function(data){

            if (data == "Complete"){
                
                $("#Email_list").load(location.href+" #Email_list>*","");
                $("#Email_list").show() ; 
                $("#Email_load").hide() ;
            
            } 
        })
    }) ; 
}

function EndButton(){

    $(document).ready(function(){

        $("#Email_list").hide() ; 
        $("#Email_load").show() ; 

        $.post("./Backend/Load_email_data/Fetch_data.php", {option:"Previous"}, function(data){

            if (data == "Complete"){
                
                $("#Email_list").load(location.href+" #Email_list>*","");
                $("#Email_list").show() ; 
                $("#Email_load").hide() ;
            
            } 
        })
    }) ; 
}

function Add_to_favorite_option(option, emailaddress){
    if (option == 0){

        $(document).ready(function(){
            $.post("./Backend/Remove_add_email_watchlist/Add_to_favourite.php", {"email":emailaddress,"option":option}, function(data){
                if (data == "Update"){
                    
                    $("#Email_list").load(location.href+" #Email_list>*","");
                    $("#Reminder_email").load(location.href+" #Reminder_email>*","");
                    $("#Most_recent_email").load(location.href+" #Most_recent_email>*","");
                    $("#Email_content_division").load(location.href+" #Email_content_division>*","");
                    $(".Alert").show() ; 
                    document.getElementsByClassName("Alert")[0].innerHTML = "Add email to watchlist successfully" ; 
                    
                    setTimeout(function(){ 
                        $(".Alert").hide() ; 
                    }, 
                    3000);
                }
            }) ; 
        }) ; 
    }
    else{

        $(document).ready(function(){
            $.post("./Backend/Remove_add_email_watchlist/Add_to_favourite.php", {"email":emailaddress,"option":option}, function(data){
                if (data == "Update"){
                    
                    $("#Email_list").load(location.href+" #Email_list>*","");
                    $("#Reminder_email").load(location.href+" #Reminder_email>*","");
                    $("#Most_recent_email").load(location.href+" #Most_recent_email>*","");
                    $("#Email_content_division").load(location.href+" #Email_content_division>*","");
                    $(".Alert").show() ; 
                    document.getElementsByClassName("Alert")[0].innerHTML = "Remove email to watchlist successfully" ; 
                    
                    setTimeout(function(){ 
                        $(".Alert").hide() ; 
                    }, 
                    3000);
                }
            }) ; 
        }) ; 

    }
}

function Set_watchlist_email_division(email, current_div, total_div){

    $(document).ready(function(){
        $.post("./Backend/Add_watchlist_email/Set_watchlist_email.php", {"watchlist_main_email":email}, function(data){
            console.log(data); 
            $("#Favorite_email_list").load(location.href+" #Favorite_email_list>*","");
        }) ; 
    }); 

}

function Delete_set_email(email){
    $(document).ready(function(){
        $.post("./Backend/Add_watchlist_email/Delete_watchlist_email.php", {"email":email}, function(data){
            console.log(data); 
            if (data == "Delete"){
                $("#Email_account_watchlist").load(location.href+" #Email_account_watchlist>*","");
            }
        }); 
    }); 
}

function Addition_set_email(){
    let email = document.getElementById("Addition_email").value ; 

    if (email == ""){
        alert("Please, Enter emailaddress") ; 
    }
    else{
        $(document).ready(function(){
            $.post("./Backend/Add_watchlist_email/Add_watchlist_email.php", {"set_email":email}, function(data){
                if (data == "Insert-data"){
                    $("#Email_account_watchlist").load(location.href+" #Email_account_watchlist>*","");
                    $("#Email_addition_option_division").hide() ; 
                }
            }); 
        }) ; 
    }
}

function Set_watchlist_email(email){
    $(document).ready(function(){
        $.post("./Backend/Load_email_data/Set_reminder_email.php", {"email":email}, function(data){
            if (data == "Set"){
                $("#Reminder_email").load(location.href+" #Reminder_email>*","");
            }
        }); 
    }) ; 
}

let User_added_email_address ; 
let User_added_email_account_password ; 

function Add_email_account(){
    let Email_address = document.getElementById("Add_account_email").value ; 
    let Email_password = document.getElementById("Add_account_password").value ;
    
    User_added_email_address = Email_address ; 
    User_added_email_account_password = Email_password ; 

    if (Email_address == ""){
        alert("Please, Enter email address") ; 
    }
    else if (Email_password == ""){
        alert("Please, Enter email account password") ; 
    }
    else{
        $(document).ready(function(){
            $.post("./Backend/Add_email_account/Verify_email.php", {"email":Email_address}, function(data){
                if (data == "Connected"){
                    alert("You already add this email address"); 
                }
                else{
                    document.getElementById("Add_email_option").style.display = "none" ; 
                    document.getElementById("Add_email_verify_option").style.display = "block" ; 
                }
            }); 
        }); 
    }
}

function Verify_email_address(){
    let Verification_code = document.getElementById("Add_email_code").value ; 

    if (Verification_code == ""){
        alert("Please,Enter verification code"); 
    }
    else{
       $(document).ready(function(){
        $.post("./Backend/Add_email_account/Verify_verification_code.php", {"email":User_added_email_address, "password":User_added_email_account_password, "code":Verification_code}, function(data){
            if (data == "Insert"){
                alert("Add email account successfully") ; 
                $("#Add_email_verify_option").hide() ; 
                $("#Add_email_option").show() ; 
                window.location.reload() ; 
            }
            else{
                alert("Invalid verification code") ; 
            }
        }); 
       }); 
    }
}


function Add_email_back_option(){
    document.getElementById("Add_email_verify_option").style.display = "none" ; 
    document.getElementById("Add_email_option").style.display = "block" ; 
}

function Open_email(i_value, option){
    $(document).ready(function(){
        
        $.post("./Backend/Open_email/Open_email_value_set.php", {"i":i_value,"option":option}, function(data){
            if (data == "Update"){
                $("#Email_content_division").show() ; 
                $("#Email_content_division").load(location.href+" #Email_content_division>*","");
            }
        }); 
    }) ; 
}

function Open_email_close(){
    $(document).ready(function(){
        $("#Email_content_division").hide();
        
        if (open_division == "list"){
            $("#Email_list").show() ; 
        }
        else if (open_division == "reminder"){
            $("#Reminder_email").show() ; 
        }
        else if (open_division == "recent"){
            $("#Most_recent_email").show() ; 
        }
        else{
            $("#Date_wise_email").show() ; 
        }
    });
}

function Open_email_next(){
    $(document).ready(function(){
        $.post("./Backend/Open_email/Open_email_increament.php",function(data){
           if (data == "Update"){
            $("#Email_content_division").load(location.href+" #Email_content_division>*","");
           }
        }) ; 
    }); 
}

function Open_email_previous(){
    $(document).ready(function(){
        $.post("./Backend/Open_email/Open_email_decreament.php",function(data){
           if (data == "Update"){
            $("#Email_content_division").load(location.href+" #Email_content_division>*","");
            $("#Email_data").load(location.href+" #Email_data>*","");
           }
        }) ; 
    });
}

function Date_input_option(){
    
    // Starting notification date 
    let start_date = document.getElementById("Start_date").value ; 
    
    // Ending notification date
    let end_date = document.getElementById("End_date").value ; 
    
    // Notification email 
    let notification_email = document.getElementById("Notification_email").value ; 

    // Show alert base on input data  

    if (start_date == ""){
        alert("Please, Enter starting date of email Notification") ; 
    }
    else if (end_date == ""){
        alert("Please, Enter ending date of email Notification") ; 
    }
    else if (notification_email == ""){
        alert("Please, Enter notification email address") ; 
    }
    else{
        $(document).ready(function(){
            $.post('./Backend/Add_notification/Set_notification.php', {"start_date":start_date, "end_date":end_date, "email":notification_email}, function(data){
                
                if (data == "Notification"){
                    alert("Add email notification successfully") ; 
                    
                    $.post("./Backend/Add_notification/Fetch_notification.php", function(data){
                        
                        if (data == "Fetch"){

                            $("#Notification_email_list_division").load(location.href+" #Notification_email_list_division>*","");

                        }

                    }) ; 
                }
                else{
                    alert("Notification end date must be bigger than Notification start date") ; 
                }
            }); 
        }) ; 
    }
}

function Delete_notification_email(email, start_date, end_date ){
  
    $(document).ready(function(){
        $.post('./Backend/Add_notification/Delete_notification.php', {"email":email,"start_date":start_date, "end_date":end_date}, function(data){
            console.log(data) ; 
            if (data == "Delete"){
                alert("Delete notification email successfully") ; 
                $("#Notification_email_list_division").load(location.href+" #Notification_email_list_division>*","");
            }
        }); 
    }); 
}

function Set_date_wise_alert_division(m){

    Set_background_color_to_option_button(m) ;

    $(document).ready(function(){

        $("#Email_list_division").hide() ; 
        $("#Calender_selection_option").show() ; 

        $.post('./Backend/Add_notification/Fetch_notification.php', function(data){
            console.log(data); 
            if (data == "Fetch"){
                $("#Notification_email_list_division").load(location.href+" #Notification_email_list_division>*","");
            }
        }); 
    }); 
}

function Set_date_wise_email_list_function(m){
    
    Set_background_color_to_option_button(m) ; 

    $(document).ready(function(){
        $("#Email_list").hide() ; 
        $("#Reminder_email").hide(); 
        $("#Most_recent_email").hide();
        $("#Date_wise_email").hide();
        $("#Email_load").show() ;  
        $.post("./Backend/Load_email_data/Fetch_date_wise_data.php", function(data){
            if (data == "Fetch"){
                $("#Email_load").hide() ; 
                $("#Date_wise_email").load(location.href+" #Date_wise_email>*","");
                $("#Date_wise_email").show() ; 
            }
        } )
    }); 
}

function Set_date_time_div_close(){
    $(document).ready(function(){
        $("#Email_list_division").show() ; 
        $("#Calender_selection_option").hide() ; 
    }); 
}

function Social_handle_data_close(){
    $(document).ready(function(){
        $("#Social_handle_insert_information").hide(); 
        $("#Profile_information").show() ; 
    }) ; 
}

function Set_social_handle_division(){
    $(document).ready(function(){
        $("#Profile_information").hide() ; 
        $("#Social_handle_insert_information").show() ;
    }); 
}

function Profile_information_close(){
    $(document).ready(function(){
        $("#Profile_information_division").hide() ; 
    }); 
}

function Set_profile_information(){
    document.getElementById("Profile_information_division").style.display = "flex" ; 

}

function Logout(){
    $(document).ready(function(){
       $.post('./Backend/Logout/Logout.php', function(data){
            if (data == "Logout"){
                window.location.href = './Signin.pjp'  ;  
            }
       })
    }); 
}


function Set_social_handle_information(){
    $(document).ready(function(){

        let twitter_username = document.getElementById("Twitter").value ; 
        let facebook_username = document.getElementById("Facebook").value ; 
        let instagram_username = document.getElementById("Instagram").value ; 

        if ((twitter_username == "") && (facebook_username == "") && (instagram_username == "")){
            alert("Please, Enter at least one social handle information") ; 
        }
        else{
            $.post('./Backend/Add_notification/Set_social_handle.php', {'twitter':twitter_username, 'instagram': instagram_username, "facebook": facebook_username}, function(data){
                 
                if (data == "Update"){
                    alert("Update social handle information successfully") ; 
                    $("#Social_handle_insert_information").hide(); 
                    $("#Profile_information").show() ;
                    $("#Profile_information").load(location.href+" #Profile_information>*","");
                }
            }); 
        }
    }); 
}

function Set_primary_key(email){

    $.post('./Backend/Add_email_account/Check_email.php', {'email':email}, function(data){
        window.location.reload() ; 
    })
}

function Fetch_social_handle_information(email){
    $(document).ready(function(){
        $.post("./Backend/Load_email_data/Fetch_social_handle.php", {"email":email}, function(data){
            if (data == "Fetch"){
                $("#Social_handle_information_division").css("display","flex");
                $("#Social_handle_data").load(location.href+" #Social_handle_data>*","");
            }
        }); 
    });
}

function Social_handle_close(){
    document.getElementById("Social_handle_information_division").style.display = "none" ; 
}