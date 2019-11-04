<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	require("functions_film.php");
	$database = "if19_mark_gu_1";
	$noticeRead = null;

	
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
	
	$noticeRead = profileRead($_SESSION["userID"]);
	$messageHTML = null;
	
	$notice = null;
	$filmTitle = null;
	$filmYear = null;
	$filmDuration = null;
	$filmDescription = null;
	
	$filmTitleError = null;
	$filmYearError = null;
	$filmDurationError = null;
	//Kui on filmi salvestamise nuppu vajutatud
	if(isset($_POST["submitFilm"])){
		//Kontrollib, kas on olemas aasta
		if(isset($_POST["filmYear"]) and !empty($_POST["filmYear"])){
			$filmYear = test_input($_POST["filmYear"]);
		} else {
			$filmYearError = "Palun lisage filmi aasta";
		}
		
		//Kontrollib, kas on olemas pealkiri
		if(isset($_POST["filmTitle"]) and !empty($_POST["filmTitle"])){
			$filmTitle = test_input($_POST["filmTitle"]);
		} else {
			$filmTitleError = "Palun lisage filmi pealkiri";
		}
		
		//Kontrollib, kas on olemas kestus
		if(isset($_POST["filmTitle"]) and !empty($_POST["filmTitle"])){
			$filmDuration = test_input($_POST["filmDuration"]);
		} else {
			$filmDurationError = "Palun lisage filmi kestust";
		}
		
		//Kui pole viga
		if(empty($filmTitleError) and empty($filmYearError) and empty($filmDurationError)){
			$filmDescription = test_input($_POST["filmDescription"]);
			$notice = saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmDescription, $_SESSION["userID"]);
		}
	}

	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " filmu lisamise leht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a> | <a href="home.php"> Koduleht </a></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Filmi pealkiri: </label> <input type="text" name="filmTitle"> <br> 
			<label> Filmi tootmise aasta: </label> <input type="number" min="1912" max="2019" value="2019" name="filmYear"><br>
			<label> Filmi kestus (min): </label> <input type="number" min="1" max="300" value="80" name="filmDuration"><br>
			<label>Filmi sisukokkuvõtte</label><br>
			<textarea rows="5" cols="50" name="filmDescription" placeholder="Lisa siia oma sõnum..."></textarea>
			<br>
			<input name="submitFilm" type="submit" value="Salvesta filmi"> <span> <?php echo $notice;?></span> <br>
		</form>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 