<?php
	//ühendan sessiooniga

/** @noinspection PhpIncludeInspection */
require("functions.php");
	
	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");  //iga headeri järele tuleks lisada exit
		exit();
	}
		
	
	
	
	//kas aadressi real on logout
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if ( 	 isset($_POST["show"]) &&
			 isset($_POST["season"]) &&
			 isset($_POST["episode"]) &&
			 !empty($_POST["show"]) &&
			 !empty($_POST["season"]) &&
			 !empty($_POST["episode"]) 
		
		) {
								
			saveShow(cleanInput($_POST["show"],$_POST["season"],$_POST["episode"]));
			
		}
	
		$shows = getAllShows();
		
		//echo "<pre>";
		//var_dump($shows);
		//echo "</pre>";
		
?>

<h1>Data</h1>

<p>

	Tere Tulemast <?=$_SESSION ["userEmail"];?> !
	<a href="?logout=1">Logi Välja</a>

</p>

<html>

<body>

	<h1>Mis sarja vaatasid?</h1>
	
	<form method="POST">
	
		<label>Sarja nimi:</label> 
		
		<br>
		
		<input name="show" type = "text">
		
		<br><br>
		
		<label>Hooaeg:</label>
		
		<br>
		
		<input name="season" type = "number" >
	
		<br><br>
		
		<label>Episood:</label>
		
		<br>
		
		<input name="episode" type = "number" >
	
		<br><br>
		
		<input type = "submit" value = "SAVE" >
		
	</form>
	
	<h2>Arhiiv</h2>
	
<?php
	
	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<td>ID</td>";
			$html .= "<td>Sari</td>";
			$html .= "<td>Hooaeg</td>";
			$html .= "<td>Episood</td>";
		$html .= "</tr>";
		
		foreach ($shows as $s) {
			
			$html .= "<tr>";
				$html .= "<td>".$s->id."</td>";
				$html .= "<td>".$s->show."</td>";
				$html .= "<td>".$s->season."</td>";
				$html .= "<td>".$s->episode."</td>";
			$html .= "</tr>";
			
		}
		
	$html .= "</table>";
	
	echo $html;	
?>
	

	
</body>	
</html>