<?php

	session_start();
	
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
		$cryptoPrice = $_SESSION['cryptography'] * 2;
		$programmPrice = $_SESSION['programming'] * 2;
		$psychoPrice = $_SESSION['psychology'] * 2;
		$webPrice = $_SESSION['web'] * 2;
		
		if(isset($_POST['cryptoAdd'])){
			if($_SESSION['money'] >= $cryptoPrice) {
				
				$_SESSION['money'] = $_SESSION['money'] - $cryptoPrice;
				$updateMoney = "UPDATE users SET Money=".$_SESSION['money']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateMoney);
				$_SESSION['cryptography'] += 1;
				$updateCrypto = "UPDATE users SET Cryptography=".$_SESSION['cryptography']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateCrypto);
				$_SESSION['level'] += 1;
				$updateLevel = "UPDATE users SET Level=".$_SESSION['level']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateLevel);
		
				$_SESSION['skillSucces'] = '<p style="color:green" class="textCenter">Skill added</p>';
				header("Location: game.php");
				
			} else {
				$_SESSION['noSkillMoney'] = '<p style="color:red" class="textCenter">Not enough money to upgrade this skill </p>';
				header("Location: game.php");
			}
		} else if(isset($_POST['programmAdd'])) {
			if($_SESSION['money'] >= $programmPrice) {
				
				$_SESSION['money'] = $_SESSION['money'] - $programmPrice;
				$updateMoney = "UPDATE users SET Money=".$_SESSION['money']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateMoney);
				$_SESSION['programming'] += 1;
				$updateCrypto = "UPDATE users SET Programming=".$_SESSION['programming']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateCrypto);
				$_SESSION['level'] += 1;
				$updateLevel = "UPDATE users SET Level=".$_SESSION['level']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateLevel);
				
				$_SESSION['skillSucces'] = '<p style="color:green" class="textCenter">Skill added</p>';
				header("Location: game.php");
				
			} else {
				$_SESSION['noSkillMoney'] = '<p style="color:red" class="textCenter">Not enough money to upgrade this skill </p>';
				header("Location: game.php");
			}
		} else if(isset($_POST['psychoAdd'])){
			if($_SESSION['money'] >= $psychoPrice) {
				
				$_SESSION['money'] = $_SESSION['money'] - $psychoPrice;
				$updateMoney = "UPDATE users SET Money=".$_SESSION['money']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateMoney);
				$_SESSION['psychology'] += 1;
				$updateCrypto = "UPDATE users SET Psychology=".$_SESSION['psychology']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateCrypto);
				$_SESSION['level'] += 1;
				$updateLevel = "UPDATE users SET Level=".$_SESSION['level']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateLevel);
				
				$_SESSION['skillSucces'] = '<p style="color:green" class="textCenter">Skill added</p>';
				header("Location: game.php");
				
			} else {
				$_SESSION['noSkillMoney'] = '<p style="color:red" class="textCenter">Not enough money to upgrade this skill </p>';
				header("Location: game.php");
			}
		} else if(isset($_POST['webAdd'])) {
			if($_SESSION['money'] >= $webPrice) {
				
				$_SESSION['money'] = $_SESSION['money'] - $webPrice;
				$updateMoney = "UPDATE users SET Money=".$_SESSION['money']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateMoney);
				$_SESSION['web'] += 1;
				$updateCrypto = "UPDATE users SET Web=".$_SESSION['web']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateCrypto);
				$_SESSION['level'] += 1;
				$updateLevel = "UPDATE users SET Level=".$_SESSION['level']." WHERE ID=".$_SESSION['id'];
				$dbconnect->query($updateLevel);
				
				$_SESSION['skillSucces'] = '<p style="color:green" class="textCenter">Skill added</p>';
				header("Location: game.php");
				
				
			} else {
				$_SESSION['noSkillMoney'] = '<p style="color:red" class="textCenter">Not enough money to upgrade this skill </p>';
				header("Location: game.php");
			}
		}
		
		
	}
	$dbconnect->close();



?>