<?php

	session_start();
	
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
	} else if($_SESSION['isBanned'] == 1){
		echo '<h1 style="color:Red">U ARE BANNED</h1></br> Write to our support if u want to apologize';
		exit();
	} else if($_SESSION['isAdmin'] == 0){
		header('Location: index.php');
		exit();
	}
	
	
	require_once "dbconnect.php";
	$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
	if($dbconnect->connect_errno != 0) {
		
			echo "DataBase Error: ".$dbconnect->connect_errno;
			exit();
	} else {
		$whoToBan = $_POST['toUnban']; //Nickname 
		$ban = "UPDATE users SET isBanned = 0 WHERE Login='$whoToBan'";
		if($banResult = @$dbconnect->query($ban)) {
			
			$checkUser = "SELECT * FROM users WHERE Login='$whoToBan'";
			if($checkResult = @$dbconnect->query($checkUser)) {
				
				$numberOfUsers = $checkResult->num_rows;
				if($numberOfUsers > 0){
					if($banResult == 1){
						$_SESSION['unbanned'] = 1;
						header("Location: admin.php");
					}
				} else {
					$_SESSION['unbanned'] = 0;
					header("Location: admin.php");
				}
			}
		}
		
		
	}
	$dbconnect->close();



?>