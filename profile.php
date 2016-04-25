<?php
	include "php/key.php";
	
	
	$query = $_GET["return"];
	$type = $_GET["type"];
	
	if($type == "sum"){
		$sumIdRequest = json_decode(file_get_contents("https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/".$query."?api_key=".$key), true);
		$sumChampList = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$query."/champions?api_key=".$key), true);
		$sumPoints = json_decode(file_get_contents("https://euw.api.pvp.net/championmastery/location/EUW1/player/".$query."/score?api_key=".$key), true);
		
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CM5</title>
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
    	<ul class="campList">
        <?php
        	for($i=3;$i<count($sumChampList);$i++){
				echo "<li>".$sumChampList[$i]["championId"]."</li>";
			}
		?>
        </ul>
    </section>
	<section class="champ">
    </section>
</div>


</body>
</html>