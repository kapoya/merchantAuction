<?php

require("header.php");


if($_POST){ /* If a new bid is issued in the page*/
	
	/* Find and get the ID & amt of the current highest bid */
	$sql = "SELECT bid.id, amt, buyout, starting_bid, bidder_ID FROM auction JOIN bid ON bid.id = auction.highest_bid_ID WHERE auction.id = {$_GET['id']} AND bid.status = 'WINNING'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	
	if(isset($row['id'])){ /* if there's an existing current bid */
		
		/* check if the last bidder is not the same user as the logged in user */
		if($row['bidder_ID'] != $_SESSION['id']){
		
			/*Check if the new bid is greater than the last bid and lesser than the buyout, start the bid sequence*/
			if($row['amt'] < $_POST['bid'] && $row['buyout'] >= $_POST['bid']){
				$sql = "UPDATE bid SET status = 'OUTBIDDED' WHERE id = '{$row['id']}'";
				$result = mysqli_query($conn, $sql);
			
				/* INSERT the new highest bid inputted by user */
				$sql = "INSERT INTO bid (auction_ID, bidder_ID, date_of_bid, amt) VALUES ( '{$_GET['id']}', '{$_SESSION['id']}', CURRENT_TIME(), '{$_POST['bid']}')";
				$result = mysqli_query($conn, $sql);

				/* Find and get the ID of the new highest bid */
				$sql = "SELECT id FROM bid WHERE auction_ID = {$_GET['id']} AND bidder_ID = {$_SESSION['id']} AND status ='WINNING'";
				$result = mysqli_query($conn, $sql);
				$row =  mysqli_fetch_assoc($result);
				$newBidID = $row['id'];

				/* Link the new bid to the auction's highest_bid_id & increment number_of_biddings*/
				$sql = "UPDATE auction SET highest_bid_ID = {$newBidID}, number_of_biddings = number_of_biddings + 1 WHERE auction.ID = {$_GET['id']} AND status = 'PENDING'";
				$result = mysqli_query($conn, $sql);
				
				$message = "You have succesfully bid the auction.";
			}	
			else{
				$error = "You bid must be greater than the Current bid and less than Buyout price.";
			}
		}
		else{
			$error = "You already have a previous bid. you cannot bid again until someone else outbids you.";
		}
	}
	
	
	else{
		$sql = "SELECT starting_bid, buyout FROM auction WHERE id = {$_GET['id']}";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		
		if($row['starting_bid'] < $_POST['bid'] && $row['buyout'] > $_POST['bid']){
			/* INSERT the new highest bid inputted by user */
			$sql = "INSERT INTO bid (auction_ID, bidder_ID, date_of_bid, amt) VALUES ( '{$_GET['id']}', '{$_SESSION['id']}', CURRENT_TIME(), '{$_POST['bid']}')";
			$result = mysqli_query($conn, $sql);

			/* Find and get the ID of the new highest bid */
			$sql = "SELECT id FROM bid WHERE auction_ID = {$_GET['id']} AND bidder_ID = {$_SESSION['id']} AND status ='WINNING'";
			$result = mysqli_query($conn, $sql);
			$row =  mysqli_fetch_assoc($result);
			$newBidID = $row['id'];

			/* Link the new bid to the auction's highest_bid_id & increment number_of_biddings*/
			$sql = "UPDATE auction SET highest_bid_ID = {$newBidID}, number_of_biddings = number_of_biddings + 1 WHERE auction.ID = {$_GET['id']} AND status = 'PENDING'";
			$result = mysqli_query($conn, $sql);
			
			$message = "You have succesfully bid the auction.";
		}
		else{
			$error = "You bid must be greater than the Current bid and less than Buyout price.";
		}
	}
	
}

$sql = "SELECT bid.bidder_ID, user.id, image, name, fname, lname, amt, auction_item.type , auction_item.item_condition, 
		date_deadline, buyout, date_started, auction.highest_bid_ID, auction.starting_bid, auction.status 
		FROM auction 
		JOIN auction_item ON item_ID = auction_item.ID JOIN user on user.ID = seller_ID  LEFT JOIN bid ON bid.ID = highest_bid_ID
		WHERE auction.ID = {$_GET['id']}";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if($row['bidder_ID'] != NULL){

	$findbidder = "SELECT lname, fname, id FROM user WHERE id = {$row['bidder_ID']} ";
	$result = mysqli_query($conn, $findbidder);
	$bidder = mysqli_fetch_assoc($result);
	
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
.jumbotron{
	padding: 1rem 1rem;
	border-radius: 0px 0px;
	margin-bottom: 0;
	color: #008000;
	background-color: #003300;
}

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
	margin-bottom: 0px;
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

.column{
	float: left;
    width: 33%;
    padding: 10px;

}

.info{
	margin:50px;
	border-left: 3px solid green;
    background-color: lightgrey;
}

.info:after {
    content: "";
    display: table;
    clear: both;
}

.column img{
	max-width: 100%;
	max-height: 100%;
	border: 1px solid grey;
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
		<p>The auction's necessary information.</p> 
	</div>
	
	<ul>
		<li><a href="list.php">Back</a></li>
	</ul>
	
	<div class="info">
	<?php
		if(isset($message)){
			echo $message;
		}
		echo "<br>";
		echo "<div class='column'>";
		echo "<img src= '{$row['image']}' width='350' height='350'>";
		echo "</div>";
		echo "<div class='column'>";
		echo "<p> Product Name: {$row['name']} </p>";
		echo "<p> Seller: <a href='profile.php?id={$row['id']}'>{$row['fname']} {$row['lname']}</a></p>";
		if ($row['highest_bid_ID']) {
			echo "<p> Current bid: ₱ {$row['amt']} </p>";
			echo "<p> Bidder: <a href='profile.php?id={$bidder['id']}'> {$bidder['fname']} {$bidder['lname']}</a> </p>";
		}else{
			echo "<p> Starting bid: ₱ {$row['starting_bid']} </p>";
		}
		echo "<p> ";
		echo "<p> Buy Out: ₱ {$row['buyout']}</p>";
		echo "<p> Category: {$row['type']} </p>";
		echo "<p> Item Conditon: {$row['item_condition']} </p>";
		
	?>

		<!-- Display the countdown timer in an element --> 
		Deadline: 	<p id="demo"></p>

		<script>
		

		var date_started = "<?php echo "{$row['date_started']}"; ?>";
		var date_deadline = "<?php echo "{$row['date_deadline']}"; ?>";
		// Set the date we're counting down to
		var countDownDate = new Date(date_deadline).getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get todays date and time
		var now = new Date().getTime();

		// Find the distance between now an the count down date
		var distance = countDownDate - now;

		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Display the result in the element with id="demo"
		document.getElementById("demo").innerHTML = days + "d " + hours + "h "
		+ minutes + "m " + seconds + "s ";

		// If the count down is finished, write some text 
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("demo").innerHTML = "EXPIRED";
			}
		}, 1000);
		</script>
		</div>

	<?php
	if($row['status'] == 'PENDING'){
		echo "<div class='column'>";
		echo "<form id='bid' method='POST' action='auctioninfo.php?id={$_GET['id']}' enctype='multipart/form-data'>"; 
		echo "<p>Bid Amount: <input type='text' name='bid'> <input type='submit' name='submit' value='Place Bid'></p>";
	
		if(isset($error)){
			echo "<p style='color:red'>{$error}</p>";
		}

		echo "</form>";

		echo "<div class='button'>";
			echo "<a href='buyout.php?id={$_GET['id']}'>Buy Out</a>"; 
		echo "</div>";
		echo "<br>";
		if($_SESSION['id'] == $row['id']){
			echo "<div class='button'>";
				echo "<a href='editauction.php?id={$_GET['id']}'>Edit Auction</a>"; 
			echo "</div>";
		}
		echo "</div>";	
	}
	?>
	
	</div>
	
</body>
</html>