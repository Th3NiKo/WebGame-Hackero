<?php
	ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);
	ini_set('session.gc-maxlifetime', 60 * 60 * 24 * 365);
	session_start();
	if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)){
		if($_SESSION['isBanned'] == 1){
			echo '<h1 style="color:Red">U ARE BANNED</h1></br> Write to our support if u want to apologize';
			exit();
		} else if($_SESSION['isAdmin'] == 1){
			header('Location: admin.php');
			exit();
		} else {
			header('Location: game.php');
			exit();
		}
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hackero</title>
</head>

<body>
	<h1>HACKERO</h1>

	<form action="login.php" method="post" class="textCenter">
	
		Login</br> <input type="text" name="login"/></br>
		Password</br> <input type="password" name="password"/></br> </br>
		<input type="submit" value="Log in" class="button-error pure-button"/>
	</form>
	</br>

	<?php
		if(isset($_SESSION['Error'])){
			echo $_SESSION['Error'];
			unset($_SESSION['Error']);
		}
		if(isset($_SESSION['registerSucces'])){
		    echo '<p class="textCenter">Account created. U can log in to game now.</p></br>';
		    unset($_SESSION['registerSucces']);
		}
		
	?>
	<div class="textCenter">
	Don't have account? <a href="register.php">REGISTER NOW</a>
	</div>
	</br>
	<div class="textCenter">
	Last update: <a href="changes.html">Check all changes here!</a>
	</div>
	

	
</body>

</html>