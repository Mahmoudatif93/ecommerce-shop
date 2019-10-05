<?php 
	//start the session
session_start();
session_unset(); //unset the data
session_destroy();//destroy session
header('location:index.php');
exit();

?>