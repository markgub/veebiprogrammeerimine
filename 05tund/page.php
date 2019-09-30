<?php
	$userName = "Mark-Krilli";
	$photoDir = "../photos/";
	$picFileTypes = ["image/jpeg", "image/png"];
	
	//Nädalapäevad
	$daysOfWeekET = ["esmaspäev", "teisipäev", "kolpmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//12Kuud
	$monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//Praegune aeg
	$monthNow = date("n");
	$fullTimeNow = date("d") .". " .$monthsET[$monthNow-1] ." " .date("Y H:i:s"); //Väike y oleks 19 ja suur - 2019
	$hourNow = date("H"); //Ainult tundi saame
	$dayNow = date("N");
	$partOfDay = "hägune aeg";
	$welcome = "Tere";
	if($hourNow >= 6 and $hourNow < 12){
		$welcome = "Tere hommikust!";
		$partOfDay = "hommik";
	}  elseif ($hourNow == 12){
		$welcome = "Tervist! \r\nPraegu on hea aeg selleks, et võtta endale lõunat!";
		$partOfDay = "lõuna aeg";
	} elseif ($hourNow < 18 and $hourNow > 12) {
		$welcome = "Tere päevast!";
		$partOfDay = "pärastlõuna";
	} elseif ($hourNow >= 18){
		$welcome = "Tere õhtust!";
		$partOfDay = "õhtu";
	} elseif ($hourNow < 6){
	$welcome = "Tere! \r\nMida Teie teete siin ni hilja?";
		$partOfDay = "öö";
	} //Võib-olla oleks parem kasutada siin switch funktsiooni
	
	//info semestri kulgemise kohta
	$semesterStart = new DateTime("2019-9-2");
	$semesterEnd = new DateTime("2019-12-13");
	$semesterDuration = $semesterStart->diff($semesterEnd);
	$today = new DateTime("now");
	$fromSemesterStart = $semesterStart->diff($today);
	//var_dump($fromSemesterStart); //echo-ga saab väljastada stringe ja arve, mitte objekti
	$semesterInfoHTML = "<p>ERROR: Siin peaks olema info semestri kulgemise kohta!</p>";
	$elapsedValue = $fromSemesterStart->format("%r%a");
	$durationValue = $semesterDuration->format("%r%a");
	//echo $testValue;
	//<meter min="0" max="155" value="55">Mingi väärtus</meter> Eeskuju
	if($elapsedValue > 0 and $elapsedValue <= $durationValue){
		$semesterInfoHTML = "<p>Semester on täies hoos: ";
		$semesterInfoHTML .= '<meter min="0" max="' .$durationValue .'" '; //Peab olema tühik
		$semesterInfoHTML .= 'value="' .$elapsedValue .'">';
		$semesterInfoHTML .= round($elapsedValue/$durationValue*100, 1) ."%";
		$semesterInfoHTML .= "</meeter>";
		$semesterInfoHTML .= "</p>";
	} elseif($elapsedValue > $durationValue) {
		$semesterInfoHTML = "<p>Semester on lõppenud.</p>";
	} elseif($elapsedValue < 0){
		$semesterInfoHTML = "<p>Semester ei ole veel alanud.</p>";
	} else {
		$semesterInfoHTML = "<p>ERROR: Siin peaks olema info semestri kulgemise kohta!</p>"; 
	}
	
	//foto lisamine lehel
	$allPhotos = [];
	$dirContent = array_slice(scandir($photoDir), 2);
	//var_dump($dirContent);
	foreach ($dirContent as $file){
		$fileInfo = getimagesize($photoDir .$file);
		//var_dump($fileInfo);
		if(in_array($fileInfo["mime"], $picFileTypes) == true){
			array_push($allPhotos, $file);
		}
	}
	
	//var_dump($allPhotos);
	$picCount = count($allPhotos);
	$picNum = mt_rand(0,($picCount-1)); //parameetrid on valikulised
	//echo $allPhotos[$picNum];
	$photoFile = $photoDir .$allPhotos[$picNum];
	$randomImgHTML = '<img src="' .$photoFile .'" alt="TLÜ Terra õppehoone">'; //Ülekomad on ebamugavad
	
	//lisame lehe päise
	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " koolitöö leht </h1>";
			echo nl2br($welcome);
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<?php
		echo $semesterInfoHTML;
		?>
		<p> Kasutame php serverit, mille kohta saaab infot <a href="serverinfo.php">siit<a>! </p>
		<hr>
		<p> Lehe avamise hetkel oli aeg: 
		<?php
			echo $daysOfWeekET[$dayNow-1]. " ". $fullTimeNow;
		?>
		.</p>
		<?php
			echo "<p> Lehe avamise hetkel oli " .$partOfDay .".</p>";
		?>
		<hr>
		<?php
		echo $randomImgHTML;
		?>
		<!--<img src="../photos/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone"> Tühi element, pole vaja lõpetada-->
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 