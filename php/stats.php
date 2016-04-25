<?php
	include "key.php";
	$statsChallenger = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$key), true);
	
	for($i=0;$i<1;$i++){ /*count($statsChallenger["entries"]): 1 for testing*/
		$statsChallengerChamps = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/ranked?season=SEASON2016&api_key=".$key), true);
		
		for($j=0;$j<1;$j++){ /*count($statsChallengerChamps["champions"]): 1 for testing */
			echo $statsChallengerChamps["champions"][$j]["id"]."<br>";
			
			$statsChallengerChampsData = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$statsChallenger["entries"][$i]["playerOrTeamId"]."/champion/".$statsChallengerChamps["champions"][$j]["id"]."?api_key=".$key), true);
			
			echo $statsChallengerChampsData["championLevel"]." 3<br>";
			echo $statsChallengerChamps["champions"][$j]["stats"]["maxChampionsKilled"]." 2<br>";
			echo $statsChallengerChamps["champions"][$j]["stats"]["maxNumDeaths"]." 1<br>";
			
			/*"champ":{"CM":{1:{"kills":"antal","death":"antal","assist":"antal","CS":"antal"},2:{},3:{},4:{},5:{}}}*/
			
			
		}
		
	}
?>