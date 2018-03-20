<?php

require("header.php");

$sql = "SELECT * FROM user WHERE id = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
?>



<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="bootstrap/css/custombootstrap.css">

<style>

</style>
</head>
<body>

	<div class="jumbotron">
		<h1>Merchant</h1> 
		<p>Lookin' good, Joker!</p> 
	</div>
	
	<ul>
		<li><a class="active">Edit Profile</a></li>
		<li><a href="profile.php?id=<?php{$_GET['id']}?>">Back</a></li>
	</ul>
	

	<?php
	echo "<form method='POST' action='updateprofile.php?id={$_GET['id']}' enctype='multipart/form-data'>";
	echo "<p><strong>Username: </strong><input type='text' name='username' value ='{$row['username']}' maxlength='50'></p>";
	echo "<p><strong>Phone Number: </strong> <input type='text' name='phone' value='{$row['phone_number']}'</p>";
	echo "<p><strong>Confirm Password: </strong><input type='password' name='password' required></p>";
	if(isset($_SESSION['error1'])){
		echo "<p style='color:red;'>{$_SESSION['error1']} </p>";
		unset($_SESSION['error1']);
	}

	echo "<p>--------------------------------------------------------------------------</p>";
	echo "<p style='text-align:center; font-size: 12px;'>Leave this part blank if you don't want to change your password.</p>";
	echo "<p><strong>New Password: </strong><input type='password' name='newpassword'></p>";
	echo "<p><strong>Confirm New Password: </strong><input type='password' name='newpassword2'></p>";
	if(isset($_SESSION['error2'])){
		echo "<p style='color:red;'>{$_SESSION['error2']} </p>";
		unset($_SESSION['error2']);
	}
	echo "<p>--------------------------------------------------------------------------</p>";
	echo "<p><strong>Profile photo: <input type='file' name='image' id = 'image' value='{$row['profile_photo']}'></p>";
	echo "<p><input type='submit' name='submit' value='Save changes'></p>"

	
	?>

	</form>


	</div>
	

	
</body>
</html>

