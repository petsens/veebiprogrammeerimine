<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	$notice = "";
	require("../../../config.php");
	$database = "if17_rooppeet";
	
	//Kui pole sisse loginud, liigume login lehele
	if(!isset ($_SESSION["userID"])){
		header("Location: login.php");
		exit();
	}
	
	if(isset ($_GET["Logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["ideaButton"])){
		
		if(isset($_POST["idea"]) and !empty($_POST["idea"])){
			//echo $_POST["ideaColor"];
			$notice = saveIdea(($_POST["idea"]), ($_POST["ideaColor"]));
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Peeter
	</title>
</head>
<body>
	<h1>Head mõtted</h1>
	<p>See veebileht on loodud õppetöö raames ning ei 
	sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p><a href="?Logout=1">Logi välja</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>Lisa oma hea mõte</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Hea mõte: </label>
		<input name="idea" type="text">
		<br>
		<label>Mõttega seonduv värv: </label>
		<input name="ideaColor" type="color">
		<br>
		<input name="ideaButton" type="submit" value="Salvesta mõte!">
		<span style="color:red"><?php echo $notice; ?></span>
		
	</form>
	</hr>
	<div style="width: 40%">
		<?php echo listIdeas(); ?>
	</div>
</body>
</html>