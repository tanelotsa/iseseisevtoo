<?php
	require("../../config.php");
	
	//see fail peab olema seotud kõigiga, kus tahame sessiooni kasutada
	//saab kasutada nüüd $_SESSION muutujat
	
	session_start();


	$database = "if16_taneotsa_4";
	
	function signup($email, $password) {
		
		//loon ühenduse 
		
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO user_sample (email, password, gender, birthdate) VALUE(?,?,?,?)");
		echo $mysqli->error;
		//asendan küsimärgid
		//iga märgikohta tuleb lisada üks täht ehk mis tüüpi muutuja on
		//	s - string
		//	i - int,arv
		//  d - double
		$stmt->bind_param("ssss", $email, $password, $_POST["gender"], $_POST["birthdate"]);
		
		
		//täida käsku 
		if($stmt->execute() ) {
			echo "Õnnestus!";			
		} else{
			echo "ERROR".$stmterror;
		}
		
	}
	
	function login ($email, $password) {
	
		$notice = "";
			
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("
		
					SELECT id, email, password, created, gender, birthdate
					FROM user_sample
					WHERE email = ? 
					
		");	
		echo $mysqli->error;
	
		//asendan ?
		
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created, $gender, $birthdate);
		
		$stmt->execute();
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			//oli olemas, rida käes
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION ["userId"] = $id;
				$_SESSION ["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
				
				
				
			} else {
				$notice = "Parool vale !";
			}
		
		} else {	
			//ei olnud ühtegi rida
			$notice = "Sellise e-mailiga ".$email." kasutajat ei ole olemas!";
		}
		
		return $notice;
	
	}
	
	function saveEvent($age,$color) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO whistle (age, color) VALUE(?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("is", $age, $color);
	
		if($stmt->execute() ) {
			echo "Õnnestus!","<br>";			
		} else{
			echo "ERROR".$stmterror;
		}
	
	}
	
	function getAllPeople () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, age, color FROM whistle");
		$stmt->bind_result($id, $age, $color);
		$stmt->execute ();
		
		$results = array();
		
		//tsükli sisu tehakse niimitu korda , mitu rida sql lausega tuleb
		while($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->color = $color;
			
			//echo $color."<br>";
			array_push($results,$human);
		}
		
		return $results;
	}






	
	
	/*
	function hello ($firstname, $lastname) {
		return "Tere tulemast ".$firstname." ".$lastname."!";		
	}

	echo hello ("Tanel","Otsa");
	*/
	
?>