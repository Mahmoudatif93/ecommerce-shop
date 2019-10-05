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


/* get CATEGORIES functionsv2
	function to get records from database 
	[users,items ,comments]
	$select =item TO SELECT FROM  table

 */
function getAllFrom($tablenName,$orderBy,$where=NULL){
	global $con;
	$sql=$where==NULL?'' :$where;
	$getAll=$con->prepare("SELECT * FROM $tablenName $sql ORDER BY $orderBy DESC ");
		$getAll->execute();
		$all=$getAll->fetchAll();
		return $all;
}




/* get CATEGORIES functions
	function to get records from database 
	[users,items ,comments]
	$select =item TO SELECT FROM  table

 */
function getcat(){
	global $con;
	$getcat=$con->prepare("SELECT * FROM categories ORDER BY ID ASC ");
		$getcat->execute();
		$cat=$getcat->fetchAll();
		return $cat;
}
/* get ad items functions
	function to get records from database 
	[users,items ,comments]
	$select =item TO SELECT FROM  table

 */
function getItems($where,$value,$Approve=NULL){
	global $con;
	if($Approve==NULL){
		$sql='AND Approve=1';
	}else{
		$sql=NULL;

	}
	$getItems=$con->prepare("SELECT * FROM  items WHERE $where= ? $sql ORDER BY Item_ID DESC ");
		$getItems->execute(array($value));
		$item=$getItems->fetchAll();

		return $item;
}


/////////////////////////////to check if user active (RegStatus from users)///////////////////////////////////////
function checkUsersStatus($user){
global $con;

			$stmtx=$con->prepare("SELECT username,RegStatus from users Where username = ? AND RegStatus=0 ");
			$stmtx->execute(array($user));

			$status=$stmtx->rowCount();

			return $status;
			}

////////////////////////////////////////////////////////////////

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













////////////////////////////////////////////////

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