<?php
	require("../../../config_vp2019.php");
	require("functions_main.php");
	require("functions_user.php");
	$database = "if19_mark_gu_1";
	
	$notice = null;
	$name = null;
	$surName = null;
	$email = null;
	$gender = null;
	$birthMonth = null;
	$birthYear = null;
	$birthDay = null;
	$birthDate = null;
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//muutujad võimalike veateadetega
	$nameError = null;
	$surnameError = null;
	$birthMonthError = null;
	$birthYearError = null;
	$birthDayError = null;
	$birthDateError = null;
	$genderError = null;
	$emailError = null;
	$passwordError = null;
	$confirmpasswordError = null;
	
	//FOR TSÜKLI NÄIDIS
	//$i = $i +1;
	//$i
	/*for($i = 0; $i < 10; $i ++){
		echo "Tsükkel: " .$i;
	}*/
	//kui on uue kasutaja loomise nuppu vajutatud
	if(isset($_POST["submitUserData"])){
		//Kui on sisestatud nimi
		if(isset($_POST["firstName"]) and !empty($_POST["firstName"])){
			$name = test_input($_POST["firstName"]);
		} else {
			$nameError = "Palun sisestage eesnimi!";
		} //eesnimi kontrolli lõpp
		
		//Kui on sisestatud perekonnanimi
		if(isset($_POST["surName"]) and !empty($_POST["surName"])){
			$surName = test_input($_POST["surName"]);
		} else {
			$surnameError = "Palun sisestage perekonnanimi!";
		} 
		
		
		//Kui on sisestatud sugu
		if(isset($_POST["gender"]) and !empty($_POST["gender"])){
			$gender = test_input($_POST["gender"]);
		} else {
			$genderError = "Palun valige sugu!";
		} 
		
		//Kui on sisestatud email
		if(isset($_POST["email"]) and !empty($_POST["email"])){
			$email = test_input($_POST["email"]);
		} else {
			$emailError = "Palun sisestage oma email!";
		} 
		
		//ajutine
		//$surName = $_POST["surName"];
		//$gender = $_POST["gender"];
		//$email = test_input($_POST["email"]);
		//strlen($_POST["password"]) <8, siis on viiga
		//
		if(isset($_POST["password"]) and !empty($_POST["password"]) and strlen($_POST["password"]) >=8){
		} else if(strlen($_POST["password"]) <8 and !empty($_POST["password"])) {
			$passwordError = "Liiga lühike salasõna!";
		} else {
			$passwordError = "Palun sisestage salasõna!";
		}
		
		if(isset($_POST["confirmpassword"]) and $_POST["confirmpassword"] == $_POST["password"]){
		} else {
			$confirmpasswordError = "Valesti korratud salasõna";
		} 
		//kontrollime, kas sünniaeg sisestati ja kas on korrektne
		if(isset($_POST["birthDay"]) and !empty($_POST["birthDay"])){
			  $birthDay = intval($_POST["birthDay"]);
		} else {
			  $birthDayError = "Palun vali sünnikuupäev!";
		}
		  
		if(isset($_POST["birthMonth"]) and !empty($_POST["birthMonth"])){
			  $birthMonth = intval($_POST["birthMonth"]);
		  } else {
			  $birthMonthError = "Palun vali sünnikuu!";
		  }
		  
		  if(isset($_POST["birthYear"]) and !empty($_POST["birthYear"])){
			  $birthYear = intval($_POST["birthYear"]);
		  } else {
			  $birthYearError = "Palun vali sünniaasta!";
		  }
		  
		//Kontrollime, kas kuupäev on olemas
		if(!empty($_POST["birthDay"]) and !empty($_POST["birthMonth"]) and !empty($_POST["birthYear"])){
			if(checkdate($birthMonth, $birthDay, $birthYear)){
				$tempDate = new DateTime($birthYear ."-" .$birthMonth ."-" .$birthDay);
				$birthDate = $tempDate->format("Y-m-d");
			} else {
				$birthDateError = "Valitud kuupäev on viigane!";
			}
		} //Kuupäeva valiidsus
		//Kui kõik on korras, salvestame
		if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($birthDateError) and empty($genderError) and empty($emailError) and empty($passwordError) and empty($confirmpasswordError)){
			$notice = signUp($name, $surName, $email, $gender, $birthDate, $_POST["password"]);
		}
			
		
} //Kui on nuppu vajutatud
?>

<!DOCTYPE html>
<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Katselise veebi uue kasutaja loomine</title>
	</head>
	<body>
		<h1>Loo endale kasutajakonto</h1>
		<p>See leht on valminud TLÜ õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
		<hr>
		
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Eesnimi:</label><br>
			<input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError; ?></span><br>
			<label>Perekonnanimi:</label><br>
			<input name="surName" type="text" value="<?php echo $surName; ?>"><span><?php echo $surnameError; ?></span>
			<br>
			<input type="radio" name="gender" value="2" <?php if($gender == "2"){echo " checked";} ?>><label>Naine</label>
			<input type="radio" name="gender" value="1" <?php if($gender == "1"){echo " checked";} ?>><label>Mees</label>
			<br>
			<span><?php echo $genderError; ?></span>
			<br>
			<label> Sünnikuupäev: </label>
			<?php
				//Sünnikuupäev
				echo '<select name="birthDay">' ."\n";
				echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
				for($i=1; $i < 32; $i ++){
					echo "\t \t" .'<option value="' .$i .'"';
					if($i == $birthDay){
						echo " selected";
					}
					echo ">" .$i ."</option> \n";
				}
				echo "\t </select> \n";
			?>
			<label>Sünnikuu: </label>
			<?php
				echo '<select name="birthMonth">' ."\n";
				echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
				for ($i = 1; $i < 13; $i ++){
					echo "\t \t" .'<option value="' .$i .'"';
					if ($i == $birthMonth){
						echo " selected ";
					}
					echo ">" .$monthNamesET[$i - 1] ."</option> \n";
				}
				echo "\t </select> \n";
			?>
			<label>Sünniaasta: </label>
			<?php
				echo '<select name="birthYear">' ."\n";
				echo "\t \t" .'<option value="" selected disabled>aasta</option>' ."\n";
				for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
					echo "\t \t" .'<option value="' .$i .'"';
					if ($i == $birthYear){
						echo " selected ";
					}
					echo ">" .$i ."</option> \n";
				}
				echo "\t </select> \n";
			?>
			<br>
			<span><?php echo $birthDateError ." " .$birthDayError ." " .$birthMonthError ." " .$birthYearError; ?></span>
			
			<label>E-mail (kasutajatunnus):</label><br>
			<input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
			<label>Salasõna (min 8 tähemärki):</label><br>
			<input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
			<label>Korrake salasõna:</label><br>
			<input name="confirmpassword" type="password"><span><?php echo $confirmpasswordError; ?></span><br>
			<input name="submitUserData" type="submit" value="Loo kasutaja"><span><?php echo $notice; ?></span>
		</form>
	<hr>
		
	</body>
</html>