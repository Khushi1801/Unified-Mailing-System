<?php

// *** Unset user key cookie *** // 

setcookie("key", "", time() - 3600);

echo "Logout" ; 

?>