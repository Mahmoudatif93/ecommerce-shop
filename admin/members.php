<?php 

/*--------------------
**manage member page 
**you can add |edit|delete members from here
-----------------------------------

*/
ob_start();
 session_start();

  $pageTitle='members';

 if(isset($_SESSION['Username'])){
 	
 	include 'init.php';

if (isset($_GET['do'])) {
	$do= $_GET['do'];
}else{
	$do='manage'; //not return to main page
}
//////////////////////////start manage page///////////////////////////////
if ($do=='manage') {
	//select all except admin
	$query='';
	if (isset($_GET['page']) && $_GET['page']='pending') {
		$query='AND RegStatus=0';
	}
	
		$stmt=$con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
		$stmt->execute();
		//assign to variables
		$rows =$stmt->fetchall();
		if (!empty($rows)) {
			
				
			?>

			<h1 class="text-center">Manage Members</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table manage-members text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Profile</td>
								<td>Username</td>
								<td>Email</td>
								<td>Full Name</td>
								<td>Registered Date</td>
								<td>Control</td>
							</tr>
							<?php 
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>". $row['userID'] ."</td>";
									echo "<td>";
										if (!empty($row['profile'] )) {
											echo "<img src='upload/profile/". $row['profile']."' alt=''/>";
										}else{
											echo "<img src='upload/profile/default-img.png' alt=''/>";

										}

									echo "</td>";
									echo "<td>". $row['username'] ."</td>";
									echo "<td>". $row['Email'] ."</td>";
									echo "<td>". $row['FullName'] ."</td>";
									echo "<td>".$row['Date']."</td>";
									echo "<td>
											<a href='members.php?do=edit&userid=".$row['userID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edite</a>
											<a href='members.php?do=Delete&userid=".$row['userID']."' class='btn btn-danger confirm'><i class='fa fa-times'></i> Delete </a>";

											if ($row['RegStatus']==0) {
											echo"<a href='members.php?do=Activate&userid=".$row['userID']."' class='btn btn-info activate'><i class='fa fa-check'></i> Activate </a>";}

									echo"</td>";
								echo "</tr>";
							}

							?>
							
							
							

						</table>
					</div>
					<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add new member</a>
					<br>
					<br>
					<br>
				

			<?php } 
				else{
					echo '<div class="container">';

					echo '<div class="alert alert-info"> there\'s No Members To Show..!</div>';
				echo '<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add new member</a>';

					echo '</div>';
				}

			 ?>

		</div>
	
<?php }
/////////////////////start add page////////////////////////////////////////////////////////////////////////////////////////////
elseif ($do=='add') {?>

<h1 class="text-center">Add new Member</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data"><!--encryption for img upload -->
				
				<!--start username field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Username</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username to login" />

					</div>
				</div>
				<!--end username field -->
				<!--start pass field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">password</label>
					<div class="col-sm-10 col-md-4">
						<input type="password" name="password" class=" password form-control" autocomplete="new-password" required="required"placeholder="password must be hard & complex"/>
						<i class="show-pass fa fa-eye fa-2x"></i>
					</div>
				</div>
				<!--end pass field -->
				<!--start email field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-4">
						<input type="email" name="email" class="form-control"  required="required" placeholder="Email must be valid"/>
					</div>
				</div>
				<!--end email field -->
				<!--start fulname field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full name</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="fullname" class="form-control"  required="required"placeholder="Full name will appear in your profile page" />
					</div>
				</div>
				<!--end fulname field -->



	<!--start profile img field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Profile Image</label>
					<div class="col-sm-10 col-md-4">
						<input type="file" name="Profile" class="form-control" required />
					</div>
				</div>
				<!--end profile img field -->



		<!--start button field -->
		<div class="form-group form-group-lg">
					<div class="col-sm--offset-2 col-sm-10">
						<input type="submit" value="Add member" class="btn btn-primary btn-lg"/>
					</div>
				</div>
		<!--end button field -->
			</form>
		</div>


	
<?php }

//////////////////////////////////////////INSERT PAGE//////////////////////////////////////////////////////
elseif ($do =='Insert') {

			if ($_SERVER['REQUEST_METHOD']=='POST') {

			echo "<h1 class='text-center'>Insert Member</h1>";
			echo "<div class='container'>";	


			//////////////upload photo USE super GLOBAL ///////////////////
				$Profile=$_FILES['Profile'];
				$profileName=$_FILES['Profile']['name'];
				$profileSize= $_FILES['Profile']['size'];
				$profileTmp=$_FILES['Profile']['tmp_name'];
				$profileType=$_FILES['Profile']['type'];
				$profileAllowExtension=array("jpeg","jpg","png","gif"); //list of allow file typed of upload
			///check profile extensions 
				$profileExplode=explode('.', $profileName); // to transfer to array
				$profileExtension=strtolower(end($profileExplode));//to get last index in array of  profile extension in small char

			///////////get varriables from form///////////
				
				$user=$_POST['username'];
				$pass=$_POST['password'];
				$email=$_POST['email'];
				$name=$_POST['fullname'];
				$hashpass=sha1($_POST['password']);
				//////////////validate the insert form/////////////////////
				$formErrors=array();

				if (strlen($user)<4) {
				$formErrors[]='username cannot be less than <Strong>4 characters</Strong>';
				}
				if (strlen($user)>20) {
				$formErrors[]='username cannot be more than<Strong> 20 characters</Strong>';

				}
				if(empty($user)){
					$formErrors[]='username cannot be<Strong> empty</Strong>';
				
				}
				if(empty($pass)){
					$formErrors[]='password cannot be<Strong>empty</Strong>';
				
				}
				if(empty($email)){
					$formErrors[]='email cannot be<Strong>empty</Strong>';
				
				}
				if(empty($name)){
					$formErrors[]='fullname cannot be <Strong>empty</Strong>';
				}

				if (! empty($profileName) && ! in_array($profileExtension, $profileAllowExtension)) {
					$formErrors[]='This Extension Not <Strong>Allowed</Strong>';
				}

				if (empty($profileName)) {
					$formErrors[]='Image Profile Is <Strong>Required</Strong>';
				}
				if ($profileSize > 4194304) { // size of max upload in byte
					$formErrors[]='Image caanot be larger than  <Strong>MegaByte</Strong>';
				}
				////loop into errors array and echo it/////
					foreach ($formErrors as $errors) {
						echo '<div class="alert alert-danger">'. $errors . '<br>'.'</div>';
					}


				
						////if there is no errors /////
						if(empty($formErrors)){
					//Insert user info In Database 
								/////check if user exist in database///
							$profile=rand(0,100000). '_'.$profileName;///to get random number with profile name
							move_uploaded_file($profileTmp, "upload\profile\\". $profile);//to transfer file from his temporry path to his new path with its name
							$check=checkItem("username","users",$user);
							if ($check==1) {
							$theMsg="<div class='alert alert-danger'>sorry Username is exist </div>";
								redirectHome($theMsg,'back');
									} else{

												$stmt=$con->prepare("INSERT INTO 
													users (username,password,Email,FullName,RegStatus,Date,profile)
													VALUES(:zuser,:zpass,:zemail,:zname,1,now(),:zprofile)
													 ");

												$stmt->execute(array(
																'zuser' => $user,
																'zpass' => $hashpass,
																'zemail' => $email,
																'zname' => $name,
																'zprofile' => $profile
												));
												//echo sucess message update
												echo"<div class='container'>";
												$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Inserted'."</div>";
												redirectHome($theMsg,'back');
												echo "</div>";
										}
			}


		///////////error message///////////////
		}else{
		$theMsg="<div class='alert alert-danger'>Sorry you cannot browse this page directly</div>";
		redirectHome($theMsg);
		}
		echo "</div>";
	}
	
///////////////////edit page////////////////////////////////////////////////////////////////////////////////////////////////////

elseif ($do =='edit') {# edit page 
	//check if user id is_numeric and get integr value
	if (isset($_GET['userid']) &&is_numeric($_GET['userid'])) {
		$userid= intval($_GET['userid']);
		$stmt=$con->prepare("SELECT * from users Where userID =?   LIMIT 1 ");
		$stmt->execute(array($userid));
		$row=$stmt->fetch();//get data from select in array

		$count =$stmt->rowCount();
		 // number of row in database
	if ($count > 0) { ?>

		<h1 class="text-center">Edit Member</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Update" method="POST">
				<input type="hidden" name="userID" value="<?php echo $userid ?>">
				<!--start username field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Username</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" autocomplete="off" required="required" />

					</div>
				</div>
				<!--end username field -->
				<!--start pass field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">password</label>
					<div class="col-sm-10 col-md-4">
						<input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
						<input type="password" name="newpassword" class="form-control" autocomplete="new-password"placeholder="Leave blank if you donn't want to change it"/>
					</div>
				</div>
				<!--end pass field -->
				<!--start email field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-4">
						<input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required"/>
					</div>
				</div>
				<!--end email field -->
				<!--start fulname field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full name</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="fullname" class="form-control"  value="<?php echo $row['FullName'] ?>" required="required" />
					</div>
				</div>
				<!--end email field -->

		<!--start button field -->
		<div class="form-group form-group-lg">
					<div class="col-sm--offset-2 col-sm-10">
						<input type="submit" value="Update" class="btn btn-primary btn-lg"/>
					</div>
				</div>
		<!--end button field -->
			</form>
		</div>

<?php 
	}else{
		echo "<div class='container'>";
		$theMsg= "<div class='alert alert-danger'>there is no such id= $userid</div>";
		redirectHome($theMsg);
		echo "</div>";
	}
	
	}
	////////////////////////////////////////////////////////////////////////////////
}
	elseif($do =='Update') { //update page//

			echo "<h1 class='text-center'>update Member</h1>";
			echo "<div class='container'>";	
			if ($_SERVER['REQUEST_METHOD']=='POST') {
			///////////get varriables update form///////////
				$id=$_POST['userID'];
				$user=$_POST['username'];
				$email=$_POST['email'];
				$name=$_POST['fullname'];
				/////////////password update//////////////////
				$pass='';
				if(empty($_POST['newpassword']))
				{
					$pass=$_POST['oldpassword'];
				}else{

					$pass=sha1($_POST['newpassword']);

				}
				//////////////validate the form/////////////////////
				$formErrors=array();

				if (strlen($user)<4) {
				$formErrors[]='username cannot be less than <Strong>4 characters</Strong>';
				}
				if (strlen($user)>20) {
				$formErrors[]='username cannot be more than<Strong> 20 characters</Strong>';

				}
				if(empty($user)){
					$formErrors[]='username cannot be<Strong> empty</Strong>';
				
				}
				if(empty($email)){
					$formErrors[]='email cannot be<Strong>empty</Strong>';
				
				}
				if(empty($name)){
					$formErrors[]='fullname cannot be <Strong>empty</Strong>';
				
				}
				////loop into errors array and echo it/////
					foreach ($formErrors as $errors) {
						echo "<div class='alert alert-success'>". $stmt->rowCount().'Record updated'."</div>";
					}

					////if there is no errors /////
					if(empty($formErrors)){
				//update database with the new info
				$stmt=$con->prepare("UPDATE users SET username=? ,Email=? ,FullName=? ,password=? WHERE userID=?");

				$stmt->execute(array($user,$email,$name,$pass,$id));
				//echo sucess update
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record updated'."</div>";
				redirectHome($theMsg,'back',4);
			}


		
		}else{
			$theMsg="<div class='alert alert-danger'>YOU cannot browse this page direct</div>";
		redirectHome($theMsg);
		}
		echo "</div>";
	}
		
///////////////////////////////*****Delete page*****///////////////////////////////////////////////////////////////////////////
	elseif ($do=='Delete') {
		echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['userid']) &&is_numeric($_GET['userid'])) {
				$userid= intval($_GET['userid']);
				$stmt=$con->prepare("SELECT * from users Where userID =?   LIMIT 1 ");
				$check=checkItem('userID','users',$userid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("DELETE FROM users WHERE userID=:zuser");//to delete by id
				$stmt->bindParam("zuser",$userid);//to connect user by id for delete
				$stmt->execute();
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Deleted'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $userid not exist</div> ";
				redirectHome($theMsg);

			}

		}echo "</div>";
	}

///////////////////////////////////////////////////activate page///////////////////////////////////////
		elseif ($do=='Activate') {
			echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['userid']) &&is_numeric($_GET['userid'])) {
				$userid= intval($_GET['userid']);
				$stmt=$con->prepare("SELECT * from users Where userID =?   LIMIT 1 ");
				$check=checkItem('userID','users',$userid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("UPDATE users SET RegStatus=1 WHERE userID=? ");//to delete by id
				$stmt->execute(array($userid));
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Activated'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $userid not exist</div> ";
				redirectHome($theMsg);

			}

		}echo "</div>";
		}
//////////////////////////////////////////////////////////////////////////////////////////////////
 	include $tpl . 'footer.php';
 }else{

 	echo 'you are not authorized to see this page';
 	header('location:index.php');
 	exit();
 }


ob_end_flush();

?>