<?php
	$userName = "Mark-Krilli";
	$fullTimeNow = date("d.m.Y H:i:s"); //Väike y oleks 19 ja suur - 2019
	$hourNow = date("H"); //Ainult tundi saame
	$partOfDay = "hägune aeg";
	if($hourNow < 8){
		$partOfDay = "varane hommik";
	}
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
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu! </p> <!--Ükski tekst ei veedele niisama-->
		
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
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 