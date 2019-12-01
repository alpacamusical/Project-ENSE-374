<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<script type="text/javascript" src="login.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
</head>
<body>
<header>
      <table>
	<tbody><tr>
	   
	      
<td><div class = "title">Movie Now - Login Page</div> </td>  
	    </tr> </tbody>
  </table>
    </header>
    
<div class="infocontainer">

<div class="signupform">
<form id="formLogin" action="login.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="submitted" value="1"/>
<table>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td>Email</td>
<td>Password</td>
</tr>
<tr>
<td id="emailLog_msg" class="err_msg"></td>
<td id="passwordLog_msg" class="err_msg"></td>
</tr>
<td><input type="email" id="email" name="email" value=""/></td>
<td><input type="password" id="password" name="password"/></td>
<td><input type="submit" value="Login"/></td>
</tr>

<tr>
<td><a href="signup.php">Sign up</a></td>
<td><a href ="homepage.php"> Continue as Guest</a></td>
</tr>
</table>
</form>
</div>
<script type="text/javascript" src="login-r.js"></script>
</body>
</html>

<?php

$validate = true;
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";

$email = "";
$error = "";

if (isset($_POST["submitted"]) && $_POST["submitted"])
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    //add code here to select * from table User where email = '$email' AND password = '$password'
    // start with $q = 

    $q = "SELECT * FROM 374users WHERE email='$email' AND password='$password'"; 
      
    $r = $db->query($q);
    $row = $r->fetch_assoc();
    if($email != $row["email"] && $password != $row["password"])
    {
        $validate = false;
    }
    else
    {
        $emailMatch = preg_match($reg_Email, $email);
        if($email == null || $email == "" || $emailMatch == false)
        {
            $validate = false;
        }
        
        $pswdLen = strlen($password);
        $passwordMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen < 8 || $passwordMatch == false)
        {
            $validate = false;
        }
    }
    
    if($validate == true)
    {

        session_start();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["picture"] = $row["picture"];
        $uid = $_SESSION["user_id"];
        $sql = "UPDATE 374users SET isLoggedIn='1' WHERE user_id='$uid'";
        $request = $db->query($sql);
        header('Location: homepage.php');
        $db->close();
        exit();
    }
    else 
    {
        $error = "The email/password combination was incorrect. Login failed.";
        echo "<$error";
        $db->close();
    }
}

?>