<?php

require("header.php");

$sql = "SELECT item_ID FROM auction WHERE id = {$_GET['id']}";
$result = mysqli_query($conn, $sql);
$item = mysqli_fetch_assoc($result);

$sql = "DELETE FROM auction WHERE id = {$_GET['id']}";
$result = mysqli_query($conn, $sql);

$sql = "DELETE FROM auction_item WHERE id = {$item['item_ID']}";
$result = mysqli_query($conn, $sql);

header("location:auctionlist.php");
?>