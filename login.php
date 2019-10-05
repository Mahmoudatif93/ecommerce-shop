<?php 
ob_start();
	session_start();
 	$noNavbar=' ';
 	$pageTitle='login';

 	if(isset($_SESSION['user'])){
 		header('location:index.php'); //page dashboard 
 	}
 	include'init.php';

 	//check if user commeng from http post request
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if (isset($_POST['login'])) {
			
		
			$user=$_POST['username'];
			$pass=$_POST['password'];
			$hashpass=sha1($pass);//to convert pass to be hidden
			//check if user and pass exist in database

			$stmt=$con->prepare("SELECT userID, username , password  from users Where username = ? AND password= ? ");
			$stmt->execute(array($user,$hashpass));
			$get=$stmt->fetch();
			$count=$stmt->rowCount(); // number of row in database
			// check if count >0  this mean usename in database
			if($count>0){
				$_SESSION['user']=$user; // register session name
				$_SESSION['uid']=$get['userID'];//register user id in seesin
				header('location:index.php');// redirect to another page dashboard 
				exit();
			}
		}else{ 
			$formErrors=array();
			$user=$_POST['username'];
			$password1=$_POST['password'];
			$password2=$_POST['confrim-password'];
			$email=$_POST['email'];

			//////////vildate username
			if (isset($user)) {
				$filterduser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);

				if (strlen($filterduser) < 4) {
					$formErrors[]='Username must be larger than 4 characters';
					
				}else{

				}

			}
			//////////vildate pass

			if (isset($password1) && isset($password2) ) {
				if (!empty($_POST['password'])) {
				
					 $pass1=sha1($_POST['password']);
					 $pass2=sha1($_POST['confrim-password']);
					 if ($pass1 != $pass2 ) {
					 	$formErrors[]='password not match';
					}
				}else{
			 	$formErrors[]="password cann't be empty";
 
				}		 

		
			}	
			////////////////vildate email

			if (isset($email)) {
             $filterdemail=filter_var($email,FILTER_SANITIZE_EMAIL);
				 if (filter_var($filterdemail,FILTER_VALIDATE_EMAIL)!=true ) {
				 	$formErrors[]=' Email Is not Valid';
				 }
			}



////check if there is no errors
	if(empty($formErrors)){
					//Insert user info In Database 
								/////check if user exist in database///
							$check=checkItem("username","users",$user);
							if ($check==1) {
							$formErrors[]="Sorry Username is exist ";
									} else{

												$stmt=$con->prepare("INSERT INTO 
													users (username,password,Email,RegStatus,Date)
													VALUES(:zuser,:zpass,:zemail,0,now())
													 ");

												$stmt->execute(array(
																'zuser' => $user,
																'zpass' => sha1($password1),
																'zemail' => $email,
																
												));
												//echo sucess message update
												
												$sucessMssg= "congrtlation you are now registared";
												
										}
							}











		}
	}


	

?>
	<div class="container login-page">
		<h1 class="text-center"><span class=" selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
		</h1>
		<!-- start login form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<input class="form-control" type="text" name="username" autocomplete="off" placeholder="type Your username"  >
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type Your Password"  >
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
		</form>
		<!-- end login form -->

		<!-- start signup form -->

		<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<input pattern=".{4,}" title="Username must be more 4 characters" class="form-control" type="text" name="username" autocomplete="off" placeholder="type Your username"  >
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type Your Password" >
			<input class="form-control" type="password" name="confrim-password" autocomplete="new-password" placeholder="Confirm Your Password" >
			<input class="form-control" type="text" name="email"  placeholder="type a valid  Email">
			<input class="btn btn-success btn-block" name="signup" type="submit" value="SignUp">
		</form>
		<!-- end signup form -->
		<div class="the-errors text-center">
			<?php if(!empty($formErrors)){

				foreach ($formErrors as $Error) {
				echo $Error. '<br>';
					
				}}
				if (isset($sucessMssg)) {

					echo $sucessMssg;
				}
		
		?>	
		</div>
	</div>

 <?php include $tpl . 'footer.php';
 		ob_end_flush();
 ?>
