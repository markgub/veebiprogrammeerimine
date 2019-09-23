<?php
	function readAllFilms(){
		//Loeme andmebaasist
		//Loome anbmebaasiühenduse (näieks $conn)
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//Valmistame ette päringu
		$stmt = $conn->prepare("SELECT pealkiri, aasta FROM film");
		//Seome saadava tulemuse muutujaga
		$stmt->bind_result($filmTitle, $filmYear); //"Pakk visati lauda"
		//käivitame SQL päringu
		$stmt->execute();
		$filmInfoHTML = null;
		while($stmt->fetch()){
			$filmInfoHTML .= "<h3>" .$filmTitle. "</h3>";
			$filmInfoHTML .= "</>Tootmisaasta: " .$filmYear .".</p>";
			//echo $filmTitle ." ";
		}
		//$stmt->fetch();//"Pakkist võetakse vastu ühte lehte"
		//echo $filmTitle;
		
		//Sulgeme ühenduse
		$stmt->close();
		$conn->close();
		//Väljastan väärtuse
		return $filmInfoHTML;
	}
	
	function saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector){
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		//s - string, i - integer, d - decimal
		$stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector);
		$stmt->execute();
		
		$stmt->close();
		$conn->close();
		
	}
?>