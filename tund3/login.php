<?php
	//muutujad
	$myUsername = "";
	$myFirstName = "";
	$myFamilyName = "";
	$Gender = "";
	$myEmail = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	//Vigade muutujad
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$loginEmailError = "";
	$loginPasswordError = "";
	
	$loginEmail = "";
	
	//Kas kasutaja on sisestatud
	if (isset($_POST["loginEmail"])) {
		if (empty ($_POST["loginemail"])){
			//$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
		} else {
			$myUsername = $_POST["loginemail"];
		}
	}	
	
	if (isset($_POST["loginPassword"])){
		if (empty ($_POST["loginPassword"])){
			//$loginPasswordError ="NB! Ilma selleta ei saa sisse logida!";
		} else {
			$userPassword = $_POST["loginPassword"];
		}
	}	
	
	if (isset($_POST["signupFirstName"])) {
		if (empty ($_POST["signupFirstName"])){
			//$signupFirstNameError ="Eesnime sisestamine on kohustuslik";
		} else {
		$myFirstName = $_POST["signupFirstName"];
		}
	}	
	
	if (isset($_POST["signupFamilyName"])) {
		if (empty ($_POST["signupFamilyName"])){
			//$signupFamilyNameError ="Perekonnanime sisestamine on kohustuslik";
		} else  {
		$myFamilyName = $_POST["signupFamilyName"];
		}
	}			
	
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo signupBirthDay;
		
	}
	
	if(isset ($_POST["signupBirthMonth"])){
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}
	
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
		
	//kontrollime kas sisestatud kuupäev on valiidne
	if (isset ($_POST["signupBirthDay"]) and isset ($_POST["signupBirthMonth"]) and 
	isset ($_POST["signupBirthYear"])){
		if (checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), 
		intval($_POST["signupBirthYear"]))){
			$birthDate = date_create($_POST["signupBirthMonth"] ."/" .$_POST["signupBirthDay"]."/" 
			.$_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
			echo $signupBirthDate;
		} else {
			$signupBirthDayError = "Sünnikuupäev pole valiidne!";
		}	
	
	} else{
		$signupBirthDayError = "Kuupäev pole määratud!";
	}	
	
	if (isset($_POST["Gender"]) && !empty($_POST["Gender"])) {
			$Gender = intval($_POST["Gender"]);
		} else {
			$signupgenderError ="Soo sisestamine on kohustuslik!";
	}
	
	if (isset($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="Emaili sisestamine on kohustuslik!";
		} else {
		$myEmail = $_POST["signupEmail"];
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registreerimine ja sisselogimine</title>
	
</head>
<body>
<form method="post" action="">
	<p>See veebileht on õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Registreerimine ja sisselogimine.</p>
	
	<fieldset>
	<h1>Sisse logimine</h1>
	<label>Kasutajanimi(Email): <label><br>
	<input type="email" name="loginEmail" value="<?php echo $myUsername ?>">
	<span class="error"> <?php echo $loginEmailError;?></span><br>
	<label>Parool: <label><br>
	<input type="password" name="loginPassword"><br>
	<span class="error"> <?php echo $loginPasswordError;?></span><br>
	<input type="submit" value="Logi sisse">

</form>
<form method="post">
	<h1>Registreerimine</h1>
	<?php
		
		echo "<p>Kui pole veel kasutajat...<p>";
	?>
	<label>Eesnimi: <label><br>
	<input type="text" name="signupFirstName" value="<?php echo $myFirstName ?>">
	<span class="error"> <?php echo $signupFirstNameError;?></span><br>
	<label>Perekonnanimi: <label><br>
	<input type="text" name="signupFamilyName" value="<?php echo $myFamilyName ?>">
	<span class="error"> <?php echo $signupFamilyNameError;?></span><br>
	<label>Sisesta oma sünnikuupäev</label><br>
		<?php
			echo $signupDaySelectHTML ."\n" .$signupMonthSelectHTML .$signupYearSelectHTML;
		?>
		<span class="error"> <?php echo $signupBirthDayError;?></span>
	<br><br>
	<input type="radio" name="gender" value="male" checked> Mees</label>
	<input type="radio" name="gender" value="female"> Naine<br>
	<label>Email: <label><br>
	<input type="email" name="signupEmail" value="<?php echo $myEmail ?>"><br>
	<label>Parool: <label><br>
	<input type="password" name="loginPassword"><br>
	<input type="submit" value="Registreeri">
	
</fieldset>
</form>
	

</body>
</html>