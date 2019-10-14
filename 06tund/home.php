<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	$database = "if19_mark_gu_1";

	
	//Kui pole sisse loginud
	if(!isset($_SESSION["userID"])){
		//Siis jõuga sisselogimise lehele
		header("Location: page.php");
		exit();
	}
	
	//Välja logimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	$userName = $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"];

	require("header.php");
?>

	<head>
		<style>
			body{background-color: <?php echo $_SESSION["user_bgcollor"]?>;
			color: <?php echo $_SESSION["user_txtcollor"]?>}
		</style>
	</head>

	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " koolitöö leht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a><a href="userprofile.php">Kasutaja profiil</a></p>
		
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 