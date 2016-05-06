/*
collect data from results.json
only calls for one champ at the time 
updates champ in query

*/

function init(){
	ajax("php/json/results.json", resultsResponse);
	
	document.getElementById("search").addEventListener("submit", changeUser);
}

function changeUser(event){
		event.preventDefault();
		ajax("php/ajax/search.php?value="+document.getElementById("search")[0].value, changeUserResponse);
}

function changeUserResponse(XHR){
	for(var i=0;i<XHR["data"].length;i++){
		ajax("php/ajax/data.php?value="+XHR["data"][XHR["sum"]["array"][i]]["id"],dataResponse);
	}
	//rename url
	
	window.history.pushState("object or string", "Title","?return="+XHR["id"]["string"]);
	//mark with css
	//profile
}


function resultsResponse(XHR){
	//load query
	var query = url();
	
	//check user to list
	if(!XHR["profile"][query]){
		console.log(true);
		for(var i=0;i<query.length;i++){
			ajax("php/ajax/data.php?value="+query[i],dataResponse);	
		}
	}
	//load list
	var lists = [	
		document.getElementById("byScore"),
		document.getElementById("byPoints"),
		document.getElementById("byChamp")
	];
	
	for(var i=0;i<lists.length;i++){
		for(var j=XHR["score"][lists[i]["id"]].length-1;j>-1;j--){ 
			//replace id with name
			
			//http://ddragon.leagueoflegends.com/cdn/6.9.1/img/champion/Aatrox.png		
			
			if(lists[i]["id"] == "byChamp"){

				lists[i].innerHTML += "<li><img src='http://ddragon.leagueoflegends.com/cdn/6.9.1/img/champion/"+XHR["score"][lists[i]["id"]][j]["image"]+"'/><span>"+XHR["score"][lists[i]["id"]][j]["sum"]+"</span>: <span>"+XHR["score"][lists[i]["id"]][j]["data"]+"</span></li>";
			}else{
				lists[i].innerHTML += "<li><span>"+XHR["score"][lists[i]["id"]][j]["sum"]+"</span>: <span>"+XHR["score"][lists[i]["id"]][j]["data"]+"</span></li>";
			}	
		}
	}	
}

function url(){
	var url = location.search;
	url = url.split("=");
	var urlList = url[1].split(",");
	return urlList;
}

function dataResponse(XHR){
	//add to list 
	
	//load list
	var lists = [	
		document.getElementById("byScore"),
		document.getElementById("byPoints"),
		document.getElementById("byChamp")
	];
	
	for(var i=0;i<lists.length;i++){ 
		//replace id with name
		
		if(lists[i]["id"] == "byChamp"){
			console.log(XHR["data"][lists[i]["id"]]["image"]);
			lists[i].innerHTML = "<li><img src='http://ddragon.leagueoflegends.com/cdn/6.9.1/img/champion/"+XHR["data"][lists[i]["id"]]["image"]+"'/><span>"+XHR["sum"]+"</span> : <span>"+XHR["data"][lists[i]["id"]]["data"]+"</span></li>" + lists[i].innerHTML;
		}else{
			lists[i].innerHTML = "<li><span>"+XHR["sum"]+"</span> : <span>"+XHR["data"][lists[i]["id"]]["data"]+"</span></li>" + lists[i].innerHTML;
		}
		
		for(var j=0;j<lists[i].children.length-1;j++){
			//if value is more or less
			if(Number(lists[i].children[j].lastChild.innerHTML)<=Number(lists[i].children[j+1].lastChild.innerHTML)){	
				var temp = lists[i].children[j].innerHTML;
				lists[i].children[j].innerHTML = lists[i].children[j+1].innerHTML;
				lists[i].children[j+1].innerHTML = temp; 
			}
		}
	}
	
	console.log("done");
}

/*ajax*/
function ajax(url, callback){
	var XHR = null;
	if (XMLHttpRequest) {
		XHR = new XMLHttpRequest();
	} 
	else {
		XHR = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	XHR.onreadystatechange = function () {
		if (XHR.readyState == 4 || XHR.readyState == "complete") {
			if (XHR.status == 200) {
				console.log(XHR.responseText);
				callback(JSON.parse(XHR.responseText));
			} 
			else {

			}
		}
	}
	
	XHR.open("GET", url, true);
	XHR.send(null);
}

window.addEventListener("load", init);