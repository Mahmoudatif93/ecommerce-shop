<?php 
	/*
	categories =>[manage| edit |update |add |insert|delete|stats]
	*/


	$do='';
if (isset($_GET['do'])) {
	$do= $_GET['do'];
}else{
	$do='manage'; //not return to main page
}
//if the page is main page
if ($do=='manage') {
		echo "welcome you are in mange page";
		echo '<a href="page.php?do=add">add new category +</a>';

}
elseif ($do=='add') {
	echo "welcome you are in add page";
}
elseif ($do=='insert') {
	echo "welcome you are in insert page";
}

else{
	echo "error no page ith this name";
}
?>