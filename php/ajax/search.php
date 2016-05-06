<?php
	include "../key.php";
	
	$query = $_GET["value"];
	$queryNospace = str_replace(" ","",$query);
	$queryLower = strtolower($queryNospace);
	$queryArray = explode(",", $queryLower);
		
	$result = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/".$queryNospace."?api_key=".$key), true);
	
	for($i=0;$i<count($result);$i++){
		$idArray[] = $result[$queryArray[$i]]["id"];
	}
	$temp = array("[","]");
	$idString = str_replace($temp,"",json_encode($idArray));
	
	echo json_encode(array("data"=> $result,"sum" => array("string" => $queryLower, "array" => $queryArray), "id" => array("string" => $idString, "array" => $idArray)));
?>