<?php
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != "secretpass"){
	$_SESSION['error'] = "You are not logged in!";
	header("location:login.php");
}

$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");


$sql = "UPDATE auction SET status = 'CONCLUDED' WHERE date_deadline <= CURRENT_TIME() AND status != 'BUYOUT';";
$result = mysqli_query($conn, $sql);

?>