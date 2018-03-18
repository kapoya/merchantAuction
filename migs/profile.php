<?php

require("header.php");

$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
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
}

.auctionmenu{
	color: white;
}

.container{
	width: 900px;
}

.jumbotron{
	margin-bottom: 0;
}


.col-sm-3{
	height: 250px;
	width: 180px;
	background-color: tomato;
	color: white;
	padding: 10px;
	text-align: center;
	border: 1px solid white;

}

.col-sm-3 a{
	text-decoration: none;
	color:white;
}

a{
	color: inherit;
    text-decoration: none;
}

a:hover{
	text-decoration: none;
	text-color: none;	
}

.active {
    background-color: white;
    color: tomato;
}


ul {
	background-color: #dddddd;
    list-style-type: none;
    margin: 0;
    padding: 0;
	overflow: hidden;
	margin-bottom: 100px;
}


li{
	float:left;
}

li a {
    display: block;
    padding: 8px 16px;
}

/* Change the link color on hover */
li a:hover:not(.active){
    background-color: #555;
    color: white;
	text-decoration: none;
}


</style>
</head>
<body>

	<div class="jumbotron">
		<h1>Merchant</h1> 
		<p>Welcome to our unfinished site. lol XD</p> 
	</div>
	
	<ul>
		<li><a class="active">Home</a></li>
		<li><a href="newauction.php">Start New Auction</a></li>
		<li><a href="auctionlist.php">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
		<li style="float:right;"><a href="logout.php">Logout</a></li>
		<li style="float:right;"><a href="search.php">Search</a></li>
	</ul>
	

	<?php
	echo "<img src= {$row['profile_photo']}  width= '100' height='100'>";
	echo "<p> Name: {$row['fname']} {$row['lname']}</p>";
	echo "<p> Email Address: {$row['email_address']}</p>";
	echo "<p> Contact Number: {$row['phone_number']}</p>";
	echo "<p> Trust Rating: {$row['trust_rating']}</p>";
	echo "<form method='POST' action='updateProfile.php?id={$row['ID']}' enctype='multipart/form-data'>";
	echo "<p><input type='submit' name='submit' value='Edit Profile'></p>"
	
	?>

	</form>


	</div>
	

	
</body>
</html>

