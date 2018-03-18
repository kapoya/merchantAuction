<?php
require("header.php");


if(!$_POST){ /* no search keyword used */
	$query = "SELECT auction.ID, name, date_started, date_deadline, number_of_biddings, amt, buyout FROM auction 
			JOIN auction_item ON item_ID = auction_item.ID LEFT JOIN bid ON highest_bid_ID = bid.ID WHERE auction_item.seller_ID = '{$_SESSION['id']}' ORDER BY date_deadline DESC"; 
}


else{ /* with search keyword used */
	$query = "SELECT auction.ID, name, date_started, date_deadline, number_of_biddings, amt, buyout FROM auction 
			JOIN auction_item ON item_ID = auction_item.ID LEFT JOIN bid ON highest_bid_ID = bid.ID WHERE auction_item.seller_ID = '{$_SESSION['id']}'
			AND (name LIKE '%{$_POST['keyword']}%' OR date_deadline LIKE '%{$_POST['keyword']}%' OR  date_started LIKE '%{$_POST['keyword']}%'
			OR auction.ID LIKE '%{$_POST['keyword']}%' OR number_of_biddings LIKE '%{$_POST['keyword']}%' OR amt LIKE '%{$_POST['keyword']}%'
			OR buyout LIKE '%{$_POST['keyword']}%') ORDER BY date_deadline DESC";
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
th{
	padding: 5px;
}

form{
	width: 90%;
}
</style>
</head>
<body>

	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a href="newauction.php">Start New Auction</a></li>
		<li><a class="active">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
		<li style="float:right;"><a href="logout.php">Logout</a></li>
	</ul>
	
	<form method="POST" action="auctionlist.php" >
	<p style="float:right"><input type="text" name="keyword" placeholder="Search keyword" 
	<?php 
		if($_POST){
		echo "value='{$_POST['keyword']}'"; 
	}
	?> 
	> 


	<input type="submit" value="Go!"> 
	<?php if($_POST){echo "<a href='auctionlist.php'>Clear</a>";} ?></p> 
	</form>


	<table align="center">
	

		
		<tr>
			<th>ID</th>
			<th>Auction Item</th>
			<th>Date Started</th>
			<th>Deadline</th>
			<th>No. of bids</th>
			<th>Winning bid</th>
			<th>Buyout</th>
			<th></th>
			<th></th>
		</tr>
	<?php
	while($row = mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<th>{$row['ID']}</th>";
		echo "<th>{$row['name']}</th>";
		echo "<th>{$row['date_started']}</th>";
		echo "<th>{$row['date_deadline']}</th>";
		echo "<th>{$row['number_of_biddings']}</th>";
		$amt = "<th> ";
			if($row['amt']){
				$amt .="₱{$row['amt']}</th>";
			}else{
				$amt .="no bid yet</th>";
			}
		echo $amt;
		echo "<th>₱ {$row['buyout']}</th>";
		echo "<th> <a href='editauction.php?id={$row['ID']}'> <img src='images/Editing-edit-icon.png' width='22' height='22'> </a> </th>"; 
		echo "<th> <a href='deleteauction.php?id={$row['ID']}'> <img src='images/delete.png' width='22' height='22'> </a> </th>"; 
		echo "</tr>";
	}
	?>
	</table>



</body>
</html>