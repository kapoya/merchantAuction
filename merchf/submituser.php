<?php
session_start();

$conn = mysqli_connect("localhost","root","","migs_auction_house");

if(!$conn){
	$error = "Failed to connect to mysql/db!";
}

if($_POST['password'] == $_POST['password2']){

	$target_dir = "images/";
	$target_file = $target_dir.basename($_FILES['image']['name']);

	if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["image"]["tmp_name"]). " has been uploaded.";
	}else {
		echo "Sorry, there was an error uploading your file.";
	}

	$sql = "INSERT INTO user (lname, fname, username, password, email_address, phone_number, profile_photo)
			VALUES ('{$_POST['lname']}', '{$_POST['fname']}', '{$_POST['username']}', '{$_POST['password']}', 
				'{$_POST['email']}', '{$_POST['phone']}', '{$target_file}')";
				
	$result = mysqli_query($conn, $sql);
	
	header("location:login.php");

}
?>