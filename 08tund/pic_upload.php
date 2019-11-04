<?php
	require("../../../config_vp2019.php");
	require("functions_user.php");
	require("functions_main.php");
	require("functions_pic.php");
	//Võtan kasutusele oma testklassi
	require("classes/Test.class.php");
	$database = "if19_mark_gu_1";
	$notice = null;
	$noticeRead = null;

	
	//Kui pole sisse loginud
	if(!isset($_SESSION["userID"])){
		//Siis jõuga sisselogimise lehele
		header("Location: page.php");
		exit();
	}
	
	//Välja logimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	//Kasutan oma testklassi
	$myTest = new Test();
	
	$userName = $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"];
	
	$noticeRead = profileRead($_SESSION["userID"]);	
	
	//$target_dir = "uploads/";

	$notice = null;
	$fileName = "vp_";
	$picMaxW = 600;
	$picMaxH = 400;
	
	//pic upload algab
	if(isset($_POST["submitPic"])){
		var_dump($_FILES["fileToUpload"]);
		//$target_file = $pic_upload_dir_orig . basename($_FILES["fileToUpload"]["name"]);
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
		//failinime jaoks ajatempel
		$timeStamp = microtime(1) * 10000;
		$fileName .= $timeStamp ."." .$imageFileType;
		$target_file = $pic_upload_dir_orig .$fileName;
		
		$uploadOk = 1;
		// Kas on üldse pilt
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$notice = "Ongi pilt - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$notice = "Ei ole pilt.";
			$uploadOk = 0;
		}
		// Faili olemasolu kontroll
		if (file_exists($target_file)) {
			$notice = "Pilt on juba serveris.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2500000) {
			$notice = "Pilt on liiga suur.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$notice = "Kahjuks on lubatud ainult JPG, JPEG, PNG ja GIF failid.";
			$uploadOk = 0;
		}
		
		//Suuruse muutmine
		//Loome ajutise "pildiobjekti" - image
		if($imageFileType == "jpg" or $imageFileType == "jpeg"){
			$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
		}
		if($imageFileType == "gif"){
			$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
		}
		if($imageFileType == "png"){
			$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
		}
		//Pildi originaalmõõt
		$imageW = imagesx($myTempImage);
		$imageH = imagesy($myTempImage);
		//Kui on liiga suur
		if($imageW > $picMaxW or $imageH > $picMaxH){
			//Muudamegi suurust
			if($imageW / $picMaxW > $imageH / $picMaxH){
				$picSizeRatio =  $imageW/ $picMaxW;
			} else {
				$picSizeRatio =  $imageH/ $picMaxH;
			}
			//Loome uue "pildiobjekti" juba uute mõõtudega
			$newW = round($imageW / $picSizeRatio, 0);
			$newH = round($imageH / $picSizeRatio, 0);
			$myNewImage = setPicSize($myTempImage, $imageW, $imageH, $newW, $newH);
			//Salvestan vähendatud pildi faili
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				if(imagejpeg($myNewImage, $pic_upload_dir_w600 .$fileName, 90)){
					$notice = "Vähendatud pildi salvestamine õnnestus";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus";
				}
			}
			if($imageFileType == "png"){
				if(imagepng($myNewImage, $pic_upload_dir_w600 .$fileName, 6)){
					$notice = "Vähendatud pildi salvestamine õnnestus";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus";
				}
			}
			if($imageFileType == "gif"){
				if(imagegif($myNewImage, $pic_upload_dir_w600 .$fileName)){
					$notice = "Vähendatud pildi salvestamine õnnestus";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus";
				}
			}
			
		} //Kui liiga suur lõppeb
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$notice = "Kahjuks faili üles ei laeta.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$notice .= "Originaalfail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles.";
			} else {
				$notice = "Vabandame, originaalfaili ei õnnestunud üles laadida.";
			}
			imagedestroy($myTempImage);
			imagedestroy($myNewImage);
		}
	}
	//pic upload lõppeb
	
	require("header.php");
?>


	<body> <!--See, mis on näha lehel, kohustuslike elemente pole-->
		<?php
			echo "<h1>" .$userName . " piltide häälestamisleht </h1>";
		?>
		<p> See leht on loodud koolis õppetöö raames 
		ja ei sisalda tõsiseltvõetavat sisu. </p> <!--Ükski tekst ei veedele niisama-->
		<hr>
		<p><a href="?logout=1">Logi välja! </a> | <a href="home.php"> Koduleht </a></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
			<label>Vali üleslaetav pilt!</label> 
			<br>
			<label>Alt tekst: </label><>
			<input type="file" name="fileToUpload" id="fileToUpload"> <br>
			<input name="submitPic" type="submit" value="Lae pilt üles"> <span> <?php echo $notice;?></span> <br>
		</form>
	</body>
</html>

<!-- PHP SAAB SISALDADA ENDAS SUURE HULKA HTML-i --> 