<?php
	session_start();
	
	
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	} else if($_SESSION['isBanned'] == 1){
		echo '<h1 style="color:Red">U ARE BANNED</h1></br> Write to our support if u want to apologize';
		exit();
	} else if($_SESSION['isAdmin'] == 0){
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hackero - Admin Panel</title>
</head>

<body>
	<h1>HACKERO ADMIN</h1>
	
	<?php
		 
		echo "<h2>Panel</h2></br>";
		echo "<b>User:</b> ".$_SESSION['login'].' [ <a href="logout.php">Log out</a> ]</br></br>';
			
		echo '<b>Ban player: (by Login)</b> <form action="banUser.php" method="post"><input type="text" name="toBan"/><input type="submit" value="Ban"/> </form>';
		if(isset($_SESSION['banned'])){
			if($_SESSION['banned'] == 1){
				echo '<span style="color:Green">Banning succesfull</span>';
				unset($_SESSION['banned']);
			}
			else {
				echo '<span style="color:Red">Banning unsuccesfull. No user with this login exist</span>';
				unset($_SESSION['banned']);
			}
		}
		
		echo '</br><b>Unban player: (by Login)</b> <form action="unbanUser.php" method="post"><input type="text" name="toUnban"/><input type="submit" value="Unban"/> </form>';
		if(isset($_SESSION['unbanned'])){
			if($_SESSION['unbanned'] == 1){
				echo '<span style="color:Green">Unbanning succesfull</span>';
				unset($_SESSION['unbanned']);
			}
			else {
				echo '<span style="color:Red">Unbanning unsuccesfull. No user with this login exist</span>';
				unset($_SESSION['unbanned']);
			}
		}
	
		echo '<h2>Top 10 Players</h2>';
		require_once "dbconnect.php";
		$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
		if($dbconnect->connect_errno != 0) {
		
			echo "DataBase Error: ".$dbconnect->connect_errno;
			
		} else {
			
			$top10 = "SELECT * FROM users ORDER BY Level DESC LIMIT 10;";
			if($topResult= @$dbconnect->query($top10)) {
				echo '<table style="width: 50%"><tr><td><b>ID</b></td><td><b>Login</b></td><td><b>Level<b/></td><td><b>Money</b></td><td><b>Fame</b></td></tr>';
				while($row = $topResult->fetch_assoc()){
					if($row["isBanned"] == 1){
						echo '<tr style="background:Red">';
					} else {
						echo "<tr>";
					}
					
					echo "<td> " . $row["ID"] . "</td> <td>" . $row["Login"] . " </td> <td> " . $row["Level"] . " </td> <td> " . $row["Money"] . " </td> <td> " .$row["Fame"] . "</br>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo 'Something went wrong with database';
			}
			
		}
		
		
		$dbconnect->close();
		
	?>
	
	
</body>

</html>