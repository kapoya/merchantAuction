<?php


$conn = mysqli_connect("localhost","root","","migs_auction_house");

if(!$conn){
	$error = "Failed to connect to mysql/db!";
}

if(isset($_POST['username']) && isset($_POST['password'])) {
	session_start();
	if($_POST['password']== $_POST['password2']){
		
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$number = $_POST['number'];
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];

		if($password == $password2){
			$sql = "INSERT INTO user (lname, fname, username, password, email_address, phone_number)
					VALUES ('{$lname}', '{$fname}', '{$username}', '{$password}', '{$email}', '{$number}')";
			$result = mysqli_query($conn, $sql);
			$_SESSION['message'] = "Logged in success";
			$_SESSION['username'] = $username;
			header('location: login.php');
		}else{
			$_SESSION['message'] = "The two password didnt match.";
		}

	}
}


?>


<html>
<head>
<style>
.registerform{
	width:40%;
	margin:100 auto;
	border: 1px solid black;
	text-align:center;
}
</style>
</head>
<body>
<div class='registerform'>
<form method="POST" action="signup.php" enctype="multi-part/form-data" autocomplete="off">
<h1>Want the hottest bids right now?</h1>
<h3>Join Merchant today.</h3>
<?php
if(isset($error)){
	echo "<p style='color:red;'> {$error} </p>";
}
?>
<p><input type='text' name='fname' placeholder='Given Name' required></p>
<p><input type='text' name='lname' placeholder='Last Name' required></p>
<p><input type='text' name='username' placeholder='Username' required></p>
<p><input type='text' name='email' placeholder='E-mail Address' required></p>
<p><input type='password' name='password' placeholder='Password' required></p>
<p><input type='password' name='password2' placeholder='Confirm Password' required></p>
<p><input type="number" name="number" placeholder="Phone Number" required> </p>
<button type='submit'>Get started</button>
Have an account?<a href="login.php">Log in</a>
</form>
</div>
</body>
</html>