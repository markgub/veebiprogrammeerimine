<?php
	function setPicSize($myTempImage, $imageW, $imageH, $newW, $newH){
		$newImage = imagecreatetruecolor($newW, $newH);
		imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);
		return $newImage;
	}
	
	function addPicData($filename, $altText, $privacy){
		$notice = null;
		$conn = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userID"], $filename, $altText, $privacy);
		if($stmt->execute()){
			$notice = "Kõik on OK";
		} else {
			$notice = "Kõik ei ole OK " .$stmt->error;
		}

		$stmt->close();
		$conn->close();
		return $notice;
	}