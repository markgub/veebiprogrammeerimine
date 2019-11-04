<?php
	require("../../../config_vp2019.php");
	$userName = "Mark-Krilli";
	$database = "if19_mark_gu_1";
	require("functions_film.php");
	
	//var_dump($_POST);
	//Kui on nuppu vajutatud
	$pealkiriWarning = null;
	if(isset($_POST["submitFilm"])){
		//Salvestame, kui v'hemalt pealkiri on olemas
		if(!empty($_POST["filmTitle"])){
			saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmCompany"], $_POST["filmDirector"]);
		} else {
			$pealkiriWarning = "Vähemalt pealkirja lahter peab olema täidetud!";
		}
	}
	
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
		<h2> Eesti filmid, lisame uue</h2>
		<p> Täida kõik failid ja lisa film andmebaasi</p>
		<form method="POST">
			<label> Sisesta pealkiri: </label> <input type="text" name="filmTitle">
			<br>
			<label> Filmi tootmis aasta: </label> <input tyoe="number" min="1912" max="2019"
			value="2019" name="filmYear">
			<br>
			<label> Filmi kestus (min): </label> <input type="number" min="1" max="300" value="80" name="filmDuration">
			<br>
			<label> filmi žanr: </label> <input type="text" name="filmGenre">
			<br>
			<label> filmi tootja: </label> <input type="text" name="filmCompany">
			<br>
			<label> filmi lavastaja: </label> <input type="text" name="filmDirector">
			<br>
			<input type="submit" value="Salvesta filmi info" name="submitFilm">
			<?php
			echo "<p>" .$pealkiriWarning ."</p>";
			?>
		</form>
		<?php
		//echo $filmInfoHTML;
		//echo "Server: " .$serverHost. ", kasutaja: " .$serverUsername;
		?>
	</body>
</html>
