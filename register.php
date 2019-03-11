<?php
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
	
	$good = true;
	require_once "dbconnect.php";
	$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
	if(isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']))
	{
		$login = $_POST['login'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		$login1 = mysqli_real_escape_string($dbconnect, $login);
		$pass1 = mysqli_real_escape_string($dbconnect, $password1);
	
	if ((strlen($login)<3) || (strlen($login)>20)) {
		$good=false;
		$_SESSION['loginError']="Login have to be beetween 3-20 characters!";
	}
	
	if (ctype_alnum($login)==false) {
		$good=false;
		$_SESSION['loginError']="Only alphabet and numbers allowed!";
	}
	
	if ((strlen($password1)<6) || (strlen($password1)>20)) {
		$good=false;
		$_SESSION['passwordError']="Password have to be between 6-20 characters!</br>";
	}
		
	if ($password1!=$password2) {
		$good=false;
		$_SESSION['passwordError']="Your passwords are not the same!</br>";
	}
	
	$_SESSION['registerLogin'] = $login;
	$_SESSION['registerPassword1'] = $password1;
	$_SESSION['registerPassword2'] = $password2;
	$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
	
	
	if($dbconnect->connect_errno != 0) {
		
			echo "DataBase Error: ".$dbconnect->connect_errno;
			exit();
			
	} else {
		//check login in use
		$result = $dbconnect->query("SELECT id FROM users WHERE Login='$login'");
				
		if (!$result) $_SESSION['error'] = "Query error (register 1010). Please contact with administrator.";
				
		$howManyLogins = $result->num_rows;
		if($howManyLogins>0) {
			$good=false;
			$_SESSION['loginError']="Login is un use. Use diffrent one.";
		}
		
		if ($good==true) {
			//add to database
			
			
			if ($dbconnect->query("INSERT INTO users VALUES (NULL, '$login1', '$pass_hash', 1, 1, 1, 1, 1, 0, 0, 0,'2017-10-10', 0)")) {
				$_SESSION['registerSucces']=true;
				header('Location: index.php');
			}
			else {
				$_SESSION['error'] = "Query error (register 9999). Please contact with administrator.";
			}
					
		}
		
		
		$result->close();
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
	<form method="post" action="register.php" class="textCenter">
	
		Login</br> <input type="text" name="login" value="<?php
			if (isset($_SESSION['registerLogin']))
			{
				echo $_SESSION['registerLogin'];
				unset($_SESSION['registerLogin']);
			}
		?>"/></br>

		<?php
			if (isset($_SESSION['loginError'])) {
				echo '</br><div class="error">'.$_SESSION['loginError'].'</div></br>';
				unset($_SESSION['loginError']);
			}
		?>

		Password</br> <input type="password" name="password1" value="<?php
			if (isset($_SESSION['registerPassword1']))
			{
				echo $_SESSION['registerPassword1'];
				unset($_SESSION['registerPassword1']);
			}
		?>"/></br>
		
		Repeat password</br> <input type="password" name="password2" value="<?php
			if (isset($_SESSION['registerPassword2']))
			{
				echo $_SESSION['registerPassword2'];
				unset($_SESSION['registerPassword2']);
			}
		?>"/></br></br>
		
		<?php
			if (isset($_SESSION['passwordError']))
			{
				echo '<div class="error">'.$_SESSION['passwordError'].'</div></br>';
				unset($_SESSION['passwordError']);
			}
		?>		
		
		
		<input type="submit" value="Sign up" class="button-error pure-button"/>
		
	</form>
	</br>
	<div class="textCenter">
	Already have your account? <a href="index.php">LOGIN NOW</a>
	</div>
	
	<span> <?php if(isset($_SESSION['error']))echo $_SESSION['error']; unset($_SESSION['error']); ?> </span>
	
</body>

</html>