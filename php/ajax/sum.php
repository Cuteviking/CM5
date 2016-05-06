<?php
	include "../key.php";
	$value = $_GET["value"];
	$return = $_GET["return"]
	
	echo json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/".$value."?api_key=".$key), true);//sum
?>