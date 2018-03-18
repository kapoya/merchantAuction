<?php

$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");

$sql = "UPDATE auction SET status = 'BUYOUT' WHERE id = '{$_GET['id']}'";
$result = mysqli_query($conn, $sql);

header("location:list.php");
?>