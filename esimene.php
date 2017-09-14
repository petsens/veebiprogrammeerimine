<?php
	//muutujad
	$myName = "Peeter";
	$myFamilyName = "Roop";
	
	//hindan äeva osa (võrdlemine < > <= >= != == )
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "Varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "Koolipäev";
	}
	if ($hourNow > 16){
		$partOfDay = "Vaba aeg";
	}
	//echo $partOfDay;
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Peeter Roop programmeerib veebi</title>

</head>
<body>
	<h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
	<p>See veebileht on õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Eesti ilmad on praegu väga halvad.</p>
	<p>I am mr. Robot<p>
	<?php
		echo "<p>Algas php õppimine.</p>";
		echo "<p>Täna on ";
		echo date("d.m.Y") .", kell oli lehe avamise hetkel " .date("H:i:s");
		echo ", hetkel on " .$partOfDay .".</p>";
	?>
</body>
</html>