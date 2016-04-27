<?php 
	include "../key.php";
	
	return $json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$_GET["id"]."/ranked?season=SEASON2016&api_key=".$key), true);
?>