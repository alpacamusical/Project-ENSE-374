function preventInput(event){
	
	var string = event.currentTarget;
	// input button is string[0]
	//text area is string[1]
	 var a = string[1].value; 
	//Can be any symbol,letter or number. 1 to 15 characters;
	var watchlist_v = /^[A-Za-z0-9\s$&+,:;=?@#|'<>.^*()%!-]{1,15}$/;
	
	if (a==null || a==""||!watchlist_v.test(a))
        {	   
	 			event.preventDefault();
        }
}


function onSubmit(event) {

   var test = confirm("Are you sure you want to delete this list?");
   if (test == false)
   {
   	event.preventDefault();
   }
   
}

//Dynamic Character counter.
function dynamiccharcount(str) {
	var count = str.length;
	var max = 15;

	if (count <= 15)
	{
		document.getElementById("charsleft").innerHTML = max - count + " characters left" ;
		document.getElementById("charsleft").style.color = "black";
		 document.getElementById("watchlistcreate").style.borderColor = "black";
	}
	if (count > 15)
	{
	
		document.getElementById("charsleft").innerHTML = "Maximum Watchlist Length Exceeded by " + (count-max) + " characters.";
		document.getElementById("charsleft").style.color = "red";
	   document.getElementById("watchlistcreate").style.borderColor = "red";
	}
}
