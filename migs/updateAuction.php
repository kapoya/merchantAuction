<?php

require("header.php");

$conn = mysqli_connect("localhost", "root", "", "migs_auction_house");

$target_dir = "images/";
$target_file = $target_dir.basename($_FILES['image']['name']);


if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["image"]["tmp_name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

/*Update the Auction Item */ 

$updateauctionitem = "UPDATE auction JOIN auction_item ON item_ID = auction_item.ID  SET name = '{$_POST['aiName']}', type = '{$_POST['type']}', item_condition = '{$_POST['iCondition']}', buyout = '{$_POST['buyout']}' WHERE auction.ID = '{$_GET['id']}'";
$result = mysqli_query($conn, $updateauctionitem);

$updateauction = "UPDATE auction SET date_deadline = '{$_POST['deadline']}' WHERE auction.ID = '{$_GET['id']}'";
$result = mysqli_query($conn, $updateauction);

if($result){
	header("location:auctionlist.php");
}else{
	echo mysqli_error($conn);
}
?>