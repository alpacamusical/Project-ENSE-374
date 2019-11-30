<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <title>Watchlist - Details</title>
</head>
<body>

 <header>
  <img src="posters/riders.jpg" width="100" height="60" alt="Riders"/>
 <h1>Kaden's Movie Database - Watchlist Details</h1>
<?php 

$db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
if(isset($_SESSION["uid"])) {
 
  $uid = $_SESSION["uid"];
  $avatar = $_SESSION["avatar"]; 
  $username = $_SESSION["username"];
 echo "<div class =\"signin1\"><h5>Welcome back $username<img src=\"avatars/$avatar\" width=\"75\" height=\"75\" alt=\"Riders\"/> </h5><div class=\"logoutbutton\"><input type=\"button\" onclick=\"window.location.href = 'logout.php';\" value=\"Log Out\"/></div></div>";
 
 }
 else
  {
  echo "<div class = \"login3\"><input type=\"button\" onclick=\"window.location.href = 'login.php';\" value=\"Log In\"/></div>";
  echo "<div class = \"signup1\"><input type=\"button\" onclick=\"window.location.href = 'signup.php';\" value=\"Sign Up\"/></div>";
  }
    echo"</header>";
    
  if(isset($_SESSION["uid"])) {
    echo"<input type=\"button\" onclick=\"window.location.href = 'watchlist.php';\" value=\"Go to Watchlists\"/>";
    echo"<div class=\"row\"> <h2>Movies in your Watchlist:</h2> </div>";
    echo"<div class=\"row\">";
 
   if(isset($_POST["deleteMID"]) && ($_POST["deleteMID"]))
   {
      $thelist = $_POST["submitted"];
      $thetitle = $_POST["deleteMID"];
      $getentry = "DELETE FROM entries WHERE wid ='$thelist' AND mid ='$thetitle';";
      $r7 = $db->query($getentry);
   }
 
 
   if(isset($_POST["submitted"]) && ($_POST["submitted"]))
   {
      $watchlistid = $_POST["submitted"];
      $watchlistGET = "SELECT * FROM watchlists WHERE wid = '$watchlistid';";
      $r2 = $db->query($watchlistGET);
      $row1 = $r2->fetch_assoc();
      $watchlistname = $row1["name"];
      $entriesGET = "SELECT * FROM entries WHERE wid ='$watchlistid';";
      $r4 = $db->query($entriesGET);
      
      while($row4 = $r4->fetch_assoc())
      {
          $mid = $row4["mid"];
          $m1 = "SELECT * FROM Movies WHERE mid= '$mid';";
          $r = $db->query($m1);
          $row = $r->fetch_assoc();
          $poster = $row["poster"]; 
          $title = $row["title"];
          $origin = $row["origin"];
          $genre = $row["genre"];
          $director = $row["director"];
          $wiki = $row["wikiLink"];
          $year = $row["year"];
          $cast = $row["cast"];
          $yourRating = "SELECT * FROM ratings WHERE mid ='$mid' AND uid ='$uid';";
          $r3 = $db->query($yourRating);
      if($row1 = $r3->fetch_assoc())
      {
         $yourRatingIs = $row1["rating"];
      }
      else
      {
         $yourRatingIs = "N/A";
      }

         echo"<div class=\"column5\">";      
      echo "<table>";
      echo "<tbody>";
      echo "<tr><td><img class=\"moviedetail\" src=\"posters/$poster.jpg\" width=\"200\" height=\"250\" alt=\"SW:The Last Jedi\" ></td></tr>";
      echo "<tr><td><b>$title</b></tr></td>";
      echo"<tr><td><b>Year Released:</b>$year</td></tr>";
      echo"<tr><td><b>Your Rating:</b> $yourRatingIs/5</td></tr>";
  	   echo"<tr><td><b>Cast:</b> $cast</td></tr>";
      echo"<tr><td><b>Genre:</b> $genre</td></tr>";
      echo"<tr><td><b>Origin:</b> $origin</td></tr>";
 	   echo"<tr><td><b>Directed by:</b> $director</td></tr>";
 	   echo"<tr><td><input type=\"button\" onclick=\"window.location.href = '$wiki';\" value=\"Wikipedia Page\"/></td></tr>";
      echo"<tr><td><form id=deletefromlist action = watchlistdetails.php method=\"post\" enctype=\"multipart/form-data\" ><input type = \"hidden\" name = deleteMID value =\"$mid\"/> <input type = \"hidden\" name = submitted value=\"$watchlistid\"/>";
      echo"<input type = \"submit\" value=\"Delete From Watchlist\"/></form></td></tr>";
      echo"</tbody></table></div>";
       
      }
   }  
   }
    else
  { 
  echo"<div class =\"column3\"></div>";
  echo"<div class = \"column3\"><h2>Please Sign in to view this page.</h2></div>";     
  }  
     $db->close();
?>
 

</body>
</html>