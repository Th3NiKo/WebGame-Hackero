<?php
	session_start();
	
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	} else if($_SESSION['isBanned'] == 1){
		echo '<h1 style="color:Red">U ARE BANNED</h1></br> Write to our support if u want to apologize';
		exit();
	} else if($_SESSION['isAdmin'] == 1){
		header('Location: admin.php');
		exit();
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="script.js"></script>
	<h1>HACKERO</h1>
	
	<?php
		$cryptoPrice = $_SESSION['cryptography'] * 2;
		$programmPrice = $_SESSION['programming'] * 2;
		$psychoPrice = $_SESSION['psychology'] * 2;
		$webPrice = $_SESSION['web'] * 2;
		echo '<h2 id="personal">Personal data</h2></br>';
		echo '<div id="personalData">';
		echo '<b>User:</b> <text>'.$_SESSION['login'].'</text> [ <a href="logout.php">Log out</a> ]</br>';
		echo "<b>Level:</b> <text>".$_SESSION['level']."</text> </br>";
		echo "<b>Money:</b> <text>".$_SESSION['money']."</text> </br>";
		echo "<b>Fame:</b> <text>".$_SESSION['fame']."</text> </br> </div>";

		echo '<form action="skill.php" method="post">';
		echo '<table>';
		echo "<td><h2>Skills</h2></td>";
		echo '<tr>';
		echo "<td><b>Cryptography:</b> </td><td><text>".$_SESSION['cryptography'].'</text></td><td>  <input type="submit" class= "button-warning pure-button" name="cryptoAdd" value="+"/></td><td>';
		echo " <text2>".$cryptoPrice." money </text2></td></br> ";
		echo '</tr>';
		echo '<tr>';
		echo "<td><b>Programming:</b> </td><td><text>".$_SESSION['programming'].'</text></td><td>  <input type="submit"  class= "button-warning pure-button"name="programmAdd" value="+"/></td><td>';
		echo " <text2>".$programmPrice." money </text2></td></br>";
		echo '</tr>';
		echo '<tr>';
		echo "<td><b>Psychology:</b> </td><td><text>".$_SESSION['psychology'].'</text></td><td>  <input type="submit"  class= "button-warning pure-button"name="psychoAdd" value="+"/></td><td>';
		echo " <text2>".$psychoPrice." money </text2></td></br>";
		echo '</tr>';
		echo '<tr>';
		echo "<td><b>Web:</b> </td><td><text>".$_SESSION['web'].'</text></td><td>  <input type="submit"  class= "button-warning pure-button"name="webAdd" value="+"/></td><td>';
		echo " <text2> ".$webPrice." money </text2><td>";
		echo '</tr>';
		echo '</table> </br> </br>';
		echo "</form>";
		if(isset($_SESSION['noSkillMoney'])) {
			echo '<p style="color:red" class="textCenter">'.$_SESSION['noSkillMoney'].'</p></br>';
			unset($_SESSION['noSkillMoney']);
		} else if(isset($_SESSION['skillSucces'])) {
			echo '<p style="color:green" class="textCenter">'.$_SESSION['skillSucces'].'</p></br>';
			unset($_SESSION['skillSucces']);
		}
		
		
		echo '<h2 class="textCenter">Actions</h2>';
		
	?>
	
	
	<form action="action.php" method="post">
	<?php
	#Automatyzacja wyswietlania akcji
	require_once "dbconnect.php";
	$dbconnect = @new mysqli($host, $db_user, $db_password, $db_name);
	if($dbconnect->connect_errno != 0) {
		
			echo "DataBase Error: ".$dbconnect->connect_errno;
			exit();
	} else {
		$actionsQuery = "SELECT * FROM actions";
		$actionsResult = $dbconnect->query($actionsQuery);
		$actions = $actionsResult->fetch_all(MYSQLI_ASSOC); 
		for($i = 0; $i < count($actions); $i++){ 
			if($i == 0){
				echo '<p class="fame">Fame 0</p>';
				echo '<div class="flex-Container">';
			} else {
				if(json_encode($actions[$i]['FameRequired']) != json_encode($actions[$i - 1]['FameRequired'])) {
					echo '<p class="fame">Fame '.trim(json_encode($actions[$i]['FameRequired']),'"').'</p>';
					echo '<div class="flex-Container">';
				}
			}
				echo '<div class="flex-item">';
				echo '<b style="font-size:1em"><text3>'.trim(json_encode($actions[$i]['Text']),'"').'</text3></b><input type="radio" class="choice" name="task" value="'.$i.'">';
				echo '<p style="font-size:0.8em">Skill bonus: <text>'.trim(json_encode($actions[$i]['Bonus']),'"').'</text></p>';
				echo '<p style="font-size:0.8em">Reward: <text>'.trim(json_encode($actions[$i]['Money']),'"').' money, '.trim(json_encode($actions[$i]['Fame']),'"').' fame </text></p>';
				echo '</div>';
				
				if($i<count($actions) - 1 && (json_encode($actions[$i]['FameRequired']) != json_encode($actions[$i + 1]['FameRequired']))) {
					echo '</div></br>';	
				}

			
			
		}
		
	}
	
	
	?>
	<!--
	<p class="fame">Fame 0</p>
	<div class="flex-Container">
		<div class="flex-item">
			<b style="font-size:1em"><text3>Solve simple ciphers problems on forum</text3></b><input type="radio" name="task" value="0" checked="checked">
			<p style="font-size:0.8em">Skill bonus: <text>Cryptography </text></p>
			<p style="font-size:0.8em">Reward: <text>5 money, 5 fame </text></p>
		</div>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Make some software to sell</text3></b><input type="radio" name="task" value="1">
			<p style="font-size:0.8em">Skill bonus: <text>Programming </text></p>
			<p style="font-size:0.8em">Reward: <text>8 money, 2 fame </text></p>
		</div>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Persuade people to give u money on the streets</text3></b><input type="radio" name="task" value="2">
			<p style="font-size:0.8em">Skill bonus: <text>Psychology</text> </p>
			<p style="font-size:0.8em">Reward: <text>10 money, 0 fame </text></p>
		</div>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Hack into simple website and replace their logo with your login</text3></b><input type="radio" name="task" value="3">
			<p style="font-size:0.8em">Skill bonus: <text>Web </text></p>
			<p style="font-size:0.8em">Reward: <text>0 money, 10 fame </text></p>
		</div>
		</div>
		</br>
		
		<p class="fame">Fame 20</p>
		<div class="flex-Container">
		<div class="flex-item">
			<b style="font-size:1em"><text3>Take part in crypto contest</text3></b><input type="radio" name="task" value="4">
			<p style="font-size:0.8em">Skill bonus: <text>Cryptography </text></p>
			<p style="font-size:0.8em">Reward: <text>10 money, 20 fame </text></p>
		</div>
		</br>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Work one day in known bank company</text3></b><input type="radio" name="task" value="5">
			<p style="font-size:0.8em">Skill bonus: <text>Programming </text></p>
			<p style="font-size:0.8em">Reward: <text>20 money, 10 fame </text></p>
		</div>
		</br>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Blackmail reckless people with their private photos</text3></b><input type="radio" name="task" value="6">
			<p style="font-size:0.8em">Skill bonus: <text>Psychology </text></p>
			<p style="font-size:0.8em">Reward: <text>25 money, 5 fame </text></p>
		</div>
		</br>
		
		<div class="flex-item">
			<b style="font-size:1em"><text3>Make simple blog about hacking</text3></b><input type="radio" name="task" value="7">
			<p style="font-size:0.8em">Skill bonus: <text>Web </text></p>
			<p style="font-size:0.8em">Reward: <text>5 money, 25 fame</text> </p>
		</div>
		</br>
		</div>
	-->	
	</div>
	<div class="textCenter">
	<p style="font-size:0.8em">Remember, you can make only one action per day!</p>	
	<input type="submit" value="Make action" class= "button-warning pure-button"/>
	</div>
	
	</form>
	<?php
		if(isset($_SESSION['ActionDone']) && $_SESSION['ActionDone'] == 1){
			echo '<p style="color:red" class="textCenter">U Have performed action today.</p>';
			unset($_SESSION['ActionDone']);
		}
		else if(isset($_SESSION['NotEnoughFame']) && $_SESSION['NotEnoughFame'] == 1){
			echo '<p style="color:red" class="textCenter">Not enough fame to start.</p>';
			unset($_SESSION['NotEnoughFame']);
		}
		else if(isset($_SESSION['ActionSucces']) && $_SESSION['ActionSucces'] == 1){
			echo '<p style="color:red" class="textCenter">Succes! Rewards added.</p>';
			unset($_SESSION['ActionSucces']);
		}
	?>
	
	
</body>

</html>