<?php
//start session
session_start();

//check if user is authenticated

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!==true){
	header("location:login.php");
	exit;
}

?>


<!DOCTYPE html>
<html>

<head>
<title>1337</title>
<link rel="stylesheet" href="index.css">
</head>

<body>
<nav>
<a href="logout.php">Logout</a>
<a href="extra.php">Extras</a>
<a href="index.php">Home</a>
</nav>

<header>
<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
<p>Control your hacker journey with this dashboard</p>
</header>

<main>
<div class="dashboard">
 <img src="dipperpines.jpg">
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

