<?php
	/*This is just a theoretical test to collect data for testing. This is not practical to load every time the page loads.*/
	/* 
	 * challenger list + amount of players * amount of champs
	 * 1 + 200 * 130(if every player plays every champ)
	 * with the cap of 500 request every 10 min
	 * 
	 */
		

	include "key.php";
	$statsChallenger = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$key), true);
	
	/*get players*/
	for($i=0;$i<count($statsChallenger["entries"]);$i++){/*count($statsChallenger["entries"])*/ 
		sleep(2);
		
		$statsChallengerChamps = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/ranked?season=SEASON2016&api_key=".$key), true);
		
		/*get players champions*/
		/* $j = 0 : total of a player*/
		for($j=1;$j<count($statsChallengerChamps["champions"]);$j++){ /*count($statsChallengerChamps["champions"])*/
			sleep(5);
			
			/*get CM on players champions*/
			$statsChallengerChampsData = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/champion/".$statsChallengerChamps["champions"][$j]["id"]."?api_key=".$key), true);
			
			/*that champ with that CM with that stats*/
			/**/
			
			$stats = array(
				"data" => array(
					"stats" => $statsChallengerChamps["champions"][$j]["stats"]
				),
				"champ" => $statsChallengerChamps["champions"][$j]["id"],
				"sum" => $statsChallenger["entries"][$i]["playerOrTeamId"]
			);
			
			$result[$statsChallengerChamps["champions"][$j]["id"]][$statsChallengerChampsData["championLevel"]][] = $stats;
			echo $i .": ".$j;
		}
		/*data from eatch players total ($j = 0)*/
		$total[] = array($statsChallengerChamps["champions"][0],"sum" => $statsChallenger["entries"][$i]["playerOrTeamId"]);
		
	}
	
	$output = array("eatch" => $result, "total" => $total, "lastUpdate" => time());
	
	echo "<br>";
	echo JSON_encode($output, JSON_PRETTY_PRINT);
	
	$fp = fopen('results.json', 'w');
	fwrite($fp, json_encode($result));
	fclose($fp);
	
?>