document.getElementById("reviewForm").addEventListener("submit", writeReviewValidation, false);


function writeReviewValidation(event)
{
	var review = event.currentTarget;
  	 var user_id = review[0].value;
  	 var movie_id = review[1].value;
  	 var rate = review[2].value;
  	 var reviewcontent = review[3].value;
  	 
  	 if(reviewcontent == "" || reviewcontent == null)
  	 {
  	 	event.preventDefault();
  	 }
}

