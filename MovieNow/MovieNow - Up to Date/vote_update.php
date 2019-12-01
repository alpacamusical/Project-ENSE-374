<?php
session_start();
//ACCESS the variable sortby THAT WAS POSTED BY the javascript.


$votevalue = $_POST['voteType'];
$ratingid = $_POST['ratingId'];
$reviewscore = $_POST['score'];
$con = mysqli_connect('localhost','ktg349','C0tton!','ktg349');
if(!$con) {
    die('Could not connect: ' .mysqli_error($con));
}

//function is used to change the default database for the// connection.
//MYSQLI_SELECT_DB(connection,dbname);
mysqli_select_db($con,"ktg349");

//Logic for a up/downvote system.
//If you have already upvoted/downvoted you cannot do so again
//However if you have upvoted and click downvote, the first one cancels your upvote and the second one downvotes the review.
if ($votevalue == "Upvote")
{
  $user_id = $_SESSION['user_id'];
   $sql = "SELECT * FROM 374scores WHERE rating_id = '$ratingid' AND user_id = '$user_id';";
   $result = mysqli_query($con,$sql);
   $hasnotvoted = 0;
   $haddownvoted = 0;
   while($row = mysqli_fetch_assoc($result))
   {
   //If they have already upvoted, dont let them do so again.
     if($row["voted"] < 0)
     {
      $hasdownvoted++;
     }
     $hasnotvoted++;
   }
   
   if($hasnotvoted == 0)
   {
      $sql = "UPDATE 374reviews SET score = score + 1 WHERE rating_id = '$ratingid'";
      $result = mysqli_query($con,$sql);
      $sql = "INSERT INTO 374scores (rating_id,user_id,voted) VALUES ('$ratingid','$user_id','1');";
      $result = mysqli_query($con,$sql);
   }
   elseif($hasdownvoted == 1)
   {
      $sql = "UPDATE 374reviews SET score = score + 1 WHERE rating_id = '$ratingid'";
      $result = mysqli_query($con,$sql);
      
       $sql = "DELETE FROM 374scores WHERE rating_id = '$ratingid' AND user_id = '$user_id';";
       $result = mysqli_query($con,$sql);
   }

}
elseif ($votevalue == "Downvote")
{
  $user_id = $_SESSION['user_id'];
   $sql = "SELECT * FROM 374scores WHERE rating_id = '$ratingid' AND user_id = '$user_id';";
   $result = mysqli_query($con,$sql);
   $hasupvoted = 0;
   $hasnotvoted = 0;
   while($row = mysqli_fetch_assoc($result))
   {
   //If they have already upvoted, dont let them do so again.
     if($row["voted"] == 1)
     {
      $hasupvoted++;
     }
     $hasnotvoted++;
    
   }
   if($hasnotvoted == 0)
   {
      $sql = "UPDATE 374reviews SET score = score - 1 WHERE rating_id = '$ratingid'";
      $result = mysqli_query($con,$sql);
      $sql = "INSERT INTO 374scores (rating_id,user_id,voted) VALUES ('$ratingid','$user_id','-1');";
      $result = mysqli_query($con,$sql);
   }
   elseif($hasupvoted == 1)
   {
      $sql = "UPDATE 374reviews SET score = score - 1 WHERE rating_id = '$ratingid'";
      $result = mysqli_query($con,$sql);
      
       $sql = "DELETE FROM 374scores WHERE rating_id = '$ratingid' AND user_id = '$user_id';";
       $result = mysqli_query($con,$sql);
   }
   }

   
$sql = "SELECT * FROM 374reviews WHERE rating_id = '$ratingid';";
$jsonresult = mysqli_query($con,$sql);
$jsonrow = mysqli_fetch_assoc($jsonresult);
$returnvalue = $jsonrow["score"];
//json_encode - RETURNS JSON array.
$json = json_encode($returnvalue);
echo $json; //echo to return variable to javascript.

mysqli_close($con);


?>