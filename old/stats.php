<?php
	/*This is just a theoretical test to collect data for testing and order the data based on Champion => Champion Mastery. This is not practical to load every time the page loads.
	
	 challenger list + amount of players * amount of champs
	 1 + 200 (if every player plays every champ)
	 with the cap of 500 request every 10 min
	 */
		

	include "../php/key.php";
	$statsChallenger = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$key), true);
	
	/*get players*/
	for($i=0;$i<count($statsChallenger["entries"]);$i++){/*count($statsChallenger["entries"])*/ 
		sleep(1);//to avoid the  10 calls in 10 secounds cap
		$playersTopChamp = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/champions?api_key=".$key), true);
		
		for($j=0;$j<count($playersTopChamp);$j++){//count($playersTopChamp)
		
			$result[$playersTopChamp[$j]["championId"]][$playersTopChamp[$j]["championLevel"]][] = $playersTopChamp[$j];
		}
		
	}
	
	$output = array("data" => $result, "lastUpdate" => time());
	
	echo JSON_encode($output, JSON_PRETTY_PRINT);
	
	/*$fp = fopen('json/results.json', 'w');
	fwrite($fp, json_encode($result));
	fclose($fp);*/
	
	//move this to stats.js and playerStats.php
			//$statsChallengerChamps = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/ranked?season=SEASON2016&api_key=".$key), true);
		
		
		//data from eatch players total ($j = 0)
?>