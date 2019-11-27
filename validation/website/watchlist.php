<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Watchlist</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <script src = "watchlist.js" ></script>
</head>
<body>

 <header>
 <?php 
    echo "<img src=\"posters/riders.jpg\" width=\"100\" height=\"60\" alt=\"Riders\"/>  <h1>Kaden's Movie Database - Watchlists</h1>";
    
    //Login Bar show profile picture and username if logged in. If not, show signup/login buttons.
 if(isset($_SESSION["uid"])) {
  
    $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    $uid = $_SESSION["uid"];
    $avatar = $_SESSION["avatar"]; 
    $username = $_SESSION["username"];  
    $date = date("Y/m/d");
    
     if(isset($_POST["watchlistname"]) && $_POST["watchlistname"])
      {
    $watchlistname = trim($_POST["watchlistname"]); 
    $checker = "SELECT * FROM watchlists WHERE name='$watchlistname'";
    $c = $db->query($checker);
    //Hackish way to get around IF NOT EXISTS not working with insert command.
    if ($checkerlist = $c->fetch_assoc())
    {
      
    }
    else
    {
    $create = "INSERT INTO watchlists (uid, name, dateCreated) VALUES ('$uid','$watchlistname','$date');";
    $r = $db->query($create);
    }
    }
  
 echo "<div class =\"signin1\"><h5>Welcome back $username !</h5><img src=\"avatars/$avatar\" width=\"100\" height=\"100\" alt=\"Riders\"/> <br> <input  type=\"button\" onclick=\"window.location.href = 'logout.php';\" value=\"Log Out\"/> </div>";
 }
 else
  {
  echo "<div class = \"login3\"><input type=\"button\" onclick=\"window.location.href = 'login.php';\" value=\"Log In\"/></div>";
  echo "<div class = \"signup1\"><input type=\"button\" onclick=\"window.location.href = 'signup.php';\" value=\"Sign Up\"/></div>";
  }
    ?>

   </header>

  
    
    <p><input type="button" onclick="window.location.href = 'homepage.php';" value="Go to Home Page"/></p>
    
    <form id= "Watchlist" action="watchlist.php" method="post" enctype="multipart/form-data" >
    <input type ="hidden" name = "submitted" value ="1"/>
    <textarea id="watchlistcreate" style="resize:none" name="watchlistname" onkeyup="dynamiccharcount(this.value)"></textarea><span id=charsleft class="charswatch"></span>
    <input type="submit" value="Create Watchlist"/>
    </form>
    
    
    <?php 
 
 if(isset($_SESSION["uid"])) {
      
      if(isset($_POST["submittedD"]) && $_POST["submittedD"])
      {
      $delete = $_POST["submittedD"];
        $d = "DELETE FROM watchlists WHERE name = '$delete';";
        $r = $db->query($d);
      }
    
        $uid = $_SESSION["uid"];
        $d = "SELECT * FROM watchlists WHERE uid = '$uid';";
        $r = $db->query($d);
        $counter = 0;

        echo"<div class=\"row\"> <h2>Your Watchlists:</h2> </div>";
      while ($row = $r->fetch_assoc())
         {
            $counter++; //Determines if there are watchlists in the users name.
            $name = $row["name"];
            $wid = $row["wid"];
            $entry = "SELECT * FROM entries WHERE wid ='$wid';";
            $r2 = $db->query($entry);
          
            echo"<div class=\"column3\">";
            echo"<table>";
            echo"<tbody>";
            echo"<tr><td><h1>$name</h1></td></tr>";
            $titlecounter = 0;
            while($entry = $r2->fetch_assoc())
            {
               $titlecounter++;//Determines if the watchlist is empty or not. If it is 0 it means no rows where returned and watchlist is empty.
               $mid = $entry["mid"];
               $moviename = "SELECT * FROM Movies WHERE mid ='$mid';";
               $r3 = $db->query($moviename);
               $r4 = $r3->fetch_assoc();
               $Mtitle = $r4["title"];
               echo"<tr><td>$Mtitle</td></tr>";
            }
            if ($titlecounter== 0)
            {
               echo"<tr><td>You have no movies in this list yet! Please add some using a movie details page.</td></tr>";
               echo"<tr><td><form id= \"deletewatchlist\" action=\"watchlist.php\" method=\"post\" enctype=\"multipart/form-data\">";
               echo"<input type =\"hidden\" name = \"submittedD\" value =\"$name\"/>";
               echo"<input type=\"submit\" value=\"Delete $name\"/>";
               echo"</form></tr></td>";
            }
            else
            {
               echo"<tr><td><form id= \"watchlistdetails\" action=\"watchlistdetails.php\" method=\"post\" enctype=\"multipart/form-data\">";
               echo"<input type =\"hidden\" name = \"submitted\" value =\"$wid\"/>";
               echo"<input type=\"submit\" value=\"Go to $name Details\"/>";
               echo"</form></td></tr>";
               echo"<tr><td><form id= \"deletewatchlist\" action=\"watchlist.php\" method=\"post\" enctype=\"multipart/form-data\">";
               echo"<input type =\"hidden\" name = \"submittedD\" value =\"$name\"/>";
               echo"<input type=\"submit\" value=\"Delete $name\"/>";
               echo"</form></tr></td>";
              }
            echo "</tbody></table></div>";
            
         }
          if($counter == 0)
          {
            echo"<div class=\"column3\">";
            echo"<table>";
            echo"<tbody>";
            echo"<tr><td><h1>You have no watchlists, please create one using the text box above.</h1></td></tr>";
            echo"</tbody></table></div>";
          
  }
  }
  else
  { 
  echo"<div class =\"column3\"></div>";
  echo"<div class = \"column3\"><h2>Please Sign in to view this page.</h2></div>";     
  } 
  $db->close();
  ?>
 <script src = "watchlist-r.js" ></script>
</body>
</html>