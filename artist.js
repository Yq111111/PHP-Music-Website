var a = document.getElementById("dom-target-follow");
if(a.textContent == 1){
	var button = document.getElementById("id-for-follow");
	button.style = "display:none";
}else{
	var button = document.getElementById("id-for-unfollow");
	button.style = "display:none";
}