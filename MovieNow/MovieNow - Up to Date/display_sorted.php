<?php
//ACCESS the variable sortby THAT WAS POSTED BY the javascript.
$sortvalue = $_POST['sortby'];
$con = mysqli_connect('localhost','ktg349','C0tton!','ktg349');
if(!$con) {
    die('Could not connect: ' .mysqli_error($con));
}

//THE MYSQLI_SELECT_DB() function is used to change the default database for the// connection.
//SYNTAX : MYSQLI_SELECT_DB(connection,dbname);
mysqli_select_db($con,"ktg349");


if ($sortvalue == "Rating")
{
   $sql ="SELECT * FROM 374movies ORDER BY rating DESC;";
}
elseif ($sortvalue == "Title")
{
    $sql ="SELECT * FROM 374movies ORDER BY title ASC;";
}
else {
   

   $sql ="SELECT * FROM 374movies ORDER BY dateReleased DESC;";
}
//Execute SQL QUERY to fetch sorted results.
$result = mysqli_query($con,$sql);


$allRows = array();
while($row = mysqli_fetch_row($result))
{
  $allRows[] = $row;
}

//json_encode - RETURNS JSON REPRESENTATION OF VALUE.
$json = json_encode($allRows);
echo $json; //echo to return variable to javascript.

mysqli_close($con);
?>
