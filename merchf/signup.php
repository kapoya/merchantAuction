<?php

$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");

?>

<html>
<head>

<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="bootstrap/css/custombootstrap.css">
</head>
<body>
	<div class="jumbotron">
		<h1>Merchant</h1> 
		<p>Want to know the hottest bids? Sign up and see for yourself!</p> 
	</div>

<form method="POST" action="submituser.php" enctype="multipart/form-data">
	<p><strong>First Name: </strong><input type='text' name='fname' required></p>
	<p><strong>Last Name: </strong><input type='text' name='lname' required></p>
	<p><strong>Email: </strong><input type='text' name='email' required></p>
	<p style="text-align:center; font-size: 12px; color:red;">Take note that you can't change any of the information above once your account is registered.</p>
	<p><strong>Username: </strong><input type='text' name='username' required></p>
	<p><strong>Password: </strong><input type='password' name='password'></p>
	<p><strong>Confirm Password: </strong><input type='password' name='password2' required></p>
	<p><strong>Phone Number: <input type="number" name="phone" required>
	<p><strong>Profile photo: <input type="file" name="image" id = "image"></p> 
	<p><input type="submit" name="submit" value="Get Started"></p>
</form>

</body>

</html>