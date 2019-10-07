<?php
	function signUp($name, $surname, $email, $gender, $birthDate, $password){
		$notice = null;
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
			$notice = "Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function signIn($email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT firstname, lastname, password FROM vpusers3 WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		if($stmt->execute()){
		} else {
			$notice = "Midagi läks valesti.";
			echo $conn->error;
		}
		
		$stmt->bind_result($name, $surname, $passwordFromDB);
		$stmt->fetch();
		if(password_verify($password, $passwordFromDB)) {
			$notice = "Sisse logis " .$name ." " .$surname;
		} else {
			$notice = "Kasutajatunnus ja/või salasõna on valed";
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
		//Parooli õigsust kontrollib:
		//if(password_verify($password, $passwordFromDB))
	}