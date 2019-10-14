<?php
	require("../../../config_vp2019.php");
	require("functions_film.php");
	$userName = "Mark-Krilli";
	$database = "if19_mark_gu_1";
	
	$filmInfoHTML = readAllFilms();
	
	//lisame lehe päise
	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " koolitöö leht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<h2> Eesti filmid</h2>
		<p> Praegu on andmebaasis järgmised filmid</p>
		<?php
		echo $filmInfoHTML;
		//echo "Server: " .$serverHost. ", kasutaja: " .$serverUsername;
		?>
		<hr>
	</body>
</html>
