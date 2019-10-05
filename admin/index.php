 <?php 
 session_start();
 $noNavbar=' ';
 $pageTitle='login';
 // IF session registerd before
 if(isset($_SESSION['username'])){
 	header('location:dashboard.php'); //page dashboard 
 }
include'init.php';

//check if user comming from http post request
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username=$_POST['user'];
	$password=$_POST['pass'];
	$hashedpass=sha1($password);//to convert pass to be hidden
	//check if user and pass exist in database

	$stmt=$con->prepare("SELECT userID,username , password  from users Where username =? AND password=? AND GroupID=1 LIMIT 1 ");
	$stmt->execute(array($username,$hashedpass));
	$row=$stmt->fetch();//get data from select in array

	$count=$stmt->rowCount(); // number of row in database

	// check if count >0  this mean usename in database
	if($count>0){
		
		$_SESSION['Username']=$username; // register session name
		$_SESSION['ID']=$row['userID'];// register session ID
		header('location:dashboard.php');// redirect to another page dashboard 
		exit();

	}
}
?>
	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="username" autocomplete="off"/>
		<input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="login">

	</form>



