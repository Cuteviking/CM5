/*
collect data from result.json
only calls for one champ at the time 
*/

function init(){
	listeners();
}

function listeners(){
	/*var champList = document.getElementById("champList");
	for(var i=0;i<champList.children.length;i++){
		champList.children[i].addEventListener("click", function(){	
			
			stats(champList.children[i].dataset.champ);	//skriv om så de måste söka på champen de vill använda. 
		});
	}*/
}


function stats(id){
	console.log(id);
}

/*ajax*/
function ajax(url){
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
				return JSON.parse(XHR.responseText);
			} 
			else {

			}
		}
	}
	
	XHR.open("GET", url, true);
	XHR.send(null);
}

window.addEventListener("load", init);