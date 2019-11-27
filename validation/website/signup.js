function SignUpForm(event){ 

    // Similar to lab implementation treats event.currentTarget aka SignUp form as 7 different inputs, instead of seperate functions for each.


    var elements = event.currentTarget;

  
  //Variables. 
   //email
    var a = elements[1].value;
    //profile picture.
    var b = elements[2].value; 
    // first name
    var c = elements[3].value;
    // last name
    var d = elements[4].value;
    // username
    var e = elements[5].value;
    // password
    var f = elements[6].value;
    //confirm password
    var g = elements[7].value;
    
  
  
    
    var result = true;    
        
   
	//Verification tests on email,username and password variables.
	
	
		//Email verification. ex ktg349@uregina.ca
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
    
   
   //Username is only numbers or letters.
    var username_v = /^[a-zA-Z0-9_-]+$/;
    
    //Password must have atleast one number, one symbol 8 + characters.
    var password_v = /^(?=^.{8,40}$)(?=.*[a-zA-Z])(?=.*[@#$%^&*+=])(?=.*[0-9]).*$/;
   
   
    document.getElementById("email_msg").innerHTML ="";
    document.getElementById("username_msg").innerHTML ="";
    document.getElementById("profilepicture_msg").innerHTML="";
    document.getElementById("firstname_msg").innerHTML ="";
    document.getElementById("lastname_msg").innerHTML ="";
    document.getElementById("password_msg").innerHTML ="";
    document.getElementById("passwordconfirm_msg").innerHTML ="";

 
    //Check email Validation
    if (a==null || a==""||email_v.test(a) == false)
        {	   
	   document.getElementById("email_msg").innerHTML="Email is empty or invalid(ex: ktg349@uregina.ca or kadengoski@gmail.com)";
           result = false;
        }
    else {
    	document.getElementById("email_msg").innerHTML ="";
    }
        //Profile picture cannot be empty.
    if (b==null || b=="")
    {
    	 document.getElementById("profilepicture_msg").innerHTML="Please add a profile picture";
    	 result = false;
    } else {
    	document.getElementById("profilepicture_msg").innerHTML="";
    }
        	   //Firstname cannot be empty.
    if (c==null || c=="")
        {	   
	   document.getElementById("firstname_msg").innerHTML="First Name cannot be empty.";
           result = false;
       } else {
    	document.getElementById("firstname_msg").innerHTML ="";
    }
        
        	//Lastname cannot be empty.
     	if (d==null || d==""){  
	    document.getElementById("lastname_msg").innerHTML="Last Name cannot be empty.";
	    result = false;
    }else {
    	document.getElementById("lastname_msg").innerHTML ="";
    }
   
		//Check username validation
	if (e==null || e=="" ||username_v.test(e) == false){  
	    document.getElementById("username_msg").innerHTML="Username is empty or invalid (Only Numbers and Letters allowed).";
	    result = false;
    }else {
    	document.getElementById("username_msg").innerHTML ="";
    }

		//Check password validation
  	if (f==null || f=="" ||password_v.test(f) == false){  
	    document.getElementById("password_msg").innerHTML="Please enter the password correctly. (8 or more characters long, at least 1 symbol, atleast 1 number)";
	    result = false;
	  }else {
    	document.getElementById("password_msg").innerHTML ="";
    }
    
    // Check confirm password validation
    if (g==null || g=="" ||g != f){  
	    document.getElementById("passwordconfirm_msg").innerHTML="Confirm password does not match the password.";
	    result = false;
	 }else {
    	document.getElementById("passwordconfirm_msg").innerHTML ="";
    }
	    

    //prevent form to be submitted if one of above field is invalid		
    if(result == false )
        {    
            event.preventDefault();
        }
    else
    {
			
    }
}

function ResetForm(event)
{
    document.getElementById("email_msg").innerHTML ="";
    document.getElementById("profilepicture_msg").innerHTML = "";
    document.getElementById("username_msg").innerHTML ="";
    document.getElementById("firstname_msg").innerHTML ="";
    document.getElementById("lastname_msg").innerHTML ="";
    document.getElementById("password_msg").innerHTML ="";
    document.getElementById("passwordconfirm_msg").innerHTML ="";
    
}


