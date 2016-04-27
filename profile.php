<?php
	include "php/key.php";
	
	
	$query = $_GET["return"];
	$type = $_GET["type"];
	
	//champ CM player
	$average = json_decode(file_get_contents("php/results.json"), true);
	
	
	//borde vara i js ist 
	if($type == "sum"){
		//query
		$sumIdRequest = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/".$query."?api_key=".$key), true);//sum
		$sumChampList = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$query."/topchampions?api_key=".$key), true);//top champs
		$sumPoints = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$query."/score?api_key=".$key), true);//cm lvl
		//$sumStats = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$query."/ranked?season=SEASON2016&api_key=".$key), true);
		
		//average
		$avarageStatsChamp;
		//0 = best champ
		for($i=0;$i<count($average[$sumChampList[0]["championId"]][$sumChampList[0]["championLevel"]]);$i++){//count($average[$sumChampList[0]["championId"]][$sumChampList[0]["championLevel"]])
			sleep(1);
			$averageStats = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/".$average[$sumChampList[0]["championId"]][$sumChampList[0]["championLevel"]][$i]["playerId"]."/ranked?season=SEASON2016&api_key=".$key), true);

			for($j=0;$j<count($averageStats["champions"]);$j++){
				if($averageStats["champions"][$j]["id"] == $sumChampList[0]["championId"]){
					$avarageStatsChamp[] = $averageStats["champions"][$j]["stats"];//stats from all the challenger players with same champs as sum ($query) with CM:5
				}	
			}
		}
		
		echo json_encode($avarageStatsChamp);
		echo "<br>";

	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CM5</title>
<script src="js/stats.js"></script>
</head>

<body>
<main class="profile">
	<div>
	<?php
		echo $sumIdRequest[$query]["name"];
		echo $sumPoints;
	?>
	</div>
</main>
<div class="wrapper">
	<section class="sum">
    	<div class="top">
        <?php
        	for($i=0;$i<3;$i++){
				$champName =json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion/".$sumChampList[$i]["championId"]."?api_key=".$key), true);
		?>
        		<div class="champ">
        			<img src="http://ddragon.leagueoflegends.com/cdn/6.8.1/img/champion/<?php echo $champName["name"]; ?>.png" alt="<?php echo $champName["name"]; ?>">
        			<h4><?php echo $champName["name"]; ?></h4>
        			<span><?php echo $sumChampList[$i]["championPoints"]; ?></span>
        		</div>
				
        <?php
			}
		?>
        </div>
    </section>
	<section class="champ">
    	<ul class="list">
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    	</ul>
    	<ul class="list">
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    	</ul>
    	<ul class="list">
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    		<li></li>
    	</ul>
    </section>
</div>


</body>
</html>