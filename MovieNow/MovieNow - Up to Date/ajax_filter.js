
function ajax_filter() {
  	   
  	   var sortby = document.getElementById("sortselection").value;
       // create a variable we need to send to our PHP file
       //Change the title description at top of homepage.
       if(sortby == "DateReleased"){
           document.getElementById("homepageSortedTitle").innerHTML = "Newest Movies";
			}
		 if(sortby == "Rating"){
           document.getElementById("homepageSortedTitle").innerHTML = "Top Rated Movies";
			}
		 if(sortby == "Title"){
            document.getElementById("homepageSortedTitle").innerHTML = "Alphabetically Ordered Movies";
			}
			
       //create XMLHttpRequest object
       var  xmlhttp = new XMLHttpRequest();
       // access the onreadystatechange event for the XMLHttpRequest object
           xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               var display ="";
               var results = JSON.parse(this.responseText)
               if (results.length > 0) 
               {
               for (var i = 0; i < results.length; i++) 
                   {
                   var json_result = results[i];
                    display += "<div class = \"movies\">";
						  display +="<p class=\"movie\">";display += json_result[1]; display += "</p>";
                   display += "<form id=\"movieinfo\" method=\"get\"  action=\"movieinfo.php\"><input type =\"hidden\" name = \"MID\" value =\"";
                   display += json_result[0]; display += "\">";
                   display += "<input type=\"image\" src=\"poster/"; display += json_result[3]; display +=" \" class=\"starwars\">  </form>";
                   display += "<p class =\"movierating\">Rating:";
                   
                  var counter;
                  var stop = json_result[7];
                   for (counter = 0; counter < stop; counter++)
      			    {
       					display += "<span class = \"fa fa-star checked\"></span>";
      				 }
      				 
      				 var starsleft = 5 - counter;
      				 
      				 for(counter = 0; counter < starsleft; counter++)
                 	 {
                 	 	display += "<span class = \"fa fa-star\"></span>";
                 	 }
                 	 
                 	 
                  display+="</p>";
                  display+="<p class=\"moviereviews\">Date Released:"; display += json_result[2]; display += "</p>";
                  display+="</div>";
                 
					   }
                 document.getElementById("moviesdisplay").innerHTML = display;

              } 
       }
         //send the data to PHP now and wait for response 
         //to update the display_records in div
         //actually execute the request
         }
         xmlhttp.open("POST", "display_sorted.php", true);
         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xmlhttp.send("sortby="+ sortby);
    

    
    }