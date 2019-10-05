<?php 

/*--------------------
**manage comment page 
**you can |edit|delete|approve comment from here
-----------------------------------

*/
ob_start();
 session_start();

  $pageTitle='Comments';

 if(isset($_SESSION['Username'])){
 	
 	include 'init.php';

if (isset($_GET['do'])) {
	$do= $_GET['do'];
}else{
	$do='manage'; //not return to main page
}
//////////////////////////start manage page///////////////////////////////
if ($do=='manage') {

	
		$stmt=$con->prepare("SELECT comments.*,
								items.Item_Name,
								users.username  
								FROM comments
								INNER JOIN
								items ON items.Item_ID=comments.item_id 
								INNER JOIN
       							users ON users.userID=comments.user_id 

								  ");
		$stmt->execute();
		//assign to variables
		$rows =$stmt->fetchall();
		if (!empty($rows)) {
			
	?>

	<h1 class="text-center">Manage Comments </h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>ID</td>
						<td>Comment</td>
						<td>Item Name</td>
						<td>User Name</td>
						<td>Added Date </td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($rows as $com) {
						echo "<tr>";
							echo "<td>". $com['cID'] ."</td>";
							echo "<td>". $com['comment'] ."</td>";
							echo "<td>". $com['Item_Name'] ."</td>";
							echo "<td>". $com['username'] ."</td>";
							echo "<td>".$com['added_Date']."</td>";
							echo "<td>
									<a href='comment.php?do=edit&comid=".$com['cID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edite</a>
									<a href='comment.php?do=Delete&comid=".$com['cID']."' class='btn btn-danger confirm'><i class='fa fa-times'></i> Delete </a>";

									if ($com['Cstatus']==0) {
									echo"<a href='comment.php?do=approve&comid=".$com['cID']."' class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";}

							echo"</td>";
						echo "</tr>";
					}

					?>
					
					
					

				</table>
			</div>
			
		

				<?php } 
				else{
					echo '<div class="container">';

					echo '<div class="alert alert-info"> there\'s No Comments To Show..!</div>';
				echo '<a href="dashboard.php" class="btn btn-primary"><i class="fa fa-btn"></i>back To home</a>';

					echo '</div>';
				}

			 ?>

		</div>
	
<?php }

	
///////////////////edit page////////////////////////////////////////////////////////////////////////////////////////////////////
elseif ($do =='edit') {#  
	//check if user id is_numeric and get integr value
	if (isset($_GET['comid']) &&is_numeric($_GET['comid'])) {
		$comid= intval($_GET['comid']);
		$stmt=$con->prepare("SELECT * from comments Where cID =? ");
		$stmt->execute(array($comid));
		$row=$stmt->fetch();//get data from select in array

		$count =$stmt->rowCount();
		 // number of row in database
	if ($count > 0) { ?>

		<h1 class="text-center">Edit Comments</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Update" method="POST">
				<input type="hidden" name="comid" value="<?php echo $comid ?>">
				<!--start COMMENT field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Comment</label>
					<div class="col-sm-10 col-md-4">
						<textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
					</div>
				</div>
				<!--end COMMENT field -->
				
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
		$theMsg= "<div class='alert alert-danger'>there is no such id= $comid</div>";
		redirectHome($theMsg);
		echo "</div>";
	}
	
	}
	////////////////////////////////////////////////////////////////////////////////
}
	elseif($do =='Update') { //update page//

			echo "<h1 class='text-center'>update Comments</h1>";
			echo "<div class='container'>";	
			if ($_SERVER['REQUEST_METHOD']=='POST') {
			///////////get varriables update form///////////
				$comid=$_POST['comid'];
				$comment=$_POST['comment'];
				
					

				
				//update database with the new info
				$stmt=$con->prepare("UPDATE  comments SET comment=? WHERE cID=?");

				$stmt->execute(array($comment,$comid));
				//echo sucess update
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record updated'."</div>";
				redirectHome($theMsg,'back',2);
		


		
		}else{
			$theMsg="<div class='alert alert-danger'>YOU cannot browse this page direct</div>";
		redirectHome($theMsg);
		}
		echo "</div>";
	}
///////////////////////////////*****Delete page*****///////////////////////////////////////////////////////////////////////////
	elseif ($do=='Delete') {

		echo "<h1 class='text-center'>Delete Comments</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['comid']) && is_numeric($_GET['comid'])) {
				$comid= intval($_GET['comid']);
				$stmt=$con->prepare("SELECT * from comments Where cID =?   ");
				$check=checkItem('cID','comments',$comid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare(" DELETE FROM comments WHERE cID =:zuser");//to delete by id
				$stmt->bindParam("zuser",$comid);//to connect user by id for delete
				$stmt->execute();
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Deleted'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $comid not exist</div> ";
				redirectHome($theMsg);

			}

		}echo "</div>";
	}
///////////////////////////////////////////////////activate page///////////////////////////////////////
		elseif ($do=='approve') {
			echo "<h1 class='text-center'>Approve Comment</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['comid']) &&is_numeric($_GET['comid'])) {
				$comid= intval($_GET['comid']);
				$stmt=$con->prepare("SELECT * from comments Where cID =?   LIMIT 1 ");
				$check=checkItem('cID','comments',$comid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("UPDATE comments SET Cstatus =1 WHERE cID=? ");//to delete by id
				$stmt->execute(array($comid));
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'comment Approved'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $comid not exist</div> ";
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