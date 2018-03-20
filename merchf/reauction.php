<?php

require("header.php");

$sql = "UPDATE auction SET status = 'REAUCTIONED' WHERE id ={$_GET['id']}";
$result = mysqli_query($conn, $sql);


$sql = "SELECT * FROM auction WHERE id = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);
$oldauction = mysqli_fetch_assoc($result);

$startauction = "INSERT INTO `auction` ( `item_ID`, `date_started`, `date_deadline`, `starting_bid`, `buyout`, `status`) VALUES ('{$oldauction['item_ID']}', CURRENT_TIMESTAMP() , NOW() + INTERVAL 24 HOUR, '{$oldauction['starting_bid']}', '{$oldauction['buyout']}', 'PENDING')";
$result = mysqli_query($conn, $startauction);
if(!$result){
	echo mysqli_error($conn);
}

header("location:auctionlist.php");

?>