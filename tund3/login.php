<?php
	$myUsername;
	$myFirstName;
	$myFamilyName;
	$gender;
	$myEmail;
	
	if (isset($_POST["loginEmail"])) {
		$myUsername = $_POST["loginEmail"];
	}
	else {
		$myUsername = "";
	}
	
	if (isset($_POST["loginPassword"])){
		$userpassword = $_POST["loginPassword"];
	}
	else {
		$userpassword = "";
	}
	
	if (isset($_POST["signupFirstName"])) {
		$myFirstName = $_POST["signupFirstName"];
	}
	else {
		$myFirstName = "";
	}
	
	if (isset($_POST["signupFamilyName"])) {
		$myFamilyName = $_POST["signupFamilyName"];
	}
	else  {
		$myFamilyName = "";
	}
	
	if (isset($_POST["gender"])) {
		$gender = $gender = intval($_POST["gender"]);
	}
	else {
		$gender = "";
	}
	
	if (isset($_POST["signupEmail"])) {
		$myEmail = $_POST["signupEmail"];
	}
	else {
		$myEmail = "";
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
	Kasutajanimi(Email):<br>
	<input type="text" name="loginEmail" value="<?php echo $myUsername ?>"><br>
	Parool:<br>
	<input type="password" name="loginPassword"><br>
	<input type="submit" value="Logi sisse">

</form>
<form method="post" action="">
	<h1>Registreerimine</h1>
	<?php
		
		echo "<p>Kui pole veel kasutajat...<p>";
	?>
	Eesnimi:<br>
	<input type="text" name="signupFirstName" value="<?php echo $myFirstName ?>"><br>
	Perekonnanimi:<br>
	<input type="text" name="signupFamilyName" value="<?php echo $myFamilyName ?>"><br>
	<label><input type="radio" name="gender" value="male" checked> Mees</label>
	<input type="radio" name="gender" value="female"> Naine<br>
	Email:<br>
	<input type="email" name="signupEmail" value="<?php echo $myEmail ?>"><br>
	Parool:<br>
	<input type="password" name="loginPassword"><br>
	<input type="submit" value="Registreeri">
	
</fieldset>
</form>
	

</body>
</html>