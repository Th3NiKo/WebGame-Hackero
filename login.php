<?php 
	ob_start();
	session_start();
	
	if(!isset($_POST['login']) || (!isset($_POST['password']))){
		header('Location: index.php');
		exit();
	}
	
	require_once "dbconnect.php";
	
	$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($dbconnect->connect_errno != 0) {
		
		echo "DataBase Error: ".$dbconnect->connect_errno;
		
	} else {
		
			$login = $_POST['login'];
			$loginSafe = mysqli_real_escape_string($dbconnect, $login);
			$password = $_POST['password'];
			$passwordSafe = mysqli_real_escape_string($dbconnect, $password);
			$checkPass = "SELECT * FROM users WHERE Login='$loginSafe'";
			
			if($checkPassResult = @$dbconnect->query($checkPass)){
			   $userPass = $checkPassResult->fetch_assoc();
			}
			
			if(password_verify($passwordSafe, $userPass['Password']))
			{
				$checkUser = "SELECT * FROM users WHERE Login='$loginSafe'";
				if($checkResult = @$dbconnect->query($checkUser)) {
					
					$numberOfUsers = $checkResult->num_rows;
					if($numberOfUsers > 0){
						
						$_SESSION['logged']=true;
						
						$userData = $checkResult->fetch_assoc();
						$_SESSION['id'] = $userData['ID'];
						$_SESSION['login'] = $userData['Login'];
						$_SESSION['password'] = $userData['Password'];
						$_SESSION['level'] = $userData['Level'];
						$_SESSION['cryptography'] = $userData['Cryptography'];
						$_SESSION['programming'] = $userData['Programming'];
						$_SESSION['psychology'] = $userData['Psychology'];
						$_SESSION['web'] = $userData['Web'];
						$_SESSION['money'] = $userData['Money'];
						$_SESSION['fame'] = $userData['Fame'];
						$_SESSION['isBanned'] = $userData['isBanned'];
						$_SESSION['lastAction'] = $userData['LastAction'];
						$_SESSION['isAdmin'] = $userData['isAdmin'];
						
						unset($_SESSION['Error']);
						$checkResult->close();
						if($_SESSION['isAdmin'] == 0 && $_SESSION['isBanned'] == 0) {
							header('Location: game.php');
						} else if($_SESSION['isAdmin'] == 1){
							header('Location: admin.php');
						} else if($_SESSION['isBanned'] == 1){
							header('Location: index.php');
						}
						
						
					} else {
						
						$_SESSION['Error'] = '<p style="color:red" class="textCenter">There is no hacker with this login and password</p>';
						header('Location: index.php');
						
					}
					
				}
			} else {
				$_SESSION['Error'] ='<p style="color:red" class="textCenter">There is no hacker with this login and password</p>';
				header('Location: index.php');
			}
			
			$dbconnect->close();
		
	}