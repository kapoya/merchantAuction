<?php

require("header.php");




if(!$_POST){ /* no search keyword used */
	$query = "SELECT bid.ID, name, date_of_bid, amt FROM bid JOIN auction ON bid.auction_ID = auction.ID 
			  JOIN auction_item ON item_ID = auction_item.ID WHERE bidder_ID = '{$_SESSION['id']}' ORDER BY date_of_bid DESC"; 
}


else{  /* with search keyword used */
	$query = "SELECT bid.ID, name, date_of_bid, amt FROM bid JOIN auction ON bid.auction_ID = auction.ID 
			  JOIN auction_item ON item_ID = auction_item.ID WHERE bidder_ID = '{$_SESSION['id']}'
			  AND (bid.ID LIKE '%{$_POST['keyword']}%' OR name LIKE '%{$_POST['keyword']}%' 
			  OR  date_of_bid LIKE '%{$_POST['keyword']}%' OR  amt LIKE '%{$_POST['keyword']}%') ORDER BY date_of_bid DESC"; 	  
}


$result = mysqli_query($conn, $query);


if(!$result){
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
	width: 50%;
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
	width: 75%;
}

</style>
</head>
<body>

	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a href="newauction.php">Start New Auction</a></li>
		<li><a href="auctionlist.php">My Auctions</a></li>
		<li><a class="active">My Bids</a></li>
		<li style="float:right;"><a href="logout.php">Logout</a></li>
	</ul>
	
	<form method="POST" action="bidlist.php" >
	<p style="float:right"><input type="text" name="keyword" placeholder="Search keyword"
	<?php 
		if($_POST){
		echo "value='{$_POST['keyword']}'"; 
	}
	?>
	> 
	
	<input type="submit" value="Go!"> 
	<?php if($_POST){echo "<a href='bidlist.php'>Clear</a>";} ?></p> 
	</form>
	
	<br>
	<br>


	<table align="center">
		<tr>
			<th>ID</th>
			<th>Auction Item</th>
			<th>Date of bid</th>
			<th>Amount</th>
		</tr>
	<?php
	while($row = mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<th>{$row['ID']}</th>";
		echo "<th>{$row['name']}</th>";
		echo "<th>{$row['date_of_bid']}</th>";
		echo "<th>₱ {$row['amt']}</th>";
		echo "</tr>";
	}
	?>
	</table>



</body>
</html>