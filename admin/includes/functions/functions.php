<?php 


/* get CATEGORIES functionsv3
	function to get ALL records from database 

 */


function getAllItems($field,$table,$where=NULL,$and=NULL,$orderfild,$ordering="DESC"){
	global $con;
	$getAll=$con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfild $ordering ");
		$getAll->execute();
		$all=$getAll->fetchAll();
		return $all;
}





/*v1
title functions that echo page title in case the page has 
**the variable $pagetitle and echo defult title for other pages
*/
function getTitle(){
	global $pageTitle;
	if (isset($pageTitle)) {
		echo $pageTitle;
	}else{
		echo 'Default';
	}


}
/* home Redirect functions v1
	update message to v2
	added
	msg=[error,success,warning]
	url=link that you want to redirect to
*/

function redirectHome($theMsg,$url=null,$seconds =3){
	if($url===null){
		$url='index.php';
		$link='home page';
	}else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==' '){///to make sure of  HTTP_REFERER found and not empty
			$url=$_SERVER['HTTP_REFERER'];//return to link that you come from it
			$link='previous page';
		}else{//if there is no HTTP_REFERER found 
			$url='index.php';
			$link='home page';
		}
		
	}
	echo $theMsg;
	//echo "<div class='alert alert-danger'>$errorMsg</div>";
	echo "<div class='alert alert-info'>You will be Redireceted to $link after $seconds Seconds.</div>";
	header("refresh:$seconds,url=$url");
	exit();
}



/*function to check item in database to prevent duplicated v1 
$select =item TO SELECT FROM  table
$from=the table to select from
$value=the value to select from item
*/

function checkItem($select,$from,$value){
	global $con;
	$statment=$con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statment->execute(array($value));
	$count=$statment->rowCount();
	return $count;/// return item not like echo return value of output


}



/*count number of items in database f.v1
	function to count number of rows in database
item= item to count
table=the table that you want to choose from	
*/

function countItems($item,$table){
	global $con;
	$stmt2=$con->prepare("SELECT COUNT($item)FROM $table ");
 	$stmt2->execute();
 	return $stmt2->fetchColumn();

}


/* get latest record functions
	function to get latest items from database 
	[users,items ,comments]
	$select =item TO SELECT FROM  table

 */
function getLatests($select,$table,$order,$limit = 5){
	global $con;
	$getstmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC limit $limit");
		$getstmt->execute();
		$rows=$getstmt->fetchAll();
		return $rows;
}


?>