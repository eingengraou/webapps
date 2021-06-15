<?php
//config files for database authentication
define('DB_SERVER' , 'localhost');
define('DB_USERNAME' , 'newuser');
define('DB_PASSWORD' , 'newuser');
define('DB_NAME' , 'l337');

$connectdb=new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//check everything and creds
if($connectdb === false){
	die("ERROR:Could not connect. ");
}
?>
	
