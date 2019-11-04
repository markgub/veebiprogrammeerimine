<?php
$HTMLcode = "<html lang = 'et'> ";
$HTMLcode .= "<head> ";
$HTMLcode .= "<meta charset = 'utf-8'> ";
$HTMLcode .= "<style> ";
$HTMLcode .= "body{background-color: " .$_SESSION["user_bgcollor"] ."; ";
$HTMLcode .= "color: " .$_SESSION["user_txtcollor"] ." ";
$HTMLcode .= "</style> ";
$HTMLcode .= "<title> Wenepooh on kollane </title> ";
$HTMLcode .= "</head>";
echo $HTMLcode;
?>