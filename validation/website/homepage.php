<?php 
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="webpage.css" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
 <title>Homepage</title>
 <script src = "homepage.js" ></script>
 
 
</head>
<body>
   
 <header>
 <img src="posters/riders.jpg" width="100" height="60" alt="Riders"/>
 <h1>Kaden's Movie Database - Homepage</h1>
   <?php 
   
   // Login/Avatar in top right.
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
    ?>

  
    </header>
    
    <nav>
      <ul>    
      <li><b>Find movies via: </b></li>
    </ul>
  
  <select id="genreselect" name="location2" onchange="window.location='homepage.php?genre='+this.value+'&genre2='+this.selectedIndex;">
    <option value="genre">Genre</option>
    <option value="Action">Action</option>
    <option value="Adventure">Adventure</option>
    <option value="Biography">Biography</option>
    <option value="Comedy">Comedy</option>
    <option value="Crime">Crime</option>
    <option value="Drama">Drama</option>
    <option value="Family">Family</option>
    <option value="Fantasy">Fantasy</option>
    <option value="Horror">Horror</option>
    <option value="Musical">Musical</option>
    <option value="Mystery">Mystery</option>
    <option value="Patriotic">Patriotic</option>
    <option value="Romance">Romance</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Social">Social</option>
    <option value="Sports">Sports</option>
    <option value="Spy">Spy</option>
    <option value="Suspense">Suspense</option>
    <option value="Thriller">Thriller</option>
     <option value="War">War</option>
    <option value="Western">Western</option>
    <option value="Wuxia">Wuxia</option>
    <option value="Zombie">Zombie</option>
    </select>

    
    <script>
        var genreselect = document.getElementById("genreselect");
        genreselect.options.selectedIndex = <?php echo $_GET["genre2"]; ?>
    </script>
  
  
  
  <select id="myselect" name="location" onchange="window.location='homepage.php?origin='+this.value+'&country='+this.selectedIndex;">
    <option value="origin">Origin</option>
    <option value="American">American</option>
    <option value="Australian">Australian</option>
    <option value="Bollywood">Bollywood</option>
    <option value="British">British</option>
    <option value="Canadian">Canadian</option>
    <option value="Chinese">Chinese</option>
    <option value="Japanese">Japanese</option>
    <option value="Punjabi">Punjabi</option>
    <option value="Russian">Russian</option>
    </select>

    
    <script>
        var myselect = document.getElementById("myselect");
        myselect.options.selectedIndex = <?php echo $_GET["country"]; ?>
    </script>
   

      </ul>
      <div class = "searchbar">
      <form id= "searchbar" action="homepage.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="search" size="30" /> 
      <input type="submit" value="Search for movies: "/>
      </form> </div>
        <ul>
        <li><p><b>Show Movies Sorted by Title: </b>
        <form  id= "titleSort" action="homepage.php" method="POST" enctype="multipart/form-data" >
         <input type="hidden" name="titleSorted" value="1"/>
         <input type="submit" value="15 Titles"/>
         </form>
         <form  id= "titleSortUn" action="homepage.php" method="POST" enctype="multipart/form-data" >
         <input type="hidden" name="titleSortedUn" value="1"/>
         <input type="submit" value="All Titles"/>
         </form>
        </ul>
        <?php
         if(isset($_SESSION["uid"])) {
         echo "<input class=\"watchlistbutton\" type=\"button\" onclick=\"window.location.href = 'watchlist.php';\" value=\"Go to Watchlists\"/>";
         }
         else
         {
            echo "<input class=\"watchlistbutton\" type=\"button\" onclick=\"window.location.href = 'login.php';\" value=\"Log in to see your Watchlists.\"/>";
         }
         ?>
    </nav>
    
    <div class="MOVIE">Movies:</div>
    <div class="row">

   <?php
     $db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
    
    //If sort by origin is selected.
    if(isset($_GET['origin']) && $_GET['origin'] != "origin")
    {
        $origin=$_GET['origin'];
        $m1 = "SELECT * FROM Movies WHERE origin='$origin';";
        $r = $db->query($m1);
        
        while ($row = $r->fetch_assoc())
         {
        $poster = $row["poster"]; 
        $title = $row["title"];
        $year = $row["year"];
        $cast = $row["cast"];   
        $mid = $row["mid"];       
        echo "<div class=\"column3\">";
        echo"<table>";
        echo"<tbody>";
        echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
        echo"<tr><td><b>$title</b></td></tr>";
 	     echo"<tr><td>Release Date: $year</td></tr>";
        echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
        echo"</tbody>";
        echo"</table>";
        echo"</div>";
        }
            
        }
     
     
     //If sort by genre is selected. 
    else if(isset($_GET['genre']) && $_GET['genre'] != "genre")
    {
        $genre = $_GET['genre'];
        $m1 = "SELECT * FROM Movies WHERE genre LIKE '%$genre%';";
        $r = $db->query($m1);
        
        while ($row = $r->fetch_assoc())
         {
        $poster = $row["poster"]; 
        $title = $row["title"];
        $year = $row["year"];
        $cast = $row["cast"];   
        $mid = $row["mid"];         
        echo "<div class=\"column3\">";
        echo"<table>";
        echo"<tbody>";
         echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
        echo"<tr><td><b>$title</b></td></tr>";
 	     echo"<tr><td>Release Date: $year</td></tr>";
        echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
        echo"</tbody>";
        echo"</table>";
        echo"</div>";
        }
            
        }
      else if(isset($_POST['titleSorted']) && $_POST['titleSorted'] = '1')
      {
         
         $m1 = "SELECT * FROM Movies ORDER BY title ASC LIMIT 15;";
         $r = $db->query($m1);
         
         while ($row = $r->fetch_assoc())
         {
           $poster = $row["poster"]; 
           $title = $row["title"];
           $year = $row["year"];
           $cast = $row["cast"];   
           $mid = $row["mid"];         
           echo "<div class=\"column3\">";
           echo"<table>";
           echo"<tbody>";
           echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
           echo"<tr><td><b>$title</b></td></tr>";
 	        echo"<tr><td>Release Date: $year</td></tr>";
           echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
           echo"</tbody>";
           echo"</table>";
           echo"</div>";
         }
      }
      //Sort/show all movies sorted alphabetically by title. I wanted to add this one for fun.
       else if(isset($_POST['titleSortedUn']) && $_POST['titleSortedUn'] = '1')
      {
         
         $m1 = "SELECT * FROM Movies ORDER BY title ASC;";
         $r = $db->query($m1);
         
         while ($row = $r->fetch_assoc())
         {
           $poster = $row["poster"]; 
           $title = $row["title"];
           $year = $row["year"];
           $cast = $row["cast"];   
           $mid = $row["mid"];         
           echo "<div class=\"column3\">";
           echo"<table>";
           echo"<tbody>";
           echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
           echo"<tr><td><b>$title</b></td></tr>";
 	        echo"<tr><td>Release Date: $year</td></tr>";
           echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
           echo"</tbody>";
           echo"</table>";
           echo"</div>";
         }
      }
      else if(isset($_POST['search']) && $_POST['search'])
      {
         $searchbar = $_POST['search'];
         $m1 = "SELECT * FROM Movies WHERE title LIKE '%$searchbar%';";
         $r = $db->query($m1);
         $counter = 0;
          while ($row = $r->fetch_assoc())
         {
           $counter++;
           $poster = $row["poster"]; 
           $title = $row["title"];
           $year = $row["year"];
           $cast = $row["cast"];   
           $mid = $row["mid"];         
           echo "<div class=\"column3\">";
           echo"<table>";
           echo"<tbody>";
           echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
           echo"<tr><td><b>$title</b></td></tr>";
 	        echo"<tr><td>Release Date: $year</td></tr>";
           echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
           echo"</tbody>";
           echo"</table>";
           echo"</div>";
         }
         if ($counter == 0)
         {
            echo"<div class=MOVIE>No results found. Please try searching again.</div>";
         }
      }
  //Default Case. Top 15 movies.
   else
   {
         for ($i = 1; $i < 16; $i++)
         {
             $m1 = "SELECT * FROM Movies WHERE mid= '$i'";
             $r = $db->query($m1);
             $row = $r->fetch_assoc();  
             $poster = $row["poster"]; 
             $title = $row["title"];
             $year = $row["year"];
             $cast = $row["cast"];   
             $mid = $row["mid"];    
             echo "<div class=\"column3\">";
             echo"<table>";
             echo"<tbody>";
             echo"<tr><td> <img src=\"posters/$poster.jpg\" width=\"225\" height=\"250\" alt=\"Riders\" ></td></tr>";
             echo"<tr><td><b>$title</b></td></tr>";
 	          echo"<tr><td>Release Date: $year</td></tr>";
           	 echo"<tr><td><form id= \"moviedetails\" action=\"moviedetails.php\" method=\"POST\" enctype=\"multipart/form-data\" > <input type=hidden name=submitdetails value=\"$mid\"/> <input type=\"submit\" value=\"Go to Details\"/></form> </td></tr>";
             echo"</tbody>";
             echo"</table>";
             echo"</div>";
         }
         
         }
         
         //Code to be utilized after for show more when I use AJAX.
        // $more = 0;
       //  echo"<form action=\"homepage.php\" method=\"POST\">";
      //   echo"<input type=\"button\" name=\"showmore\"  value=\"Show more\"/>";
        // echo"</form>";
       //  if (isset($_POST["showmore"]; {
        $db->close();
         ?>  
  
</div>
<script>
function change(){
    document.getElementById("originform").submit();
}
</script>
 <script src = "homepage-r.js" ></script>
</body>
</html>