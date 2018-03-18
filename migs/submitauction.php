<?php

require("header.php");


$target_dir = "images/";
$target_file = $target_dir.basename($_FILES['image']['name']);


if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["image"]["tmp_name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

/*Upload the Auction Item */ 

$uploaditem = "INSERT INTO `auction_item` (`name`, `seller_ID`, `type`, `item_condition`, `image`) VALUES ('{$_POST['aiName']}', '{$_SESSION['id']}', '{$_POST['type']}', 
			'{$_POST['iCondition']}', '{$target_file}')"; 

$result = mysqli_query($conn, $uploaditem);	

/*Find and get the ID of the newly uploaded Auction Item */

$finditemid = "SELECT id FROM `auction_item` WHERE name = '{$_POST['aiName']}'";

$findresult = mysqli_query($conn, $finditemid);

$newitemid = mysqli_fetch_assoc($findresult);

/*Start the new auction for the new item */

$startauction = "INSERT INTO `auction` (`item_ID`, `date_started`, `date_deadline`, `starting_bid`, `buyout`) VALUES ( '{$newitemid['id']}', CURRENT_TIME(), 
								'{$_POST['deadline']}', '{$_POST['startbid']}', '{$_POST['buyout']}')";

$result = mysqli_query($conn, $startauction);

if($result){
	header("location:list.php");
}else{
	echo mysqli_error($conn);
}
?>