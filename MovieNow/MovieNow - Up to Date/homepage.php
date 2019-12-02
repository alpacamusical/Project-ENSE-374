<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <title>Homepage</title>
 
 
</head>

<body>

<div class="container">
<div class ="lefttop"></div>

<h1>
<div class = "title"> Movie Now</div>
</h1>

<?php // Login/Avatar in top right.
 if(isset($_SESSION["user_id"])) {
 
  $uid = $_SESSION["user_id"];
  $avatar = $_SESSION["picture"]; 
  $username = $_SESSION["username"];
  //user is logged in.
 echo "<div class =\"signin\">Welcome, $username<img src=\"pictures/$avatar\" width=\"75\" height=\"75\" alt=\"Riders\"/><br><div class=\"logoutbutton\"><input type=\"button\" onclick=\"window.location.href = 'logout.php';\" value=\"Log Out\"/></div></div>";
 
 }
 else
 {
 //User is not logged in, default buttons on top.
echo"<div class = \"signin\"><input type=\"button\" class=\"button button1\" onclick=\"window.location.href = 'signup.php';\" value=\"Sign Up\"/><input type=\"button\" class=\"button button1\" onclick=\"window.location.href = 'login.php';\" value=\"Log In\"/></div>";
}
?>
<div class= "moviesidebar"></div>
<div class= "moviesidebar2" id="test"></div>
<div class= "latest" ><span id ="homepageSortedTitle">Newest Movies  </span>
<select id="sortselection" name="sorted" onchange="ajax_filter()">
    <option value="Sort By">Sort By</option>
    <option value="DateReleased">Date Released</option>
    <option value="Rating">Rating</option>
    <option value="Title">Title</option>
    </select></div>


<div class = "moviecontainer" id= "moviesdisplay">

<?php //Set $_SESSION[movie_id] = $mid on click of image to send details to details page.?>


<?php //Connect to SQL database.
     $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    //Get movie information, default sort is by dateReleased.
    $defaultdisplay = "SELECT * FROM 374movies ORDER BY dateReleased DESC;";
    $movies = $db->query($defaultdisplay);
   $movieidcounter = 0;
   //While there is results from the SQL quest dynimically echo this to the webpage.
    while($movierow = $movies->fetch_assoc())
    {
       $movieidcounter ++;
       $poster = $movierow["poster"]; 
       $title = $movierow["title"];
       $dateReleased = $movierow["dateReleased"];
       $movie_id = $movierow["movie_id"];
       $rating = $movierow["rating"];
       echo"<div class = \"movies\" id = \"movies$movieidcounter\">";
       echo"<p class=\"movie\">$title</p>";
       echo"<form id=\"movieinfo\" method=\"get\"  action=\"movieinfo.php\"><input type =\"hidden\" name = \"MID\" value =\"$movie_id\">";
       echo"<input type=\"image\" src=\"poster/$poster\" class=\"starwars\">  </form>";

       //Displays the rating of the movie. class fa fa-star (checked) represents images from css.
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
       echo"<p class=\"moviereviews\">Date Released: $dateReleased</p>";
       echo"</div>";
    }
 
?>



</div>
</div>
<script src = "ajax_filter.js" >
</script>
</body>
</html>