
function textBoxUnhide() {
  var x = document.getElementById("writereviewdiv");
    x.style.display += "grid";

  }


function ajax_vote(event) {
    //Stop form from refreshing page. AJAX means we dont need to refresh/"submit" data that way.
    event.preventDefault();
  	 var vote = event.currentTarget;
  	 var voteType = vote[0].value;
  	 var counter = vote[1].value;
  	 var ratingId = vote[2].value;
  	 var score = vote[3].value;
  	 //Used to properly edit the innerhtml of the reviews due to the posibility of their being multiple of them.
  	 var elementName = 'votingscore'+counter;
  	 
      
       //create XMLHttpRequest object
       var  xmlhttp = new XMLHttpRequest();
       // onreadystatechange event for the XMLHttpRequest 
           xmlhttp.onreadystatechange = function() {
           //if data is return ok.
            if (this.readyState == 4 && this.status == 200) {
               var display;
               var results = JSON.parse(this.responseText)
                 
                   if(results > 0)
                   {
                   	display = "Overall score is <b>"; display += results; display += "</b>. People liked this review.";
                   }
                   else if(results == 0)
                   {
                   	display = "Overall score is <b>"; display += results; display += "</b>. This review is neutral.";
                   }
                   else
                   {
                   	display = "Overall score is <b>"; display += results; display += "</b>. People disliked this review.";
                   }
                  document.getElementById(elementName).innerHTML = display;
                
					
               

              } 
       }
         //send the data to PHP now and wait for response 
         
         
         xmlhttp.open("POST", "vote_update.php", true);
         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xmlhttp.send("voteType="+voteType+"&ratingId="+ratingId+"&score="+score);
        //This is here incase the first one doesnt work for somereason. Stops form from refreshing the page as AJAX will do that for us.
        event.preventDefault();
    }

    
//Dynamic Character counter for text area box.
function dynamiccharcount(str) {
	var count = str.length;
	var max = 500;

	if (count <= 500)
	{
		document.getElementById("charsleft").innerHTML = max - count + " characters left" ;
		document.getElementById("charsleft").style.color = "black";
		 document.getElementById("watchlistcreate").style.borderColor = "black";
	}
	if (count == 500)
	{
	
		document.getElementById("charsleft").innerHTML = "Maximum Length Reached.";
		document.getElementById("charsleft").style.color = "red";
	   document.getElementById("watchlistcreate").style.borderColor = "red";
	}
}    