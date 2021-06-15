<?php
//start session
session_start();

//unset all session variables
$_SESSION=array();

//end/destroy session
session_destroy();

//direct to welcome page
header("location:welcome.php");
exit;


?>
