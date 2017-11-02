<?php
	require("../config.php");
	$database = "if17_rinde";
	$language = "";
	$today = date("l, d.m.Y");
	if (isset ($_POST['selLang'])){
		$language = $_POST['selLang'];
	};

	function keel($language){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT language FROM vp_users WHERE email = ?");
		$stmt->bind_param("s", $language);
		$stmt->bind_result($language);
		$stmt->execute();
		if($stmt->execute()){
			$notice = "Täna on ".$today;
			$notice = "".$language;
		}
		return $notice;
			
	}


?>

<!DOCTYPE html>
<html lang="et">
	<head>
	<title>Kontrolltöö NR 4</title>
	</head>
	<body>
	<h1>Tänane päev</h1>
	<form method="POST">
		<select name="selLang">
			<option value="" selected disabled>Vali keel</option>
			<option value="eesti">eesti</option> 
			<option value="inglise">inglise</option> 
			<option value="saksa">saksa</option> 
			<option value="Bosna">Bosna</option> 
			<option value="soome">soome</option> 
			<option value="juhuslik keel">juhuslik keel</option> 
		</select>
		<input type="submit" name="selectLanguage" value="Vali keel"><br>
		<?php
		if (isset($_POST['selectLanguage'])){
			echo $today, " Valitud on ".$language;	
		}
		?>
	</form>
    </body>
</html>