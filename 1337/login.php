<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



session_start();

//check if user is already logged in and redirect to dashboard
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location:dashboard.php");
	exit;

}

require_once "config.php";

$username=$password="";
$username_err=$password_err=$login_err="";


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
		//prepare sql query to check if user exists and autenticate
		$sql="SELECT id, username, password FROM users WHERE username=?";
		if($stmt=$connectdb->prepare($sql)){
			$stmt->bind_param("s",$username);
			if($stmt->execute()){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$stmt->bind_result($id, $username,$hashed_password);
					if($stmt->fetch()){
						//check if password exists too
						if(password_verify($password,$hashed_password)){
							session_start();
							//acknowledge log in
							$_SESSION["loggedin"]=true;
							$_SESSION["id"]=$id;
							$_SESSION["username"]=$username;
							//Redirect to dashboard
							header("location:dashboard.php");
						}
						else{
						    //if creds arent found, give this error
						    $login_err="Invalid username or password.";
						    echo $login_err;
						    }
					}
					else{
						$login_err="User doesn't exist.";
					    echo $login_err;
					    header("location:signup.php");
					    }
				}
				else{
					echo "Oops! Something went wrong. Please try again later.";
					}
			$stmt->close();
		}
	}
	$connectdb->close();
	
}

}
?>




<!DOCTYPE html>
<html>

<head>
<title>Log into 1337h00d</title>
<link rel="stylesheet" href="index.css">
</head>

<body>
<nav>
<a href="signup.php">Sign Up</a>
<a href="extra.php">Extras</a>
<a href="index.php">Home</a>
</nav>

<header>
<h1>Welcome back 1337</h1>
<p>Continue your journey as the best hacker the world will ever know...</p>
</header>

<main>
<div class="login">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label>Username:</label><br>
  <input type="text" class="form-control " name="username" value="<?php echo htmlspecialchars($username); ?>"><br>
  <label>Password:</label><br>
  <input type="password" class="form-control " name="password" value="<?php echo htmlspecialchars($password); ?>"><br><br>
  <input type="submit" value="Submit">

<h2>Dont have an account? Start your 1337 hacker journey <a href="signup.php">here...</a></h2>
</form> 
</div>
</main>


<footer>
<a href="signup.php">Sign Up</a>
<a href="login.php">Login</a>
<a href="dashboard.php">Dashboard</a>
<a href="extra.php">Extras</a>
<a href="index.php">Home</a>
</footer>
</body>

</html>

