<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <title>Movie Details</title>
</head>
<body>

 <header>
<?php 
 $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
    //Inserts that the user viewed the movie details page.
 if(isset($_SESSION["uid"])) {
 
  $mid = trim($_POST["submitdetails"]);
  $uid = $_SESSION["uid"];
  $avatar = $_SESSION["avatar"]; 
  $username = $_SESSION["username"];
  $_SESSION["mid"] = $mid;
   $date = date("Y/m/d");
   //Add movie to specified watchlist.
   
   if(isset($_POST["addtolist"]) && $_POST["addtolist"])
   {
      $watchlistid = $_POST["addtolist"];
      
      $alreadyaddedCheck = "SELECT * FROM entries WHERE mid = '$mid' AND wid = '$watchlistid';";
      $r8 = $db->query($alreadyaddedCheck);
      if($row8 = $r8->fetch_assoc())
      {
         
      }
      else
      {
         $addtowatchlist = "INSERT INTO entries (wid,mid,dateAdded) VALUES ('$watchlistid','$mid','$date');";
         $r9 = $db->query($addtowatchlist);
      }
   }
   
   $viewedCheck = "SELECT * FROM views WHERE uid = '$uid' AND mid = '$mid';";
   $r6 = $db->query($viewedCheck);
  
  //If the user has already viewed the movie dont add another entry to the table.
   if($row6 = $r6->fetch_assoc())
   {
      
   }
   else
   {
   //If they have not viewed the movie, add that they have to the table.
       $viewed = "INSERT INTO views (uid,mid,timeViewed) VALUES ('$uid','$mid','$date');";
       $r6 = $db->query($viewed);
   }
  echo "<div class =\"signin1\"><h5>Welcome back $username<img src=\"avatars/$avatar\" width=\"75\" height=\"75\" alt=\"Riders\"/> </h5><div class=\"logoutbutton\"><input type=\"button\" onclick=\"window.location.href = 'logout.php';\" value=\"Log Out\"/></div></div>";
  
 }
 else
  {
  echo "<div class = \"login3\"><input type=\"button\" onclick=\"window.location.href = 'login.php';\" value=\"Log In\"/></div>";
  echo "<div class = \"signup1\"><input type=\"button\" onclick=\"window.location.href = 'signup.php';\" value=\"Sign Up\"/></div>";
  }
    ?>
  
    </header>
    
   <nav>
      <ul>
      <li><input type="button" onclick="window.location.href = 'homepage.php';" value="Go back Home"/></li>
      </ul>
    </nav>
    
    <?php
     $mid = trim($_POST["submitdetails"]);
     
     
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
      echo "<h4>$title</h4>";
      echo"<div class=\"row\">";
      echo"<div class=\"column4\">";
       
    echo "<table>";
    echo "<tbody>";
    echo "<tr><td><a href =\"moviedetails.html\"><img class=\"moviedetail\" src=\"posters/$poster.jpg\" width=\"200\" height=\"250\" alt=\"SW:The Last Jedi\" ></a></td></tr>";
    echo"<tr><td><b>Year Released:</b>$year</td></tr>";
    echo"<tr><td><b>Your Rating:</b> $yourRatingIs/5</td></tr>";
  	 echo"<tr><td><b>Cast:</b> $cast</td></tr>";
    echo"<tr><td><b>Genre:</b> $genre</td></tr>";
    echo"<tr><td><b>Origin:</b> $origin</td></tr>";
 	 echo"<tr><td><b>Directed by:</b> $director</td></tr>";
 	echo"<tr><td><input type=\"button\" onclick=\"window.location.href = '$wiki';\" value=\"Wikipedia Page\"/></td></tr>";
 
      if (isset($_POST["rate"]) && $_POST["rate"])
      {
         $uRating = $_POST["rate"];
         $uid = $_SESSION["uid"];
         $mid = $_SESSION["mid"];
         $date = date("Y/m/d");
         $ratedCheck = "SELECT * FROM ratings WHERE uid = '$uid' AND mid = '$mid';";
         $r6 = $db->query($ratedCheck);
         if($row6 = $r6->fetch_assoc())
        {
          $ratingupdate = "UPDATE ratings SET uid = '$uid',mid = '$mid',rating = '$uRating',dateRated = '$date' WHERE mid ='$mid' AND uid ='$uid'";
          $r10 = $db->query($ratingupdate);
        }
        else
        {
         //If they have not viewed the movie, add that they have to the table.
         $rating = "INSERT INTO ratings (uid,mid,rating,dateRated) VALUES ('$uid','$mid','$uRating','$date');";
         $r9 = $db->query($rating);
        }
         
         
      }
   
  echo"<form id=\"Rate\" action =\"moviedetails.php\" method=\"POST\"> ";
    echo "<tr><td></td><td><label id=\"emailLog_msg\" class=\"err_msg\"></label></td></tr>";
    echo "<tr> <div class=\"ratetext\"><td> Rate (out of 5):<input  type=\"number\" name=\"rate\" min=\"1\" max=\"5\"/> </td></div> </tr>";  
    echo "<tr><td><input type=\"submit\" value=\"Rate Movie\"/> </td></tr>";
    echo "<input type=\"hidden\" name=\"submitdetails\" value ='$mid'>";
    echo "</form>";
    
     
      $d = "SELECT * FROM watchlists WHERE uid = '$uid';";
      $r = $db->query($d);
      if($r != false)
      {
        
      while($watchlists = $r->fetch_assoc())
      {
         $watchbutton = $watchlists["wid"];
         $watchlist = $watchlists["name"];
         echo"<tr><td><br><form id= \"watchlistadd\" action=\"moviedetails.php\" method=\"post\" enctype=\"multipart/form-data\">";
         echo"<input type =\"hidden\" name = \"addtolist\" value =\"$watchbutton\"/>";
         echo"<input type =\"hidden\" name = \"submitdetails\" value =\"$mid\"/>";
         echo"<input type=\"submit\" value=\"Add movie to $watchlist\"/></td></tr>";
         echo"</form>";
         
      }
      
      }
      $db->close();
     ?>
     </tbody>
     </table> 
    </div>
  </div>
</body>
</html>