<?php 
session_start();

$db = new mysqli("localhost", "ktg349", "C0tton!", "ktg349");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
$uid = $_SESSION["user_id"];
$sql = "UPDATE 374users SET isLoggedIn='0' WHERE user_id='$uid'";
$r2 = $db->query($sql);
// delete all of the session variables
session_destroy();
	
// redirect the user back to the login page
header("Location: login.php");
$db->close();
exit();

?>

