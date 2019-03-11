<?php

	session_start();
	ob_start();
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
	} else if($_SESSION['isBanned'] == 1){
		echo '<h1 style="color:Red">U ARE BANNED</h1></br> Write to our support if u want to apologize';
		exit();
	} else if($_SESSION['isAdmin'] == 1){
		header('Location: admin.php');
		exit();
	}
	
	
	require_once "dbconnect.php";
	$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
	if($dbconnect->connect_errno != 0) {
		
			echo "DataBase Error: ".$dbconnect->connect_errno;
			exit();
	} else {
		
		$todayDate = date("Y-m-d");
		$userLastQuery = "SELECT LastAction FROM users WHERE ID =".$_SESSION['id'];
		if($userLastResult = $dbconnect->query($userLastQuery)){}
		$userLast = $userLastResult->fetch_assoc();
		
		$userChoice = $_POST['task'];
		$taskChoosenQuery = "SELECT * FROM actions WHERE ID =".$userChoice;
		if($taskChoosenResult = $dbconnect->query($taskChoosenQuery)){}
		$task = $taskChoosenResult->fetch_assoc();
		
		if($userLast['LastAction'] < $todayDate){ 				//Didnt make action today
			if($_SESSION['fame'] >= $task['FameRequired']){ 	//Have enough fame
				$bonusType = $task['Bonus'];
				$moneyUpdate = $task['Money'] + $_SESSION[''.$bonusType];
				$fameUpdate = $task['Fame']   + $_SESSION[''.$bonusType];
				$dbconnect->query("UPDATE users SET LastAction = '".$todayDate."' WHERE ID=".$_SESSION['id']); //Updating date
				$dbconnect->query("UPDATE users SET Money = Money + ".$moneyUpdate." WHERE ID=".$_SESSION['id']); //Updating money
				$dbconnect->query("UPDATE users SET Fame = Fame +".$fameUpdate." WHERE ID=".$_SESSION['id']);  //Updating fame
				$_SESSION['money'] = $_SESSION['money'] + $task['Money'] + $_SESSION[''.$bonusType];
				$_SESSION['fame'] = $_SESSION['fame'] + $task['Fame'] + $_SESSION[''.$bonusType];
				unset($_SESSION['ActionDone']);
				unset($_SESSION['NotEnoughFame']);
				
				$_SESSION['ActionSucces'] = 1;
				header('Location: game.php');
			} else {
				
				$_SESSION['NotEnoughFame'] = 1;
				header("Location: game.php");
			}
		} else {
			
			$_SESSION['ActionDone'] = 1;
			header("Location: game.php");
		}
		
		
	}
	$dbconnect->close();



?>