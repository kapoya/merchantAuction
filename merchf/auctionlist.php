<?php
require("header.php");


if(!$_POST){ /* no search keyword used */
	$query = "SELECT auction.ID, name, date_started, date_deadline, number_of_biddings, amt, buyout, auction.status, highest_bid_ID, item_ID 
			FROM auction 
			JOIN auction_item ON item_ID = auction_item.ID LEFT JOIN bid ON highest_bid_ID = bid.ID 
			WHERE auction_item.seller_ID = '{$_SESSION['id']}' AND auction.status != 'REAUCTIONED'
			ORDER BY date_deadline DESC
			";
}


else{ /* with search keyword used */
	$query = "SELECT auction.ID, name, date_started, date_deadline, number_of_biddings, amt, buyout, auction.status, highest_bid_ID, item_ID 
			FROM auction 
			JOIN auction_item ON item_ID = auction_item.ID LEFT JOIN bid ON highest_bid_ID = bid.ID WHERE auction_item.seller_ID = '{$_SESSION['id']}' 
		    AND (name LIKE '%{$_POST['keyword']}%' OR date_deadline LIKE '%{$_POST['keyword']}%' OR  date_started LIKE '%{$_POST['keyword']}%'
			OR auction.ID LIKE '%{$_POST['keyword']}%' OR number_of_biddings LIKE '%{$_POST['keyword']}%' OR amt LIKE '%{$_POST['keyword']}%'
			OR buyout LIKE '%{$_POST['keyword']}%') ORDER BY date_deadline DESC";
}


$result = mysqli_query($conn, $query);


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

.jumbotron{
	padding: 1rem 1rem;
	border-radius: 0px 0px;
	margin-bottom: 0;
	color: #008000;
	background-color: #003300;
}

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
	width: 80%;
	border: none;
}

a{
	color: black;
	text-decoration: none;
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
		<p>Here are your auctions. Keep'em coming.</p> 
	</div>
	
	<ul>
		<li><a href="list.php">Home</a></li>
		<li><a href="newauction.php">Start New Auction</a></li>
		<li><a class="active">My Auctions</a></li>
		<li><a href="bidlist.php">My Bids</a></li>
	</ul>
	
	<form method="POST" action="auctionlist.php">
	<p style="float:right"><input type="text" name="keyword" placeholder="Search keyword" 
	<?php 
		if($_POST){
		echo "value='{$_POST['keyword']}'"; 
	}
	?> 
	> 


	<input type="submit" value="Go!" style="float:right;"> 
	<?php if($_POST){echo "<a href='auctionlist.php'>Clear</a>";} ?></p> 
	</form>


	<table align="center">
	

		
		<tr>
			<th>ID</th>
			<th>Auction Item</th>
			<th>Date Started</th>
			<th>End of Auction</th>
			<th>No. of bids</th>
			<th>Winning bid</th>
			<th>Buyout</th>
			<th>Status</th>
			<th></th>
			<th></th>
		</tr>
	<?php
	while($row = mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<th>{$row['ID']}</th>";
		echo "<th><a href='auctioninfo.php?id={$row['ID']}'>{$row['name']}</a></th>";
		echo "<th>{$row['date_started']}</th>";
		echo "<th>{$row['date_deadline']}</th>";
		echo "<th>{$row['number_of_biddings']}</th>";
		$amt = "<th> ";
			if($row['amt']){
				$amt .="₱{$row['amt']}</th>";
			}else{
				$amt .="No Bid</th>";
			}
		echo $amt;
		echo "<th>₱ {$row['buyout']}</th>";
		echo "<th>{$row['status']}</th>";
		if( $row['status'] == "PENDING"){
			echo "<th> <a href='editauction.php?id={$row['ID']}'> <img src='images/Editing-edit-icon.png' width='22' height='22'> </a> </th>";
			echo "<th> <a href='cancelauction.php?id={$row['ID']}'> <img src='images/cancel_icon.png' width='22' height='22'> </a> </th>"; 
		}
		
		elseif( ($row['status'] == 'CONCLUDED' && $row['highest_bid_ID'] == NULL) || $row['status'] == 'CANCELED'){
			echo "<th><a href='reauction.php?id={$row['ID']}'> <img src='images/reauction.png' width='22' height='22'> </a> </th>";
			echo "<th><a href='deleteauction.php?id={$row['ID']}'> <img src='images/delete.png' width='22' height='22'> </a> </th>";
		}
		else{
			echo "<th></th>";
			echo "<th></th>";
		}
		echo "</tr>";
	}
	?>
	</table>



</body>
</html>