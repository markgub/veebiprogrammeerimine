<?php
	$userName = "Mark-Krilli";
	$fullTimeNow = date("d.m.Y H:i:s"); //Väike y oleks 19 ja suur - 2019
	$hourNow = date("H"); //Ainult tundi saame
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
		$welcome = "Tere! Mida Teie teete siin ni hilja?";
		$partOfDay = "öö";
	} //Võib-olla oleks parem kasutada siin switch funktsiooni
?>

<!DOCTYPE html>
<html lang = "et">
	<head> <!--Sisu ei paista tavaliselt, siin asuvad kohustuslikud elementid-->
		<meta charset = "utf-8">
		<title> Wenepooh on kollane </title>

	</head>
	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " koolitöö leht </h1>";
			echo nl2br($welcome);
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		
		<p> Kasutame php serverit, mille kohta saaab infot <a href="serverinfo.php">siit<a>! </p>
		<hr>
		<p> Lehe avamise hetkel oli aeg: 
		<?php
			echo $fullTimeNow;
		?>
		.</p>
		<?php
			echo "<p> Lehe avamise hetkel oli " .$partOfDay .".</p>";
		?>
		<hr>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 