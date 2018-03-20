<?php

require("header.php");
	
	$sql = "UPDATE auction SET status = 'CANCELED' WHERE id = '{$_GET['id']}'";
	$result = mysqli_query($conn, $sql);
	


header("location:auctionlist.php");


?>
