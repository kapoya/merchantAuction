<?php

require("header.php");

if($_POST){ /* no search keyword used */
	$query = "SELECT auction.ID, name, fname, lname, image, amt, buyout, highest_bid_ID, starting_bid FROM auction 
	          JOIN auction_item ON auction.item_ID = auction_item.ID LEFT JOIN bid on auction.highest_bid_ID = bid.ID 
			  JOIN user ON auction_item.seller_ID = user.ID WHERE auction.status ='PENDING' AND (name LIKE '%{$_POST['keyword']}%' OR 
			  fname LIKE '%{$_POST['keyword']}%' OR lname LIKE '%{$_POST['keyword']}%' OR amt LIKE '%{$_POST['keyword']}%' OR buyout LIKE '%{$_POST['keyword']}%')";
	$result = mysqli_query($conn, $query);
}

else{
	$query = "SELECT auction.ID, name, fname, lname, image, amt, buyout, highest_bid_ID, starting_bid FROM auction 
			  JOIN auction_item ON auction.item_ID = auction_item.ID LEFT JOIN bid on auction.highest_bid_ID = bid.ID 
			  JOIN user ON auction_item.seller_ID = user.ID WHERE auction.status ='PENDING'";
	$result = mysqli_query($conn, $query);
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

<style>

form{
	border: none;
	width : 80%;
}


</style>
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
		<p>Welcome to our unfinished site. lol XD logged in as <?php echo $_SESSION['logged_in']; ?> user.</p> 
	</div>
	
	<ul>
		<li><a class="active">Home</a></li>
		<li><a href="newauction.php">Start New Auction</a></li>
		<li><a href="auctionlist.php">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
		<?php
		if($_SESSION['logged_in'] == "admin"){
			echo "<li style='float:right;'><a href='admin.php'>Admin Stuff</a></li>";
		}
		?>
	</ul>
	
	<form method="POST" action="list.php" >
	<p style="float:right"><input type="text" name="keyword" placeholder="Search keyword"
	<?php 
		if($_POST){
		echo "value='{$_POST['keyword']}'"; 
	}
	?> 
	>
	
	<input type="submit" value="Go!"> 
	<?php if($_POST){echo "<a href='list.php'>Clear</a>";} ?></p> 
	</form>
	
	
	<?php
	echo "<div class='container'>";
	echo "<div class= 'row'>";
	if($row = mysqli_fetch_assoc($result)){
		do{
					echo "<div class='col-sm-3'>";
						echo "<a href='auctioninfo.php?id={$row['ID']}'>";
						if($showimage = $row['image']){
							echo "<img src= '$showimage'  width= '100' height='100'>";
						}
						echo "<p><strong>{$row['name']}</strong> </p>";
						echo "<p> Seller: {$row['fname']} {$row['lname']}</p>";
						if ($row['highest_bid_ID']) {
							echo "<p> Current bid: ₱ {$row['amt']} </p>";
						}else{
							echo "<p> Current bid: ₱ {$row['starting_bid']} </p>";
						}
						echo "<p> Buy Out: ₱ {$row['buyout']} </p>";
						echo "</a>";
					echo "</div>";
		}while($row = mysqli_fetch_assoc($result));
	}
	else{
		echo "<p style='text-align:center; font-size: 35px;'>Well, we don't have any active auctions as of now. 
			  Why don't you <a href='newauction.php' style ='color: #008000;'> start one </a>?</p>";
	}
	echo "</div>";
	echo "</div>";
	?>
	</div>
	

	
</body>
</html>
	