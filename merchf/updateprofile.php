<?php

require("header.php");

$sql = "SELECT password FROM user where id = {$_GET['id']}";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result); 

if(!$conn){
	$error = "Failed to connect to mysql/db!";
}

if($_POST['password'] == $user['password']){
	
	$target_dir = "images/";
	$target_file = $target_dir.basename($_FILES['image']['name']);
	if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["image"]["tmp_name"]). " has been uploaded.";
	}else {
		echo "Sorry, there was an error uploading your file.";
	}
	if($target_file == "images/"){
		unset($target_file);
	}
	$sql = "UPDATE user SET username = '{$_POST['username']}', phone_number = '{$_POST['phone']}',"; 
	
	if(isset($target_file)){ 
		$sql.= "profile_photo = '{$target_file}'";
	}	
	$sql.= "WHERE id = '{$_GET['id']}'";
	$result = mysqli_query($conn, $sql);
	

	if($_POST['newpassword'] && $_POST['newpassword'] == $_POST['newpassword2']){
		$newpass ="UPDATE user SET password = '{$_POST['newpassword']}' WHERE id = '{$_GET['id']}'";
		$result = mysqli_query($conn, $newpass);
		header("location:profile.php");
	}
	elseif(!$_POST['newpassword'] && !$_POST['newpassword2']){
		header("location:profile.php");
	}
	else{
		$_SESSION['error2'] = "passwords do not match";
		header("location:editprofile.php?id={$_GET['id']}");
	}
	

}
else{
	$_SESSION['error1'] = "Incorrect Confirmation Pasword.";
	header("location:editprofile.php?id={$_GET['id']}");
}
?>