<?php
	include "key.php";
	
	$query = $_GET["q"];
	$queryUcfirst = ucfirst($query);
	$queryNospace = str_replace(" ","",$query);
	
	/*todo: if no q*/
	$champNameRequest = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?api_key=".$key), true);
		
	if(isset($champNameRequest["data"][$queryUcfirst])){
		$return = $champNameRequest["data"][$queryUcfirst]["id"];
		$type = "champ";
	}else{
		$sumNameRequest = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/".$queryNospace."?api_key=".$key), true);
		if(isset($sumNameRequest[$queryNospace])){
			$return = $sumNameRequest[$queryNospace]["id"];
			$type = "sum";
		}else{
			header('Location: index.php?error=404');
		}
	}
	
	
	
	header('Location: ../profile.php?return='.$return.'&type='.$type);
?>