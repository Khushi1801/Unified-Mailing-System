<?php

# ... sql connection ... # 

$servername = "localhost";

$username = "root";

$password = "";

$Database = "emailalert" ; 

// ... setup connection ... //

$conn = new mysqli($servername, $username, $password , $Database);

// ... check connectivity ... //  

if ($conn->connect_error) {

  die("Connection failed: " . $conn->connect_error);

}

?>