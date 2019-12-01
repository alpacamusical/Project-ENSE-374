<?php ini_set('display_errors', 'On');
error_reporting(E_ALL);
$validate = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
$email = "";

 
if (isset($_POST["submitted"]) && $_POST["submitted"])
{
    $email = trim($_POST["email"]);
    $avatar = $_FILES["fileToUpload"]["name"];
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirmpassword =  trim($_POST["confirmpassword"]);
       
    $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
    $q1 = "SELECT * FROM 374users WHERE email = '$email'";
    $r1 = $db->query($q1);

    // if the email address is already taken.
    if($r1->num_rows > 0)
    {
        $validate = false;
    }
    else
    {
        
         if($avatar == null || $avatar == "")
        {
            $avatar = false;
        }
        if($username == null || $username == "")
        {
            $validate = false;
        }
        
        
        $emailMatch = preg_match($reg_Email, $email);
        if($email == null || $email == "" || $emailMatch == false)
        {
            $validate = false;
        }
        
              
        $pswdLen = strlen($password);
        $pswdMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false)
        {
            $validate = false;
        }

        
        if($confirmpassword == null || $confirmpassword == "" || $confirmpassword != $password)
        {
            $validate = false;
        }
    }

    if($validate == true)
    {
        //add code here to insert a record into the table users;
      
           
$target_dir = "pictures/";
$uploadOk = 1;
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    $r2 = false;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    $r2 = false;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //File is uploaded succesfully.
    } else {
        echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
    }
}
      if($uploadOk == 1)
      {
        $q2 = "INSERT INTO 374users (username, password, email, picture, isLoggedIn) VALUES ('$username','$password', '$email','$avatar', '0')";
        $r2 = $db->query($q2);
      }
   
        if ($r2 == true)
        {
            $url='login.php';
            echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
            $db->close();
            exit();
        }
    }
    else
    {
        $error = "Email address is not available. Signup failed.";
        echo "$error";
        $db->close();
    }
   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <title>Signup</title>
 <script src = "signup.js" ></script>
 
 
</head>

<body>

<div class="infocontainer">

<div class="signuptopleft">
Don't have an account yet? Create one below!
<h2>
<div class = "title"> Movie Now - Sign Up</div>
</h2>
</div>




<div class= "signupform">

<form id= "SignUp" action="signup.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="submitted" value="1"/>
<table>
<tr><td></td><td><label id="email_msg" class="err_msg"></label></td></tr>
 	<tr><td>Email: </td><td> <input type="text" name="email" size="30" /></td></tr>
  
  <tr><td></td><td><label id="profilepicture_msg" class="err_msg"></label></td></tr>
 <tr><td>Profile Picture: </td><td> <input type="file"  name="fileToUpload" > </td></tr>
  
  <tr><td></td><td><label id="username_msg" class="err_msg"></label></td></tr>    
 	<tr><td>Username: </td><td> <input type="text" name="username" size="30" /></td></tr>
  
   <tr><td></td><td><label id="password_msg" class="err_msg"></label></td></tr> 
 	<tr><td>Password: </td><td> <input type="password" name="password" size="30" /></td></tr>   
  
  <tr><td></td><td><label id="passwordconfirm_msg" class="err_msg"></label></td></tr> 
 	<tr><td>Confirm Password: </td><td> <input type="password" name="confirmpassword" size="30" /></td></tr>   
</table>
<input type="submit" id="btnSignUp" class="button1" value="Signup" > 
<input type="reset" id="btnReset" value="Reset"/>
 <label id="signupsuccess_msg" class="success_msg"></label>
</form>  
</div>

<div class="signuptopright">
Already have an account? Log in <a href="login.php">here.</a>
</div>


<script src = "signup-r.js" ></script>
</div>
</body>