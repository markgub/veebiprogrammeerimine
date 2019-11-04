<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	require("functions_pic.php");
	$database = "if19_mark_gu_1";
	$notice = null;

	
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
	
	$notice = profileRead($_SESSION["userID"]);	
	

	if(isset($_POST["submitPic"])){

	}
	
	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " piltide häälestamisleht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a> | <a href="home.php"> Koduleht </a></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
			<label>Vali üleslaetav pilt!</label>
			<input type="file" name="fileToUpload" id="fileToUpload"> <br>
			<input name="submitPic" type="submit" value="Lae pilt üles"> <span> <?php echo $notice;?></span> <br>
		</form>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 