<?php
	$database = "if17_rooppeet";
	
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