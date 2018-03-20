<?php

require("header.php");

$sql = "SELECT * FROM auction WHERE ID = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);
$auction = mysqli_fetch_assoc($result);


if(!$result){
	echo mysqli_error($conn);
}
$buyoutprice = $auction['buyout'] - $auction['starting_bid'];
$sql = "INSERT INTO bid (auction_ID, bidder_ID, date_of_bid, amt, status) VALUES ('{$auction['ID']}', '{$_SESSION['id']}', CURRENT_TIME(), '{$buyoutprice['amt']}', 'BUYOUT')";
$result = mysqli_query($conn, $sql);





$sql = "SELECT id FROM bid WHERE amt = '{$auction['buyout']}' AND auction_ID = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);
$newbid = mysqli_fetch_assoc($result);

$sql = "UPDATE auction SET status = 'BUYOUT', highest_bid_ID = {$newbid['id']} WHERE id = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);

header("location:list.php");
?>