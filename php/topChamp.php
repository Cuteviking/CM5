<?php
	include "key.php";
	
	//players
	$challengers = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$key), true);
	
	//get saved data
	$results = json_decode(file_get_contents("json/results.json"), true);
	
	//by score
	for($i=0;$i<5;$i++){//count($challengers["entries"])
		sleep(2);
		$score = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$challengers["entries"][$i]["playerOrTeamId"]."/score?api_key=".$key), true);
		$results[$challengers["entries"][$i]["playerOrTeamId"]] = ["score" => $score];
		prog("By score: ".$i);
		if($score == null){
			exit;
		}
	}
	
	
	//by points
	for($i=0;$i<5;$i++){//count($challengers["entries"])
		sleep(2);
		$champions = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$challengers["entries"][$i]["playerOrTeamId"]."/champions?api_key=".$key), true);
		
		for($j=0;$j<count($champions);$j++){
			$championPointsTotal = $championPointsTotal + $champions[$j]["championPoints"];	
			prog("By points: ".$i. " " .$j);
		}
		
		$results[$challengers["entries"][$i]["playerOrTeamId"]] = ["championPointsTotal" => $championPointsTotal];
		if($score == null){
			exit;
		}
	}
	
	/*$fp = fopen('json/results.json', 'w');
	fwrite($fp, json_encode($results));
	fclose($fp);*/
	
	echo json_encode($results, JSON_PRETTY_PRINT);
	
	
function prog($value){
	$fp = fopen('json/prog.txt', 'w');
	fwrite($fp, json_encode($value));
	fclose($fp);
}
	//$topChampions = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$challengers["entries"][$i]["playerOrTeamId"]."/topchampions?api_key=".$key), true);
?>