<?php
session_start();
//ACCESS the variable sortby THAT WAS POSTED BY the javascript.
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$user_id = $_POST['user_id'];
$movie_id = $_POST['movieid'];
$rating = $_POST['rate'];
$reviewcontent = $_POST['reviewcontent'];

$db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
   $sql = "INSERT INTO 374reviews (user_id,movie_id,review,score,rating) VALUES ('$user_id','$movie_id','$reviewcontent','0','$rating')";
   $insertReview = $db->query($sql);

            $url ='movieinfo.php?MID=';
            $url.=$movie_id;
            echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
        $db->close();
        exit();
?>