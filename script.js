$(document).ready(function(){
	$(".flex-Container").hide();
});

$(document).ready(function(){
	$(".fame").click(function(){
		$($(this).next('.flex-Container')).slideToggle();
	});
});

function checkIt(){
	var x = document.getElementsByClassName("choice");
	x[0].checked = true;
};

window.onload = checkIt;
