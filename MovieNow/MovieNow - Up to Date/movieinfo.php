<?php 
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src = "ajax_vote.js"></script>
 <title>Movie Details</title>
</head>


<?php 
//Strips out the extra get junk variables that are a side effect of using an image as a submit button.
if (isset($_GET["x"])) {
    header ("Location: http://www2.cs.uregina.ca/~ktg349/MovieNow/movieinfo.php?MID=" . $_GET['MID']);
   exit;
}
//connect to SQL Database.
 $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
?>     

     <body>
     <!--–– CSS containers/grid layout items. --->
    <div class = "infocontainer">
    <div class = "infosignup">

   <?php  
   
   //If the user is logged in get the required information to show their login in top right.
   if(isset($_SESSION["user_id"])) {
   $uid = $_SESSION["user_id"];
   $avatar = $_SESSION["picture"]; 
   $username = $_SESSION["username"];
  echo "<div class =\"signin1\"><h5>Welcome, $username<img src=\"pictures/$avatar\" width=\"50px\" height=\"50px\" alt=\"Riders\"/> </h5><div class=\"logoutbutton\"><input type=\"button\" onclick=\"window.location.href = 'logout.php';\" value=\"Log Out\"/></div></div>";
  
 }
 
 //if they arent logged in show buttons.
 else
  {
  echo "<div class = \"signin1\"><input type=\"button\" onclick=\"window.location.href = 'login.php';\" value=\"Log In\"/>";
  echo "<input type=\"button\" onclick=\"window.location.href = 'signup.php';\" value=\"Sign Up\"/></div>";
  }
    ?>
    </div>
    <?php
  
      $movie_id = trim($_GET["MID"]);
      $moviequery = "SELECT * FROM 374movies WHERE movie_id= '$movie_id';";
      $result = $db->query($moviequery);
      $row = $result->fetch_assoc();
      $poster = $row["poster"]; 
      $title = $row["title"];
      $director = $row["director"];
      $youtube_link = $row["youtube_link"];
      $dateReleased = $row["dateReleased"];
      $cast = $row["cast"];
      //Rating will need to auto update later on, based on reviews.
      $rating = $row["rating"];
      
      //Used to dynamically change the css as it doesnt work too well when there is no reviews otherwise.
      $testQuery="SELECT * FROM 374reviews WHERE movie_id= '$movie_id';";
      $testResult = $db->query($testQuery);
      $testCounter = 0;
     while($testRow = $testResult->fetch_assoc())
      {
    //Data and varibles used to dynamically generate reviews on the html.
      $testCounter ++;
      }
     
      echo"<div class=\"infotitle\"> <b>$title</b> <input type=\"button\" class=\"button button2\" onclick=\"window.location.href = 'homepage.php';\" value=\"To Homepage\"/> </div>";
      if($testCounter == 0)
      {
         echo"<div class = \"trailer\" style=\"grid-row-start: row 2; grid-row-end: row 6;\">";
      }
      else
      {
          echo"<div class = \"trailer\">";
      }
      echo"<iframe width= 100% height= 100%  src=\"$youtube_link\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
      echo"</div>";
      echo"<div class =\"about1\"><div class=\"about2\"><u><b>Cast:</b></u></div>";
      echo"$cast <br><br> <br>";
      echo"<div class=\"about2\"><u><b>Director:</b></u></div>";
      echo"$director";
      echo"</div>";
     
     
      
      if($testCounter == 0)
      {
         echo"<div class=\"reviews\" style=\"grid-row-start: row 6; grid-row-end: row 7;\">";
      }
      else
      {
         echo"<div class=\"reviews\">";
      }
if(isset($_SESSION["user_id"])) {
       
       echo"<p class=\"reviewspacing\"><u>Reviews:</u><input type=\"button\" class=\"button writebutton\" onclick=\"textBoxUnhide()\"  value=\"Write Review\"/><div class=\"panel\">";
       echo"</div>";
       }
       else
       {
         echo"<p class=\"reviewspacing\"><u>Reviews:</u><input type=\"button\" onclick=\"window.location.href = 'login.php' class=\"button writebutton\"  value=\"Please login to write a review.\"/><div class=\"panel\">";
       echo"</div>";
       }
       ?>
	

<?php //Gets the reviews for the movie from SQL table, including write review button and up/downvotes.
$movie_id = trim($_GET["MID"]);
$reviewQuery="SELECT * FROM 374reviews WHERE movie_id= '$movie_id';";
$reviewResult = $db->query($reviewQuery);
$reviewCounter = 0;
while($reviewRow = $reviewResult->fetch_assoc())
    {
    //Data and varibles used to dynamically generate reviews on the html.
      $reviewCounter ++;
		$reviewData=$reviewRow["review"];
		$scoreData=$reviewRow["score"];
		$user_idData=$reviewRow["user_id"];
      $ratingID = $reviewRow["rating_id"];
      $rating = $reviewRow["rating"];
		$userNameQuery="SELECT * FROM 374users WHERE user_id= '$user_idData';";
		$userNameResult=$db->query($userNameQuery);
		$userNameRow=$userNameResult->fetch_assoc();
		$userName=$userNameRow["username"];
		
		echo"<p><b>Review by $userName:</b></p>";
      echo"";
      echo"<p><u>Movie Rating</u>"; 
      echo"<p class =\"movierating\">Rating:";
       for ($counter = 0; $counter < $rating; $counter++)
       {
       echo"<span class = \"fa fa-star checked\"></span>";
       }
       $starsleft = 5 - $rating;
       for ($counter2 = 0; $counter2 < $starsleft; $counter2++)
       {
       echo"<span class = \"fa fa-star\"></span>";
       }
       echo"</p>";
      
      
      echo"</p>";
      echo"<div class=\"reviewcontentbox\">";
      echo"<p>$reviewData</p>";
      echo"</div>";
   
      //Show review "scores".
      if($scoreData > 0)
      {
         echo"<p id =\"votingscore$reviewCounter\">Overall score is <b>$scoreData</b>. People liked this review.</p>";
      }
      elseif($scoreData == 0)
      {
         echo"<p id =\"votingscore$reviewCounter\">Overall score is <b>$scoreData</b>. This review is neutral.</p>";
      }
      else
      {
         echo"<p id =\"votingscore$reviewCounter\">Overall score is <b>$scoreData</b>. People disliked this review.</p>";
      }
      //Show downvote/upvote buttons if user is logged in.
      if(isset($_SESSION["user_id"])) {
      echo"<form id=\"upvotereview$reviewCounter\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"submit\" class=\"button\" name=\"upvote\" value=\"Upvote\"/><input type=\"hidden\" name=\"ratingcounter\" value = \"$reviewCounter\"/><input type=\"hidden\" name=\"ratingid\" value = \"$ratingID\"/><input type=\"hidden\" name=\"score\" value = \"$scoreData\"/></form>";
      echo"<form id=\"downvotereview$reviewCounter\"  method=\"post\" enctype=\"multipart/form-data\"><input type=\"submit\" class=\"button\" name=\"downvote\"  value=\"Downvote\"/><input type=\"hidden\" name=\"ratingcounter\" value = \"$reviewCounter\"/><input type=\"hidden\" name=\"ratingid\" value = \"$ratingID\"/><input type=\"hidden\" name=\"score\" value = \"$scoreData\"/></form>"; 
      }
      
      else
      {
         echo"<p>Sign in to Up/Downvote this review.</p>";
      }
      
      //Used to get event listener for AJAX call on upvote/downvotes.
     for($addEventListenerLoop = 0; $addEventListenerLoop < $reviewCounter; $addEventListenerLoop++)
     {
       $number =  $addEventListenerLoop + 1;
      echo"<script>document.getElementById(\"upvotereview$number\").addEventListener(\"submit\", ajax_vote, false);</script>";
      echo"<script>document.getElementById(\"downvotereview$number\").addEventListener(\"submit\", ajax_vote, false);</script>";
     }
	}

   //If the movie has no reviews show this.
   if ($reviewCounter == 0)
   {
      echo"<p><b>No one has reviewed this movie yet. Be the first one!</b></p>";
   }
      
?>
    
</div>
<br>

<br>
<div  class= "writereviewdiv "id="writereviewdiv">
<br>
<br>

<?php
$user_id = $_SESSION["user_id"];
echo"<h7><b> Write your Review below </b></h7>";
echo"<form id=\"reviewForm\" method = \"post\" action=\"redirect.php\" enctype =\"multipart/form-data\">";
echo"<input type=\"hidden\" name=\"user_id\" value = \"$user_id\"/>";
echo"<input type=\"hidden\" name=\"movieid\" value = \"$movie_id\"/>";
echo"Movie Rating: <select name=\"rate\" />";
echo"<option value=\"1\">1</option> <option value=\"2\">2</option><option value=\"3\">3</option> <option value=\"4\">4</option><option value=\"5\">5</option>";      
echo"</select>";
echo"<br>";
echo"<span id=charsleft class=\"charswatch\"></span>";
echo"<textarea id=\"textarea\" name=\"reviewcontent\"  class=\"writetextbox\" onkeyup=\"dynamiccharcount(this.value)\" maxlength = \"500\"/></textarea>";
echo"<input type=\"submit\" name =\"submit\" value=\"Post Review\">";
echo"</form>";
?>
</div>

</div>

<script src= "write_review.js"> </script>
</body>
</html>

      