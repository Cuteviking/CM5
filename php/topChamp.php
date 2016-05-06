<?php
	include "key.php";
	
	//players
	$challengers = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$key), true);
	
	//get saved data
	$results = json_decode(file_get_contents("json/results.json"), true);
	
	//by score
	for($i=0;$i<1;$i++){//count($challengers["entries"])
		sleep(2);//not to hit the cap
		$score = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$challengers["entries"][$i]["playerOrTeamId"]."/score?api_key=".$key), true);
		
		if($score != null){
			prog("By score: ".$i);
			
			//add: if playerOrTeamId isset just update score
			//this can be in a function...
			if(isset($results["score"]["byScore"])){// is there a byPoints?
				$sumIdIsset = false;
				for($j=0;$j<count($results["score"]["byScore"]);$j++){ //check if current playerOrTeamId is in there
					if($results["score"]["byScore"][$j]["sum"] == $challengers["entries"][$i]["playerOrTeamId"]){
						$sumIdIsset = true;
						$results["score"]["byScore"][$j]["data"] = $score;
					}
				}
				if($sumIdIsset == false){//if not add one last
					$results["score"]["byScore"][] = array("data" => $score, "sum" => $challengers["entries"][$i]["playerOrTeamId"]);		
				}
			}else{
				$results["score"]["byScore"][] = array("data" => $score, "sum" => $challengers["entries"][$i]["playerOrTeamId"]);	
			}
			
			//by champ Id
			$results["profile"][$challengers["entries"][$i]["playerOrTeamId"]]["byScore"] = array("data" => $score);
			}	
	}
	
	
	//sorting algoritm 
	$results["score"]["byScore"] = sorting($results["score"]["byScore"]);
	
	
	
	
	
	//by points & by champ 
	//Note: the order for /champions and /topchampions are the same, highest championPoints
	
	for($i=0;$i<1;$i++){//count($challengers["entries"])
		sleep(2);// to not hit the cap
		$champions = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$challengers["entries"][$i]["playerOrTeamId"]."/champions?api_key=".$key), true);
		
		if($champions != null){
			//by points
			$championPointsTotal = 0;// reset of points
			for($j=0;$j<count($champions);$j++){
				$championPointsTotal = $championPointsTotal + $champions[$j]["championPoints"];	
				prog("By points: ".$i. " " .$j);
			}
			
			
			//add: if playerOrTeamId isset just update championPoints
			if(isset($results["score"]["byPoints"])){// is there a byPoints?
				$sumIdIsset = false;
				for($j=0;$j<count($results["score"]["byPoints"]);$j++){ //check if current playerOrTeamId is in there
					if($results["score"]["byPoints"][$j]["sum"] == $challengers["entries"][$i]["playerOrTeamId"]){
						$sumIdIsset = true;
						$results["score"]["byPoints"][$j]["data"] = $championPointsTotal;
					}
				}
				if($sumIdIsset == false){//if not add one last
					$results["score"]["byPoints"][] = array("data" => $championPointsTotal, "sum" => $challengers["entries"][$i]["playerOrTeamId"]);		
				}
			}else{
				$results["score"]["byPoints"][] = array("data" => $championPointsTotal, "sum" => $challengers["entries"][$i]["playerOrTeamId"]);	
			}
			
			//by champ Id
			$results["profile"][$challengers["entries"][$i]["playerOrTeamId"]]["byPoints"] = array("data" => $championPointsTotal);
			
			//by champ
			//0 = highest 
			
			
			//add: if playerOrTeamId isset just update championPoints
			//this can be in a function...
			if(isset($results["score"]["byChamp"])){// is there a byPoints?
				$sumIdIsset = false;
				for($j=0;$j<count($results["score"]["byChamp"]);$j++){ //check if current playerOrTeamId is in there
					if($results["score"]["byChamp"][$j]["sum"] == $challengers["entries"][$i]["playerOrTeamId"]){
						$sumIdIsset = true;
						$results["score"]["byChamp"][$j]["data"] = $champions[0]["championPoints"];
					}
				}
				if($sumIdIsset == false){//if not add one last
					$results["score"]["byChamp"][] = array("data" => $champions[0]["championPoints"], "championId" => $champions[0]["championId"],  "sum" => $challengers["entries"][$i]["playerOrTeamId"]);		
				}
			}else{
				$results["score"]["byChamp"][] = array("data" => $champions[0]["championPoints"], "championId" => $champions[0]["championId"], "sum" => $challengers["entries"][$i]["playerOrTeamId"]);	
			}
			
			//by champ Id
			$results["profile"][$challengers["entries"][$i]["playerOrTeamId"]]["byChamp"] = array("data" => $champions[0]["championPoints"], "championId" => $champions[0]["championId"]);
			
			prog("By champ: ".$i);
		
		}
	}
	
	//sorting algoritm 
	$results["score"]["byPoints"] = sorting($results["score"]["byPoints"]);
	//sorting algoritm 
	$results["score"]["byChamp"] = sorting($results["score"]["byChamp"]);
	
	//last update
	$results["lastUpdate"] = time();
	
	$fp = fopen('json/results.json', 'w');
	fwrite($fp, json_encode($results));
	fclose($fp);
	
	echo json_encode($results, JSON_PRETTY_PRINT);
	
//functions	
function prog($value){//just developer things 
	$fp = fopen('json/prog.txt', 'w');
	fwrite($fp, json_encode($value));
	fclose($fp);
}

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