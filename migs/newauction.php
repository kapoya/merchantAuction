<?php

require("header.php");


if(!$conn){
	echo mysqli_error($conn);
	exit();
}

?>

<html>
<head>

<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">


<style>


table{
	width: 80%;
	text-align:center;
	border: 1px solid black;
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
    text-decoration: none;
	color: black;
}

/* Change the link color on hover */
li a:hover:not(.active){
    background-color: #555;
    color: white;
	text-decoration: none;
}

form{
	width: 500px;
	margin:50 auto;
	border: 1px solid black;
	text-align:center;
	padding: 10px 10px;
}

</style>
</head>
<body>

	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a class="active">Start New Auction</a></li>
		<li><a href="auctionlist.php">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
		<li style="float:right;"><a href="logout.php">Logout</a></li>
	</ul>


<h3 style="text-align:center">Start a new auction</h3>

<form method="POST" action="submitauction.php" enctype="multipart/form-data">
	<p><strong>Auction Item Name: </strong><input type='text' name='aiName'></p>
	<p><strong>Item Type: </strong><input type='text' name='type'></p>
	<p><strong>Item Condition: </strong><select name="iCondition">
									<option value="Brand New">Brand new</option>
									<option value="Secondhand">Second-hand</option>
									<option value="Defective">Defective</option>
									</select>
	</p>
	<p><strong>Starting bid: </strong><input type='text' name='startbid'></p>
	<p><strong>Buy out price: </strong><input type='text' name='buyout'></p>
	<p><strong>Deadline: <input type="datetime-local" name="deadline">
	<p><strong>Item image: <input type="file" name="image" id = "image"></p> 
	<p><input type="submit" name="submit" value="Create Auction"></p>
</form>

</body>

</html>