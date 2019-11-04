<?php
	function readAllFilms(){
		$maxYear = date("Y");
		//Loeme andmebaasist
		//Loome anbmebaasiühenduse (näieks $conn)
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//Valmistame ette päringu
		$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film WHERE aasta < ?");
		$stmt->bind_param("i", $maxYear);
		//Seome saadava tulemuse muutujaga
		$stmt->bind_result($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector); //"Pakk visati lauda"
		//käivitame SQL päringu
		$stmt->execute();
		$filmInfoHTML = null;
		while($stmt->fetch()){
			//Täpsem kestus
			$filmDurationInH = floor($filmDuration/60);
			if($filmDurationInH == 1){
				$filmDurationInH .= " tund";
			} else if($filmDurationInH == 0){
				$filmDurationInH = null;
			} else {
				$filmDurationInH .= " tundi";
			}
			$filmDurationInM = $filmDuration % 60;
			if($filmDurationInM == 1){
				$filmDurationInM = " ja" .$filmDurationInM ." minut";
			} else if ($filmDurationInM == 0){
				$filmDurationInM = null;
			} else if ($filmDurationInM != 0 and $filmDurationInH == 0){
				$filmDurationInM = $filmDurationInM ." minutit";
			} else {
				$filmDurationInM = " ja " .$filmDurationInM ." minutit";
			} 
			
			//Mida kirjutatakse
			$filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
			$filmInfoHTML .= "<p>Žanr: " .$filmGenre .", lavastaja: " .$filmDirector .". Kestus: " .$filmDurationInH .$filmDurationInM .". Tootnud: " .$filmCompany ." aastal: " .$filmYear .".</p>";
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
	
	function saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmDescription, $userID){
		$notice = null;
		$filmID = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO FILM (Pealkiri, Aasta, Kestus, Sisukokkuv6tte) VALUES(?,?,?,?)");
		echo $conn->error;
		//s - string, i - integer, d - decimal
		$stmt->bind_param("siis", $filmTitle, $filmYear, $filmDuration, $filmDescription);
		if($stmt->execute()){
			$stmt->close();
			$stmt = $conn->prepare("SELECT Film_ID FROM FILM WHERE Pealkiri = ? AND Aasta = ? AND Kestus = ? AND Sisukokkuv6tte = ?");
			echo $conn->error;
			$stmt->bind_param("siis", $filmTitle, $filmYear, $filmDuration, $filmDescription);
			$stmt->bind_result($filmIDFromDB);
				if($stmt->execute()){
					if($stmt->fetch()){
						$stmt->close();
						$stmt = $conn->prepare("INSERT INTO vpfilmilisas (FILM_Film_ID, vpusers3_id) VALUES(?,?)");
						echo $conn->error;
						$stmt->bind_param("ii", $filmIDFromDB, $userID);
						if($stmt->execute()){
							$notice = "Film oli edukalt laetud andmebaasi";
						}
					}else {
						$notice = "Filmi laadimisel tekkis viga teises andmebaasis" .$stmt->error;
					}
				} else {
					$notice = "Filmi laadimisel tekkis viga andmebaasi lugemisel" .$stmt->error;
				}
		} else {
			$notice = "Filmi laadimisel tekkis viga" .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>