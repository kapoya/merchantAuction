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
	width: 500px;
	margin:50 auto;
	border: 1px solid black;
	text-align:center;
	padding: 10px 10px;
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
		<p>Edit your auction. Make it look better.</p> 
	</div>
	
	<ul>
		<li><a class="active">Edit Auction</a></li>
		<li><a href="auctionlist.php">Back</a></li>
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