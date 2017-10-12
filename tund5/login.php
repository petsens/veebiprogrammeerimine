<?php
	require ("functions.php");
	require("../../../config.php");
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$loginEmail = "";
	$loginPasswordError = "";
	$notice = "";
	$signupBirthDate = null;
	//errorite muutujad
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	
	if(isset ($_SESSION["userID"])){
		header("Location: main.php");
		exit();
	}
	
	//Kas kl�psati sisselogimise nuppu?
	if (isset ($_POST["signinButton"])) {
		//kas on kasutajanimi sisestatud
		if (isset ($_POST["loginEmail"])){
			if (empty ($_POST["loginEmail"])){
				$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
			} else {
				$loginEmail = $_POST["loginEmail"];
			}
		}
		if (isset ($_POST["loginPassword"])) {
			if (empty ($_POST["loginPassword"])) {
				$loginPasswordError = "Sisse logimiseks on vaja sisestada parool";
			}
		else {
		}
		}
		
		if(!empty($loginEmail) and !empty($_POST["loginPassword"])) {
			$notice = signIn($loginEmail, $_POST["loginPassword"]);
		}
	} //Sisselogimine l�ppeb
		
	//Kas vajutati registreerimisel submit nuppu?
	if (isset ($_POST["signupButton"])){
		//kontrollime, kas kirjutati eesnimi
		if (isset ($_POST["signupFirstName"])){
			if (empty ($_POST["signupFirstName"])){
				$signupFirstNameError ="Teil j�i eesnimi sisestamata.";
				//echo $signupFirstNameError;
			} else {
				$signupFirstName = test_input($_POST["signupFirstName"]);
			}
		}
	
		//kontrollime, kas kirjutati perekonnanimi
		if (isset ($_POST["signupFamilyName"])){
			if (empty ($_POST["signupFamilyName"])){
				$signupFamilyNameError ="Teil j�i perenimi sisestamata";
			} else {
				$signupFamilyName = test_input($_POST["signupFamilyName"]);
			}
		}
	
		//kontrollime, kas kirjutati kasutajanimeks email
		if (isset ($_POST["signupEmail"])){
			if (empty ($_POST["signupEmail"])){
				$signupEmailError ="Email on registreerimiseks kohustuslik";
			} else {
				$signupEmail = test_input($_POST["signupEmail"]);
				
				$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
				$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
			}
		}
	
		if (isset ($_POST["signupPassword"])){
			if (empty ($_POST["signupPassword"])){
				$signupPasswordError = "Parool on kohustuslik";
			} else {
				//polnud t�hi
				if (strlen($_POST["signupPassword"]) < 8){
					$signupPasswordError = "NB! Liiga l�hike salas�na, vaja v�hemalt 8 t�hem�rki!";
				}
			}
		}
	
		if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on m��ratud ja pole t�hi
				$gender = intval($_POST["gender"]);
			} else {
				$signupGenderError = "Sugu on m��ramata.";
			
			}
	
		if (isset ($_POST["signupBirthDay"])){
			$signupBirthDay = $_POST["signupBirthDay"];
			//echo $signupBirthDay;
		}
	
		if (isset ($_POST["signupBirthMonth"])) {
			$signupBirthMonth = intval($_POST["signupBirthMonth"]);
		}
	
		if (isset ($_POST["signupBirthYear"])){
			$signupBirthYear = $_POST["signupBirthYear"];
			//echo $signupBirthYear;
		}
		//Kontrollime kas sisestatud kuup�ev on valiidne
	
		if (isset ($_POST["signupBirthDay"]) and (isset ($_POST["signupBirthMonth"])) and (isset ($_POST["signupBirthYear"]))) {
			if (checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))) {
				$birthDate = date_create($_POST["signupBirthMonth"] ."/"  .$_POST["signupBirthDay"] ."/" .$_POST["signupBirthYear"]);
				$signupBirthDate = date_format($birthDate, "Y-m-d");
				//echo $signupBirthDate;
			} else {
				$signupBirthDayError = "S�nnikuup�ev on vigane";
			}
		} else {
			$signupBirthDayError = "S�nnikuup�ev pole m��ratud";
		}
	
	
		//UUE KASUTAJA LISAMINE ANDMEBAASI
		if(empty ($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError) and !empty($_POST["signupPassword"])) {
			//echo "hakkan andmeid salvestama";
			$signupPassword = hash("sha512", $_POST["signupPassword"]);
			signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		} else {
		}
	} else {
	}
	//Uue kasutaja loomise l�pp
	
	//Tekitame kuup�eva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>p�ev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	//Tekitan s�nnikuu valiku
	$monthNamesEt = ["jaanuar", "veebruar", "m�rts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .='<option value ="" selected disabled>kuu</option>' . "\n";
	
	foreach($monthNamesEt as $key=>$month){                      //$key=>$month v�tab k�igepealt massiivi indeksi ja siis v��rtuse
		if($key +1 === $signupBirthMonth) {
			$signupMonthSelectHTML .= '<option value ="' .($key + 1) .'" selected>' .$month ."</option> \n"; 
		} else {
			$signupMonthSelectHTML .= '<option value = "' .($key + 1) .'">' .$month ."</option> \n";
		}
		 
	}
	$signupMonthSelectHTML .="</select> \n";
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
		
	}
	$signupYearSelectHTML.= "</select> \n";
	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine v�i uue kasutaja loomine</title>
</head>
<body>
	<h1>Logi sisse!</h1>
	<p>Siin harjutame sisselogimise funktsionaalsust.</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<table border="0" cellpadding="5px" cellspacing="5px">
		<tr>
			<td><label>Kasutajanimi (E-post): </label></td>
			<td><input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>"></td>
		</tr>
		<tr>
			<td><label>Parool: </label></td>
			<td><input name="loginPassword" placeholder="Salas�na" type="password"></td>
		</tr>
		<tr>
			<td><span style="color:red" ><?php echo $notice, $loginPasswordError; ?></span></td>
			<td><input name="signinButton" type="submit" value="Logi sisse"></td>
		</tr>
	</table>
	</form>
	
	<h1>Loo kasutaja</h1>
	<p>Kui pole veel kasutajat....</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<table border="0" cellpadding="5px" cellspacing="5px">
		<tr>
			<td><label>Eesnimi: </label></td>
			<td><input name="signupFirstName" type="text" value="<?php echo $signupFirstName; ?>"></td>
			<td><span style="color:red" ><?php echo $signupFirstNameError; ?></span></td>
		</tr>
		<tr>
			<td><label>Perekonnanimi: </label></td>
			<td><input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>"></td>
			<td><span style="color:red" ><?php echo $signupFamilyNameError; ?></span></td>
		</tr>
		<tr>
			<td><label> Sisesta s�nnikuup�ev: </label></td>
			<td><?php
				echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";$signupMonthSelectHTML;
			?></td>
			<td><span style="color:red" ><?php echo $signupBirthDayError; ?></span></td>
		</tr>
		<tr>
			<td><label>Sugu:</label><span></td>
			<td>
			<input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label>Mees</label> <!-- K�ik l�bi POST'i on string!!! -->
			<input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>><label>Naine</label>
			</td>
			<td><span style="color:red" ><?php echo $signupGenderError; ?></span></td>
		</tr>
		<tr>
			<td><label>Kasutajanimi (E-post):</label></td>
			<td><input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>"></td>
			<td><span style="color:red" ><?php echo $signupEmailError; ?></span></td>
		<tr>
		<tr>
			<td><label>Parool:</label></td>
			<td><input name="signupPassword" placeholder="Salas�na" type="password"></td>
			<td><span style="color:red"><?php echo $signupPasswordError; ?></span></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="signupButton" type="submit" value="Loo kasutaja"></td>
		</tr>
	</table> 
	</form>
		
</body>
</html>