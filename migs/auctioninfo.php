<?php

require("header.php");




if($_POST){

	$sql = "SELECT bid.id FROM auction JOIN bid ON bid.id = auction.highest_bid_ID WHERE auction.id = {$_GET['id']}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$outbid = $row['id'];
	echo $outbid;

	$sql = "UPDATE bid SET status = 'OUTBIDDED' WHERE id = '{$outbid}'";
	$result = mysqli_query($conn, $sql);


	$sql = "INSERT INTO bid (auction_ID, bidder_ID, date_of_bid, amt) VALUES ( '{$_GET['id']}', '{$_SESSION['id']}', CURRENT_TIME(), '{$_POST['bid']}')";
	$result = mysqli_query($conn, $sql);


	$sql = "SELECT id FROM bid WHERE amt = {$_POST['bid']} AND bidder_ID = {$_SESSION['id']} ";
	$result = mysqli_query($conn, $sql);
	$row =  mysqli_fetch_assoc($result);
	$newBidID = $row['id'];


	$sql = "UPDATE auction SET highest_bid_ID = $newBidID, number_of_biddings = number_of_biddings + 1 WHERE auction.ID = {$_GET['id']} AND status = 'PENDING'";
	$result = mysqli_query($conn, $sql);
	if(!$result){
		echo mysqli_error($conn);
	}
}

$sql = "SELECT image, name, fname, lname, amt, auction_item.type , auction_item.item_condition, date_deadline, buyout, date_started, auction.highest_bid_ID, auction.starting_bid FROM auction JOIN auction_item ON item_ID = auction_item.ID JOIN user on user.ID = seller_ID  LEFT JOIN bid ON bid.ID = highest_bid_ID  WHERE auction.ID = {$_GET['id']} AND auction.status = 'PENDING'";

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

	<?php
		echo "<img src= '{$row['image']}' width='350' height='350'>";
		echo "<p> Product Name: {$row['name']} </p>";
		echo "<p> Seller: {$row['fname']} {$row['lname']}</p>";
		if ($row['highest_bid_ID']) {
			echo "<p> Current bid: ₱ {$row['amt']} </p>";
		}else{
			echo "<p> Current bid: ₱ {$row['starting_bid']} </p>";
		}
		echo "<p> Buy Out: ₱ {$row['buyout']}</p>";
		echo "<p> Category: {$row['type']} </p>";
		echo "<p> Item Conditon: {$row['item_condition']} </p>";
		echo "<p> Deadline: {$row['date_deadline']}</p>";

	?>

<!-- Display the countdown timer in an element --> 
<p id="demo"></p>

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

	<?php echo "<form method='POST' action='auctioninfo.php?id={$_GET['id']}' enctype='multipart/form-data'>"; ?>
	<p>Bid Amount:<input type="text" name="bid"></p>
	<p><input type="submit" name="submit" value="Bid"></p>
	</form>

	<?php echo "<a href='buyout.php?id={$_GET['id']}'>Buy Out</a>"; ?>

</body>
</html>