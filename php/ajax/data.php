<?php
	include "../key.php";
	$value = $_GET["value"];
	$results = json_decode(file_get_contents("../json/results.json"), true);
	 
	$score = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$value."/score?api_key=".$key), true);
	$sumName = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/".$value."?api_key=".$key), true);
		
	if($score != null){
		$results["score"]["byScore"][] = array("data" => $score, "sum" => $sumName[$value]["name"]);	
		
		//by champ Id
		$results["profile"][$value]["byScore"] = array("data" => $score);
	}	

	//sorting algoritm 
	$results["score"]["byScore"] = sorting($results["score"]["byScore"]);
	
	
	//by points & by champ 
	//Note: the order for /champions and /topchampions are the same, highest championPoints

	$champions = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$value."/champions?api_key=".$key), true);
	$championData = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion/".$champions[0]["championId"]."?champData=image&api_key=".$key), true);
		
	
	if($champions != null){
		//by points
		$championPointsTotal = 0;// reset of points
		for($j=0;$j<count($champions);$j++){
			$championPointsTotal = $championPointsTotal + $champions[$j]["championPoints"];	
		}
		
		$results["score"]["byPoints"][] = array("data" => $championPointsTotal, "sum" => $sumName[$value]["name"]);	
		
		//by champ Id
		$results["profile"][$value]["byPoints"] = array("data" => $championPointsTotal);
		
		//by champ
		//0 = highest 
		$results["score"]["byChamp"][] = array("data" => $value, "championId" => $champions[0]["championId"], "sum" => $sumName[$value]["name"], "image" => $championData["image"]["full"]);	
		
		//by champ Id
		$results["profile"][$value]["byChamp"] = array("data" => $champions[0]["championPoints"], "championId" => $champions[0]["championId"], "image" => $championData["image"]["full"]);
	}
	
	
	//sorting algoritm 
	$results["score"]["byPoints"] = sorting($results["score"]["byPoints"]);
	//sorting algoritm 
	$results["score"]["byChamp"] = sorting($results["score"]["byChamp"]);
	
	//last update
	$results["lastUpdate"] = time();
	
	$fp = fopen('../json/results.json', 'w');
	fwrite($fp, json_encode($results));
	fclose($fp);
	
	echo json_encode(array("sum" => $sumName[$value]["name"] , "data" => $results["profile"][$value]));
	
//functions	
function sorting($value){
	//sorting algoritm 
	//can be a function
	$temp = [];
	for($i=0;$i<count($value);$i++){
		$temp[] = $value[$i]["data"];
	}
	array_multisort($temp,$value);
	
	return $value;
}

?>