function LoginForm(event){ 

    var element = event.currentTarget;

  
  //Variables. 
   //email
    var a = element[1].value;
    //profile picture.
    var b = element[2].value; 
   
  
  
    
    var result = true;    
        
   
	//Verification tests on email,username and password variables.
	
	
		//Email verification standard from online resource. Variation of RFC 2822.
    var email_v = /[a-z0-9!#$%&'*+=^{|}~-]+([a-z0-9!#$%&'*+/=^{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/; 
   
   
    //Password must have atleast one number, one symbol.
    var password_v = /^(?=^.{8,40}$)(?=.*[a-zA-Z])(?=.*[@#$%^&*+=])(?=.*[0-9]).*$/;
   
   
    document.getElementById("emailLog_msg").innerHTML ="";
    document.getElementById("passwordLog_msg").innerHTML ="";
 
    //Check email Validation
    if (a==null || a==""||!email_v.test(a))
        {	   
	  		 document.getElementById("emailLog_msg").innerHTML="Email is empty or invalid(ex: ktg349@uregina.ca or kaden.goski@gmail.com)";
           result = false;
        }
      
		//Check password validation
  	if (b==null || b=="" ||password_v.test(b) == false){  
	    document.getElementById("passwordLog_msg").innerHTML="Please enter the password correctly. (8 characters long, at least 1 symbol, atleast 1 number)";
	    result = false;
	}

    //prevent form to be submitted if one of above field is invalid		
    if(result == false )
        {  
       
            event.preventDefault();
        
        }

  		 
       
     
}
