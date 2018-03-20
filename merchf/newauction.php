<?php

require("header.php");


if(!$conn){
	echo mysqli_error($conn);
	exit();
}

$findprofile = "SELECT id, profile_photo FROM user WHERE id = {$_SESSION['id']}";
$profileresult = mysqli_query($conn, $findprofile); 
$profile = mysqli_fetch_assoc($profileresult);
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
			<?php echo "<button class='dropbtn'><img src= {$profile['profile_photo']}  width= '40' height='40' style='float:right;'></button>"; 
			echo "<div class='dropdown-content'>";
				echo "<a href='profile.php?id={$profile['id']}'>View Profile</a>";
				echo "<a href='logout.php'>Logout</a>";
			echo "</div>";
			?>
		</div>
		<h1>Merchant</h1> 
		<p>Start an auction. And give up the goods!</p> 
	</div>
	
	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a class="active">Start New Auction</a></li>
		<li><a href="auctionlist.php">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
	</ul>


<form method="POST" action="submitauction.php" enctype="multipart/form-data">
	<p><strong>Auction Item Name: </strong><input type='text' name='aiName' required></p>
	<p><strong>Item Type: </strong><input type='text' name='type' required></p>
	<p><strong>Item Condition: </strong><select name="iCondition">
									<option value="Brand New">Brand new</option>
									<option value="Secondhand">Second-hand</option>
									<option value="Defective">Defective</option>
									</select>
	</p>
	<p><strong>Starting bid: </strong><input type='text' name='startbid'></p>
	<p><strong>Buy out price: </strong><input type='text' name='buyout' required></p>
	<p><strong>Deadline: <input type="datetime-local" name="deadline" required>
	<p><strong>Item image: <input type="file" name="image" id = "image"></p> 
	<p><input type="submit" name="submit" value="Create Auction"></p>
</form>

</body>

</html>