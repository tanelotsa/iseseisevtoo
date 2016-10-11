<?php
	//ühendan sessiooniga
	
	require("functions.php");
	
	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");		
	}
	
	
	
	//kas aadressi real on logout
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	if ( 	 isset($_POST["age"]) &&
			 isset($_POST["color"]) &&
			 !empty($_POST["age"]) &&
			 !empty($_POST["color"]) 
		
		) {
			saveEvent($_POST["age"],$_POST["color"]);
		}
	
		$people = getAllPeople();
		
		//echo "<pre>";
		//var_dump($people);
		//echo "</pre>";
		
?>

<h1>Data</h1>

<p>

	Tere Tulemast <?=$_SESSION ["userEmail"];?> !
	<a href="?logout=1">Logi Välja</a>

</p>

<html>

<body>

	<h1>Kes läks üle tee?</h1>
	
	<form method="POST">
	
		<label>Vanus:</label> 
		
		<br>
		
		<input name="age" type = "number"> <//?php echo $loginEmailError ; ?>
		
		<br><br>
		
		<label>Foori tule värv:</label>
		
		<br>
		
		<input name="color" type = "color" > <//?php echo $loginPasswordError ; ?>
	
		<br><br>
		
		<input type = "submit" value = "SAVE" >
		
	</form>
	
	<h2>Arhiiv</h2>
	
<?php
	
	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<td>ID</td>";
			$html .= "<td>Vanus</td>";
			$html .= "<td>Värv</td>";
		$html .= "</tr>";
		
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->age."</td>";
				$html .= "<td>".$p->color."</td>";
			$html .= "</tr>";
			
		}
		
	$html .= "</table>";
	
	echo $html;	
?>
	
<h3>Midagi huvitavat</h3>
	
<?php

		foreach ($people as $p) {
			
			$style = "
			
				background-color:".$p->color.";
				width: 40px;
				height: 40px;
				border-radius: 20px;
				text-align: center;
				line-height: 30px;
				float: left;
				margin: 20px;
			";	
				
			echo "<p style = ' ".$style." '>".$p->age."</p>";
		
		}











?>	
	
</body>	
</html>