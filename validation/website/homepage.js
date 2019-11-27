function SearchBar(event)
{
	var searchquery = event.currentTarget;
	
	//text box.
	var a = searchquery[0].value;

	//Search bar cannot be empty.
	if (a==null || a=="")
        {	   
           //Used to test this...alert("works");
	 			event.preventDefault();	 			
        }

}