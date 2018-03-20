<?php

require("header.php");

$sql = "SELECT * FROM user WHERE id = {$_SESSION['id']}";
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

</head>
<body>

	<div class="jumbotron">
		<div class="dropdown" style="float:right;">
			<?php echo "<button class='dropbtn'><img src= {$row['profile_photo']}  width= '40' height='40' style='float:right;'></button>"; 
			echo "<div class='dropdown-content'>";
				echo "<a href='logout.php'>Logout</a>";
			echo "</div>";
			?>
		</div>
		
		<h1>Merchant</h1> 
		<p>Well, here you are.</p> 
	</div>
	
	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a class="active">Profile</a></li>
	</ul>
	

	<?php
	echo "<div class='info'>";
		echo "<div class='column'>";
				echo "<img src='{$row['profile_photo']}'  width='200' height='200'>";
		echo "</div>";
		echo "<div class='column'>";
				echo "<p> Name: {$row['fname']} {$row['lname']}</p>";
				echo "<p> Email Address: {$row['email_address']}</p>";
				echo "<p> Contact Number: 0{$row['phone_number']}</p>";
				echo "<p> Trust Rating: {$row['trust_rating']}</p>";
		echo "</div>";
		echo "<div class='column'>";
			echo "<form id='bid' method='POST' action='editprofile.php?id={$row['ID']}' enctype='multipart/form-data'>";
				echo "<p><input type='submit' name='submit' value='Edit Profile'></p>";
			echo "</form>";
		echo "</div>";
		echo "</div>";
	echo "</div>";
	?>
	</div>
	

	
</body>
</html>

