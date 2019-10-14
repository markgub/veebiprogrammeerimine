<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	require("function_message.php");
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
	$messageHTML = null;
	
	
	//Kui on profiili salvestamise nuppu vajutatud
	if(isset($_POST["submitMessage"])){
			if(isset($_POST["message"]) and !empty($_POST["message"])){
			$notice = storeMessage(test_input($_POST["message"]));
		} else {
			$notice = "Sõnumi pole, mees!";
		}
	}
	//$messageHTML = readAllMessages();
	$messageHTML = readMyMessages();
	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " profiili häälestamisleht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a> | <a href="home.php"> Koduleht </a></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		  <label>Minu sõnum</label><br>
		  <textarea rows="5" cols="50" name="message" placeholder="Lisa siia oma sõnum..."></textarea>
		  <br>
		  <input name="submitMessage" type="submit" value="Salvesta sõnum"> <span> <?php echo $notice;?></span> <br>
		</form>
		<h2> Senised sõnumid</h2>
		<?php
			echo $messageHTML;
		?>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 