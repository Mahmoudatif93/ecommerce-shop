<?php
/* copy templete page*/
ob_start();
 session_start();

  $pageTitle=' ';
 if(isset($_SESSION['Username'])){
include 'init.php';
$do=isset($_GET['do'])?$_GET['DO']:'manage'; 	
 if ($do=='manage') {
 	echo "welcome";
 }elseif ($do=='add') {

 }elseif ($do=='Insert') {

 }elseif ($do=='edit') {

 } elseif ($do=='Update') {

 } elseif ($do=='Delete') {

 } elseif ($do=='Activate') {

 }
  	include $tpl . 'footer.php';
 }else{

 	header('location:index.php');
 	exit();
 }


ob_end_flush();//release the output

?>


 