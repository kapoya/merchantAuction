<?php

session_start();

$conn = mysqli_connect("localhost","root","","migs_auction_house");

if(!$conn){
	$error = "Failed to connect to mysql/db!";
}

$query = "SELECT username, password, type, ID FROM user";
$result = mysqli_query($conn, $query);

if(!$result){
	echo mysqli_error($conn);
	exit();
}

if(isset($_POST['username']) && isset($_POST['password'])){
	while($row = mysqli_fetch_assoc($result)){
			if($_POST['username'] == $row['username'] && $_POST['password'] == $row['password']){
				if($row['type'] == "admin"){
					$_SESSION['logged_in'] = "admin";
				}
				else{
					$_SESSION['logged_in'] = "normal";
				}
				$_SESSION['user'] = $row['username'];
				$_SESSION['id'] = $row['ID'];
				header("location:list.php");
			}
	}
	if(!$row = mysqli_fetch_assoc($result)){
		$_SESSION['error'] = "Invalid username/password";
	}
}

?>
<html>
<head>


<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

<style>
.jumbotron{
	padding: 1rem 1rem;
	color: #008000;
	background-color: #003300;
	border-radius: 0px 0px;
}

.loginform{
	width:30%;
	margin:100 auto;
	border: 1px solid black;
	text-align:center;
}
</style>
</head>
<body>

<div class="jumbotron">
		<h1>Merchant</h1> 
		<p>Pleebs out of the way!</p> 
</div>
	
<div class='loginform'>
	<form method="POST" action="login.php">
	
		<h1>Login</h1>
		
		<?php
		if(isset($_SESSION['error'])){
			echo "<p style='color:red;'> {$_SESSION['error']} </p>";
		}
		?>
		<p><strong>Username: </strong><input type='text' name='username'></p>
		<p><strong>Password: </strong><input type='password' name='password'></p>
		<button type='submit'>Login</button>
		<p>No account? Sign up <a href="signup.php">here</a></p>

	</form>
</div>


</body>
</html>