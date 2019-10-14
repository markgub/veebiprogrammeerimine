<?php
	//Käivitame sessiooni
	session_start();
	//var_dump($_SESSION);
	
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
		$stmt = $conn->prepare("SELECT password FROM vpusers3 WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($passwordFromDB);
		if($stmt->execute()){
			//Pärin õnnestus
			if($stmt->fetch()){
				//kasutaja on olemas
				if(password_verify($password, $passwordFromDB)){
				  //kui salasõna klapib
				  $stmt->close();
				  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM vpusers3 WHERE email=?");
				  echo $conn->error;
				  $stmt->bind_param("s", $email);
				  $stmt->bind_result($idFromDB, $firstnameFromDB, $lastnameFromDB);
				  $stmt->execute();
				  $stmt->fetch();
				  $notice = "Sisse logis " .$firstnameFromDB ." " .$lastnameFromDB ."!";
				  //Salvestame kasutaja nime sessiooni muutujasse
				  $_SESSION["userID"] = $idFromDB;
				  $_SESSION["userFirstName"] = $firstnameFromDB;
				  $_SESSION["userLastName"] =$lastnameFromDB;
				  
				  $stmt->close();
				  $conn->close();
				  header("Location: home.php");
				  exit();
				} else {
				  $notice = "Vale salasõna!";
				}
			} else {
				$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
			}
		} else {
		  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
		}
			
		
		$stmt->close();
		$conn->close();
		return $notice;
		//Parooli õigsust kontrollib:
		//if(password_verify($password, $passwordFromDB))
	}

	function profileRead($userID){
		$notice = null;
		$mydescription = null;
		$conn = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $userID);
		$stmt->bind_result($descriptionFromDB, $bgcolorFromDB, $txtcolorFromDB);
		if($stmt->execute()){
			//Päring õnnestus
			if($stmt->fetch()){
				$_SESSION["userDescription"] = $descriptionFromDB;
				$_SESSION["user_bgcollor"] = $bgcolorFromDB;
				$_SESSION["user_txtcollor"] = $txtcolorFromDB;
				$notice = null;
			} else {
				$notice = "Profiil pole veel häälestatud" ."<br>";
				$_SESSION["userDescription"] = null;
				$_SESSION["user_bgcollor"] = "#ffffff";
				$_SESSION["user_txtcollor"] = "#000000";
			}
		} else if($stmt->error){
			$notice = "Profiil lugemisel tekkis tehniline viga!" .$stmt->error ."<br>";
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function ProfileSave($userid, $mydescription, $mybgcolor, $mytxtcolor){
		$notice2 = null;
		$conn = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT id FROM vpuserprofiles WHERE userid = ?");
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($idFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			//profiil juba olemas, uuendame
			$stmt->close();
			$stmt = $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $mydescription, $mybgcolor, $mytxtcolor, $userid);
			if($stmt->execute()){
				$notice2 = "Profiil edukalt uuendatud";
			} else {
				$notice2 = "Profiili uuendamisel tekkis viga";
			}
			//$notice = "Profiil olemas, ei salvestanud midagi!";
		}else { 
			//Profiili pole, salvestame
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?, ?, ?, ?)");
			echo $conn->error;
			
			$stmt->bind_param("isss", $userid, $mydescription, $mybgcolor, $mytxtcolor);
			
			if($stmt->execute()){
				$notice2 = "Profiili häälestamine õnnestus!";
			} else {
				$notice2 = "Profiili salvestamisel tekkis tehniline viga: " .$stmt->error;
			}
		}
		$stmt->close();
		$conn->close();
		return $notice2;
	}