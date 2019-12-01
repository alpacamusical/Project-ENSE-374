<?php
//ACCESS VARIABLE Q THAT WAS POSTED BY .html
$q = $_POST['q'];
$con = mysqli_connect('localhost','ktg349','C0tton!','ktg349');
//CHECK SQL CONNECTION
if(!$con) {
    die('Could not connect: ' .mysqli_error($con));
}

//THE MYSQLI_SELECT_DB() function is used to change the default database for the// connection.
//SYNTAX : MYSQLI_SELECT_DB(connection,dbname);
mysqli_select_db($con,"ktg349");

$sql ="SELECT * FROM UserLab WHERE email LIKE '$q%'";


//Execute SQL QUERY TO COMPARE EMAIL starting with '$q'
$result = mysqli_query($con,$sql);


$allRows = array();
while($row = mysqli_fetch_row($result))
{
  $allRows[] = $row;
}

//json_encode - RETURNS JSON REPRESENTATION OF VALUE.
$json = json_encode($allRows);
echo $json; //ECHO RETURNS THE VARIABLE.

mysqli_close($con);
?>
