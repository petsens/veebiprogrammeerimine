<?php
	//et p��seks ligi sessioonile ja funktsioonidele
	require("functions.php");
	
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
	
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	$allFiles = array_slice(scandir($picDir), 2);
	foreach ($allFiles as $file) {
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if(in_array($fileType, $picFileTypes)){
			array_push($picFiles, $file);
		}
			
	}
	//var_dump($allFiles);
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles);
	$picNumber = mt_rand(0, $picFileCount - 1);
	$picFile = $picFiles[$picNumber];
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
	<h1><?php  echo "Tervist, " .$_SESSION["userFirstName"] ." " .$_SESSION["userLastName"] .".";?></h1>
	<p>See veebileht on loodud �ppet�� raames ning ei 
	sisalda mingisugustki t�siseltv�etavat sisu!</p>
	<p><a href="usersInfo.php">Kasutajate nimekiri</a></p>
	<p><a href="usersideas.php">Head m�tted</a></p>
	<p><a href="?Logout=1">Logi v�lja</a></p>
	<img src ="<?php echo $picDir .$picFile?>" alt="Tallinna �likool"> 
</body>
</html>