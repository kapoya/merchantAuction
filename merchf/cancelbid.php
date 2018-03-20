<?php
	require("header.php");
		
		/* find the auction ID */
		$sql = "SELECT auction_ID FROM bid WHERE id = {$_GET['id']}";
		$result = mysqli_query($conn, $sql);
		$fetch = mysqli_fetch_assoc($result);
		$auctionID = $fetch['auction_ID'];
		
		/*find the previous bid of the auction*/
		$sql = "SELECT id FROM bid 
				WHERE auction_ID = {$auctionID} AND status = 'OUTBIDDED'
				ORDER BY date_of_bid DESC
				LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$fetch = mysqli_fetch_assoc($result);
		$prevbidID = $fetch['id'];
		
		if(isset($fetch['id'])){
			/*update highest_bid_id of auction to the previous bid */
			$sql = "UPDATE auction SET highest_bid_id = {$prevbidID} WHERE id = {$auctionID}";
			$result = mysqli_query($conn, $sql);
		
			/* update the previous bid's status to 'WINNING' */
			$sql = "UPDATE bid SET status = 'WINNING' WHERE id = {$prevbidID}";
			$result = mysqli_query($conn, $sql);
		}
		else{
			/*set highest_bid_ID to NULL */
			$sql = "UPDATE auction SET highest_bid_id = NULL WHERE id = {$auctionID}";
			$result = mysqli_query($conn, $sql);
		}
		
		/* update the issued cancel order bid's status to 'CANCELED' */
		$sql = "DELETE FROM bid WHERE id = '{$_GET['id']}'";
		$result = mysqli_query($conn, $sql);
		
		
		
	header("location:bidlist.php");
	
?>
