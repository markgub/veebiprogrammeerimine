<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	$database = "if19_mark_gu_1";
	$noticeRead = null;
	$noticeSave = "";
	$mydescription = "Oota mida?";
	$mybgcolor = null;
	$mytxtcolor = null;
	$descriptionError = null;

	
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
	$mydescription = $_SESSION["userDescription"];
	$mybgcolor = $_SESSION["user_bgcollor"];
	$mytxtcolor = $_SESSION["user_txtcollor"];
	
	//Kui on profiili salvestamise nuppu vajutatud
	if(isset($_POST["submitProfile"])){
		//Kui on sisestatud kirjeldus
		/*if(isset($_POST["description"]) and !empty($_POST["description"])){
			$mydescription = test_input($_POST["description"]);
		} else {
			$descriptionError = "Palun kirjeldage ennast!" ."<br>";
		} */
		
		$mybgcolor = test_input($_POST["bgcolor"]);
		$mytxtcolor = test_input($_POST["txtcolor"]);
		
		$noticeSave = ProfileSave($_SESSION["userID"], $mydescription, $mybgcolor, $mytxtcolor);
		$noticeRead = profileRead($_SESSION["userID"]);
		$mydescription = $_SESSION["userDescription"];
		
		/*if($notice != null and $descriptionError == null){
			$notice2 = ProfileSave($_SESSION["userID"], $mydescription, $mybgcolor, $mytxtcolor);
			$notice = profileRead($_SESSION["userID"]);
			$mydescription = $_SESSION["userDescription"];
		} else if($notice == null){
			$notice2 = "Profiil on juba häälestatud!";
		} else {
			$notice2 = "There is problemo, min compadre!";
		}*/
	}

	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " profiili häälestamisleht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		  <label>Minu kirjeldus</label><br>
		  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
		  <br>
		  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
		  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
		  <input name="submitProfile" type="submit" value="Salvesta profiil"> <br>
		</form>
		<?php 
		echo $noticeRead;
		echo $descriptionError; 
		echo $noticeSave;
		?>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 