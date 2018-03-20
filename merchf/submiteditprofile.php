<?php
require("header.php");

$sql = "UPDATE user SET fname = '{$_POST['fname']}', lname = '{$_POST['lname']}', email_address = '{$_POST['email']}', phone_number = '{$_POST['phone']}' WHERE id = '{$_SESSION['id']}'";

$result = mysqli_query($conn, $sql);

if(!$result){
	echo mysqli_error($conn);
}

header("location:profile.php");

?>