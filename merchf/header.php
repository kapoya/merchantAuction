<?php
session_start();
if(!isset($_SESSION['logged_in'])){
	$_SESSION['error'] = "You are not logged in!";
	header("location:login.php");
}

$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");

$sql = "UPDATE auction
		SET status = 'CONCLUDED' 
		WHERE date_deadline <= CURRENT_TIME() AND auction.status = 'PENDING'";
		
$result = mysqli_query($conn, $sql);

$sql = "UPDATE bid JOIN auction ON auction.highest_bid_ID = bid.id 
		SET bid.status = 'WON' 
		WHERE date_deadline <= CURRENT_TIME() AND auction.status = 'CONCLUDED'";
		
$result = mysqli_query($conn, $sql);

?>