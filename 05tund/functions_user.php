<?php
	function signUp($name, $surname, $email, $gender, $birthDate, $password){
		$notice = null;
		$dataBase = "if19_mark_gu_1";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpusers3 (firstname, lastname, birthdate, gender, email, password) VALUES(?, ?, ?, ?, ?, ?)");
		echo $conn->error;
		
		//Valmistame parooli salvestamiseks ette
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
		
		if($stmt->execute()){
			$notice = "Uue kasutaja loomine õnnestus!";
		} else {
			$notice = "Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error();
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}