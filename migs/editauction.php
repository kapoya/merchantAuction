<?php
require("header.php");
$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");
if(!$conn){
	echo mysqli_error($conn);
	exit();
}
$query = "SELECT name, type, item_condition, buyout, date_deadline, image 
			FROM auction JOIN auction_item ON item_ID = auction_item.ID
			WHERE auction.ID = {$_GET['id']}";
$result = mysqli_query($conn, $query);
if(!$result){
	echo mysqli_error($conn);
	exit();
}
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


<h3 style="text-align:center">Edit Auction</h3>

<?php
echo "<form method='POST' action='updateAuction.php?id={$_GET['id']}' enctype='multipart/form-data'>";
	echo "<p><strong>Auction Item Name: </strong><input type='text' name='aiName' value ='{$row['name']}' maxlength='20'></p>";
	echo "<p><strong>Item Type: </strong><input type='text' name='type' value = {$row['type']}></p>";
	echo "<p><strong>Item Condition: </strong><select name='iCondition' value='{$row['item_condition']}'>
									<option value= 'Brand New'>Brand new</option>
									<option value= 'Secondhand'>Second-hand</option>
									<option value= 'Defective'>Defective</option>
									</select>
	</p>";
	echo "<p><strong>Buy out price: </strong><input type='text' name='buyout' value='{$row['buyout']}'></p>";
	echo "<p><strong>Deadline: <input type='datetime' name='deadline' value='{$row['date_deadline']}'></p>";
	echo "<p><strong>Item image: <input type='file' name='image' id = 'image' value ='{$row['image']}'></p>";
	echo "<p><input type= 'submit' name='submit'></p>";
?>

</form>

</body>

</html>