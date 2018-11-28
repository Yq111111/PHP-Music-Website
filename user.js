
var userid = document.getElementById("dom-target-uid");
var uid = document.getElementById("dom-target-userid");


if(userid.textContent == uid.textContent){
	var button1 = document.getElementById("id-for-follow");
	var button2 = document.getElementById("id-for-unfollow");
	button1.style = "display:none";
	button2.style = "display:none";
}else{
	var a = document.getElementById("dom-target-follow");
	if(a.textContent == 1){
		var button = document.getElementById("id-for-follow");
		button.style = "display:none";
	}else{
		var button = document.getElementById("id-for-unfollow");
		button.style = "display:none";
	}	
}

