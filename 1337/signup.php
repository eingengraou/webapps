<?php


session_start();

//check if user is already logged in and redirect to dashboard
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location:dashboard.php");
	exit;

}

//include config file
require_once "config.php";
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//check if request is POST
//first of all define request_method cos apache doesnt allow it but php does
$request_method=strtoupper(getenv("REQUEST_METHOD"));

if($request_method == "POST"){
	//check username field if its empty
	if(empty(trim($_POST["username"]))){
		$username_err="Please enter a username .";
	//check if username exists
	}else{
		$sql="SELECT id FROM users WHERE username =?";
		//if username doesnt exits,start creating acct	
		if($stmt=$connectdb->prepare($sql)){
			$stmt->bind_param("s",$param_username);
			$param_username=trim($_POST["username"]);
			if($stmt->execute()){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$username_err = "This username is already taken.";
				}else{
                    $username = trim($_POST["username"]);
                }   	
			}else{	
				echo "OOps! something went wrong .PLease try again later.";
			}
			$stmt->close();
		}		
	}	
	
	//check password and password length
	if(empty(trim($_POST["password"]))){
		$password_err="Please enter a password.";
	}elseif(strlen(trim($_POST["password"])) < 6){
		$password_err="Password must have at least 6 characters";
	}else{
		$password=trim($_POST["password"]);
	}	
	
	//check confirm password
	if(empty(trim($_POST["confirm_password"]))){
		$confirm_password_err="Please confirm password.";
	}else{
		$confirm_password=trim($_POST["confirm_password"]);
		if(empty($password_err) && ($password !=$confirm_password)){
			$confirm_password_err="Password did not match.";
		}	
    }
	
	
	//check if there were any input errors and send to db
	if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
		$sql="INSERT INTO users (username , password) VALUES (? ,?)";
		if($stmt=$connectdb->prepare($sql)){
			$stmt->bind_param("ss",$param_username,$param_password);
			//set parameters
			$param_username=$username;
			//creates password hash
			$param_password=password_hash($password, PASSWORD_DEFAULT);
			//axctually execute acct creating sql queries
			if($stmt->execute()){
				//if it works, redirect to login page
				header("location:login.php");
			}else{
				echo "Acct creation failed .Please try again later.";
			}
			$stmt->close();
		}
	}
	
	//close mysql connection
	$connectdb->close();
	
}

?>


<!DOCTYPE html>
<html>

<head>
<title>SignUp into 1337h00d</title>
<link rel="stylesheet" href="index.css">
</head>

<body>
<nav>
<a href="login.php">Login</a>
<a href="extra.php">Extras</a>
<a href="index.php">Home</a>
</nav>

<header>
<h1>Sign Up to become 1337</h1>
<p>Start your journey in becoming the best hacker the world will ever know...</p>
</header>

<main>
<div class="signup">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label>Username:</label><br>
  <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username" value="<?php echo htmlspecialchars($username); ?>"><br>
  <label>Password:</label><br>
  <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" value="<?php echo htmlspecialchars($password); ?>"><br>
  <label>Confirm Password:</label><br>
  <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" name="confirm_password"  value="<?php echo htmlspecialchars($confirm_password); ?>"><br><br>
  <input type="submit" value="Submit">
  <input type="reset" value="Reset">
<h2>Already have an account? Continue your 1337 hacker journey <a href="login.php">here...</a></h2>
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
