<?php
	$database = "if17_rooppeet";
	require("../../../config.php");
	
	//alustame sessiooni
	session_start();
	
	//sisselogimine
	function signIn($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password, firstname, lastname FROM vp_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $firstNameDb, $lastNameDb);
		$stmt->execute();
		
		//kontrollime kasutajat
		
		if($stmt->fetch()) { // kui fetch ja saab midagi kätte
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				$notice = "Kõik korras, logisimegi sisse";
				//salvestame sessiooni muutujaid
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb; 
				$_SESSION["userFirstName"] = $firstNameDb;
				$_SESSION["userLastName"] = $lastNameDb;
				
				//liigume pealehele
				header("Location: main.php");
				exit();
			} else {
				$notice = "Sisestasite ebakorrektse salasõna";
			}
			
		} else {
			$notice = "Sellist kasutajat:." .$email ."ei ole";
		}
		return $notice;
		
	}
	
	//uue kasutaja lisamine andmebaasi
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
			//ühendus serveriga
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
			//käsud serverile
			$stmt = $mysqli->prepare("INSERT INTO vp_users (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
			echo $mysqli->error;
			//s - string ehk tekst
			//i - integer ehk täisarv
			//d - decimal ehk ujukomaarv
			$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
			//stmt->execute();
			if ($stmt->execute()) {
				echo "Kasutaja registreeritud";
				
			} else {
				echo "Tekkis viga: " .$stmt->error;
			}
			$stmt->close();
			$mysqli->close();
	}		
	
	function saveIdea($idea, $color){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vp_userideas (userid, idea, ideacolor) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss", $_SESSION["userID"], $idea, $color);
		if($stmt->execute()){
			$notice = "Mõte on salvestatud!";
		} else {
			$notice = "Salvestamisel tekkis viga: " .$stmt->error;
		}		
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}	
	
	function listIdeas(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp_userideas");
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp_userideas ORDER BY id DESC");
		$stmt = $mysqli->prepare("SELECT id, idea, ideacolor FROM vp_userideas WHERE userid = ? AND deleted IS NULL ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userID"]);
		$stmt->bind_result($id, $idea, $color);
		$stmt->execute();
		
		while($stmt->fetch()){
			//<p> style="background-color: #ff5577">Hea mõte</p>
			//$notice .= '<p style="background-color: ' .$color .'">' .$idea ."</p> \n";
			$notice .= '<p style="background-color: ' .$color .'">' .$idea .' | <a href="edituseridea.php?id=' .$id .'">Toimeta </a>' ."</p> \n";
			//<p style="background-color: #ff80ff">Uuemad mõtted tulevad eespool</p>
//<p style="background-color: #ff80ff">Uuemad mõtted tulevad eespool | <a href = "edituseridea.php?id=34"</p>
		}	
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}	
	
	function latestIdea(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);	
		$stmt = $mysqli->prepare("SELECT idea FROM vp_userideas WHERE id = (SELECT MAX(id) FROM vp_userideas WHERE deleted IS NULL)");
		echo $mysqli->error;
		$stmt->bind_result($idea);
		$stmt->execute();
		$stmt->fetch();
		
		$stmt->close();
		$mysqli->close();
		return $idea;
	}	
	
	//sisestuse kontrollimine
	function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühiku
		$data = stripslashes($data); // eemaldab /'id
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	
	function add_values() {
		echo "Teine summa on:" .(($GLOBALS["x"]) + ($GLOBALS["y"]));
	}
	
	function genderText($genderDb) {
		if ($genderDb == 1) {
				$gender = "Male";
				return $gender;
			} 	elseif ($genderDb == 2) {
				$gender = "Female";
				return $gender;
			}
	}
	
?>