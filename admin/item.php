<?php
/* Item  page*/
ob_start();
 session_start();

  $pageTitle=' Items';
 if(isset($_SESSION['Username'])){
include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage'; 	
///////////////////////////////manage PAGE/////////////////////////////////////////////////
 if ($do=='manage') {
 		////////////// INNER JOIN FOR RELATIONS BETWEEN TABLES//
		$stmt=$con->prepare("SELECT items.* 
			,  categories.Name  AS category_name  ,
			users.username FROM items 
			INNER JOIN 
			categories ON categories.ID=items.cat_ID
			INNER JOIN 
			users ON users.userID=items.Member_ID");
		$stmt->execute();
		//assign to variables
		$items =$stmt->fetchall();
		if (!empty($items)) {
	?>

	<h1 class="text-center">Manage Items</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>Name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Adding Date</td>
						<td>Category</td>
						<td>Username</td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($items as $item) {
						echo "<tr>";
							echo "<td>". $item['Item_ID'] ."</td>";
							echo "<td>". $item['Item_Name'] ."</td>";
							echo "<td>". $item['item_Description'] ."</td>";
							echo "<td>". $item['item_price'] ."</td>";
							echo "<td>".$item['ADD_DATE']."</td>";
							echo "<td>".$item['category_name']."</td>";
							echo "<td>".$item['username']."</td>";
							echo "<td>
									<a href='item.php?do=edit&itemid=".$item['Item_ID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edite</a>
									<a href='item.php?do=Delete&itemid=".$item['Item_ID']."' class='btn btn-danger confirm'><i class='fa fa-times'></i> Delete </a>";
									if ($item['Approve']==0) {
									echo"<a href='item.php?do=Approve&itemid=".$item['Item_ID']."' class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";}
							echo"</td>";
						echo "</tr>";
					}

					?>
					
					
					

				</table>
			</div>
			<a href="item.php?do=add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add new Item</a>
			<br>
			<br>
			<br>
		
	<?php } 
				else{
					echo '<div class="container">';

					echo '<div class="alert alert-info"> there\'s No Items To Show..!</div>';
				echo '<a href="item.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add new Item</a>';

					echo '</div>';
				}

			 ?>


		</div>
	
<?php


 	/////////////////////add page///////////////////////////////////////////
 }elseif ($do=='add') {?>


<h1 class="text-center">Add new Items</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
				
				<!--start name field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Name</label>
					<div class="col-sm-10 col-md-4">
						<input type="text"
						 name="Name" class="form-control" 
						   placeholder="Name Of The Item " />

					</div>
				</div>
				<!--end name field -->

				<!--start Description field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Description</label>
					<div class="col-sm-10 col-md-4">
						<input type="text"
						 name="Description" class="form-control"  
						  placeholder="Description Of The Item " />

					</div>
				</div>
				<!--end Description field -->
		

				<!--start price field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">price</label>
					<div class="col-sm-10 col-md-4">
						<input type="text"
						 name="price" class="form-control"  
						  placeholder="price Of The Item " />

					</div>
				</div>
				<!--end price field -->

	<!--start Countary made field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Countary Made</label>
					<div class="col-sm-10 col-md-4">
						<input type="text"
						 name="Countarymade" class="form-control"  
						   placeholder="Countary made Of The Item " />

					</div>
				</div>
				<!--end Countary made field -->

				<!--start  status field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">item status</label>
					<div class="col-sm-10 col-md-4">
						<select  name="status" >
						<option value="0">...</option>
						<option value="1">New</option>
						<option value="2">Like New</option>
						<option value="3">Used</option>
						<option value="4">Old</option>


					</select>

					</div>
				</div>
				<!--end  status field -->
			<!--start  Members field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Member</label>
					<div class="col-sm-10 col-md-4">
						<select  name="Member" >
							<option value="0">...</option>
								<?php
									$allmembers=getAllItems("*","users","","","userID");
									
									foreach ($allmembers as $user) {
										echo "<option value='".$user['userID']."'>".$user['username']."</option>";
										
									}
								 ?>	

					</select>

					</div>
				</div>
				<!--end Members field -->
				<!--start  Category field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Category</label>
					<div class="col-sm-10 col-md-4">
						<select  name="Category" >
							<option value="0">...</option>
								<?php
									$allcats=getAllItems("*","categories","where parent=0","","ID");
									//$stmt=$con->prepare("SELECT * FROM categories");
								//	$stmt->execute();
								//	$cats=$stmt->fetchAll();
									foreach ($allcats as $cat) {
										echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
										$childcats=getAllItems("*","categories","where parent={$cat['ID']}","","ID");
										foreach ($childcats as $child) {
											echo "<option value='".$child['ID']."'>".$child['Name']." child of  --> ".$cat['Name']."</option>";

										}

										
									}
								 ?>	

					</select>

					</div>
				</div>
				<!--end Category field -->


				<!--start tags  field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Tags</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="tags" class="form-control"  
							   placeholder="Seperate Tags with comma(,) " />

						</div>
					</div>
				<!--end tags  field -->




		<!--start button field -->
		<div class="form-group form-group-lg">
					<div class="col-sm--offset-2 col-sm-10">
						<input type="submit" value="Add Item" class="btn btn-primary btn-sm"/>
					</div>
				</div>
		<!--end button field -->
			</form>
		</div>

 <?php } 
  ///////////////////////Insert page//////////////////////////////////////////////////////////////////

 elseif ($do=='Insert') {


if ($_SERVER['REQUEST_METHOD']=='POST') {

			echo "<h1 class='text-center'>Insert Items</h1>";
			echo "<div class='container'>";	
			///////////get varriables from form///////////
				
				$Name=$_POST['Name'];
				$Description=$_POST['Description'];
				$price=$_POST['price'];
				$Countarymade=$_POST['Countarymade'];
				$status=$_POST['status'];
				$member=$_POST['Member'];
				$Category=$_POST['Category'];
				$tags=$_POST['tags'];

				//////////////validate the insert form/////////////////////
				$formErrors=array();

				if (empty($Name)) {
				$formErrors[]='Name cannot be <Strong>Empty</Strong>';
				}
				if (empty($Description)) {
				$formErrors[]='Description cannot be <Strong>Empty</Strong>';

				}
				if(empty($price)){
					$formErrors[]='price cannot be <Strong>Empty</Strong>';
				
				}
				if(empty($Countarymade)){
					$formErrors[]='Countary Made cannot be <Strong>Empty</Strong>';
				
				}
				if($status==0){
					$formErrors[]='You must choose <Strong>status</Strong>';
				
				}
				if($member==0){
					$formErrors[]='You must choose <Strong>member</Strong>';
				
				}
				if($Category==0){
					$formErrors[]='You must choose <Strong>Category</Strong>';
				
				}
				
				////loop into errors array and echo it/////
					foreach ($formErrors as $errors) {
						echo '<div class="alert alert-danger">'. $errors . '<br>'.'</div>';
					}


				
						////if there is no errors /////
						if(empty($formErrors)){
					//Insert user info In Database 
							
												$stmt=$con->prepare("INSERT INTO 
													 ITEMS (Item_Name,item_Description,item_price,Countary_made,item_status,ADD_DATE,cat_ID,Member_ID,tags)
													VALUES(:zname,:zdesc,:zprice,:zmade,:zstatus,now(),:zcat_ID,:zMember_ID,:ztags)
													 ");

												$stmt->execute(array(
																'zname' => $Name,
																'zdesc' => $Description,
																'zprice' => $price,
																'zmade' => $Countarymade,
																'zstatus' => $status,
																'zcat_ID' => $Category,
																'zMember_ID' => $member,
																'ztags' => $tags
												));	
												//echo sucess message update
												echo"<div class='container'>";
												$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Inserted'."</div>";
												redirectHome($theMsg,'back');
												echo "</div>";
										
			}


		///////////error message///////////////
		}else{
		$theMsg="<div class='alert alert-danger'>Sorry you cannot browse this page directly</div>";
		redirectHome($theMsg);
		}
		echo "</div>";

 	////////////////////////edit page/////////////////////////////////////////////////////////////////////
 }elseif ($do=='edit') {

 	//check if itemID is_numeric and get integr value
	if (isset($_GET['itemid']) &&is_numeric($_GET['itemid'])) {
		$itemid= intval($_GET['itemid']);
		$stmt=$con->prepare("SELECT * from items Where 	Item_ID =? ");
		$stmt->execute(array($itemid));
		$item=$stmt->fetch();//get data from select in array

		$count =$stmt->rowCount();
		 // number of row in database
	if ($count > 0) { ?>

			<h1 class="text-center">Edit Items</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="itemid" value="<?php echo $itemid ?>">

					
					<!--start name field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="Name" class="form-control" 
							   placeholder="Name Of The Item " value="<?php echo $item['Item_Name'] ?>" />

						</div>
					</div>
					<!--end name field -->

					<!--start Description field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Description</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="Description" class="form-control"  
							  placeholder="Description Of The Item " value="<?php echo $item['item_Description'] ?>" />

						</div>
					</div>
					<!--end Description field -->
			

					<!--start price field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">price</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="price" class="form-control"  
							  placeholder="price Of The Item "  value="<?php echo $item['item_price'] ?>" />

						</div>
					</div>
					<!--end price field -->

		<!--start Countary made field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Countary Made</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="Countarymade" class="form-control"  
							   placeholder="Countary made Of The Item "  value="<?php echo $item['Countary_made'] ?>"/>

						</div>
					</div>
					<!--end Countary made field -->

					<!--start  status field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">item status</label>
						<div class="col-sm-10 col-md-4">
							<select  name="status" >
							<option value="1"<?php if ($item['item_status']==1){echo 'selected';}?> >New</option>
							<option value="2" <?php if ($item['item_status']==2){echo 'selected';}?>>Like New</option>
							<option value="3" <?php if ($item['item_status']==3){echo 'selected';}?>>Used</option>
							<option value="4" <?php if ($item['item_status']==4){echo 'selected';}?>>Old</option>


						</select>

						</div>
					</div>
					<!--end  status field -->
				<!--start  Members field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Member</label>
						<div class="col-sm-10 col-md-4">
							<select  name="Member" >
									<?php
										$stmt=$con->prepare("SELECT * FROM users");
										$stmt->execute();
										$users=$stmt->fetchAll();
										foreach ($users as $user) {
											echo "<option value='".$user['userID']."'" ; 
											 if ($item['Member_ID']==$user['userID']){echo 'selected';}
											  echo ">".$user['username']."</option>";	
										}
									 ?>	
						</select>
						</div>
					</div>
					<!--end Members field -->
					<!--start  Category field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Category</label>
						<div class="col-sm-10 col-md-4">
							<select  name="Category" >
								
									<?php
										$stmt=$con->prepare("SELECT * FROM categories");
										$stmt->execute();
										$cats=$stmt->fetchAll();
										foreach ($cats as $cat) {
											echo "<option value='".$cat['ID']."'"; 
										   if ($item['cat_ID']==$cat['ID']){echo 'selected';}
											echo">".$cat['Name']."</option>";
											
										}
									 ?>	

						</select>

						</div>
					</div>
					<!--end Category field -->





				<!--start tags  field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Tags</label>
						<div class="col-sm-10 col-md-4">
							<input type="text"
							 name="tags" class="form-control"  
							   placeholder="Seperate Tags with comma(,)" value="<?php echo $item['tags'] ?>"  />

						</div>
					</div>
					<!--end tags  field -->











			<!--start button field -->
			<div class="form-group form-group-lg">
						<div class="col-sm--offset-2 col-sm-10">
							<input type="submit" value="Update Item" class="btn btn-primary btn-sm"/>
						</div>
					</div>
			<!--end button field -->

				</form>
<!--//////////////////////////////////////to show comments in item page /////////////////////-->
	<?php
		$stmt=$con->prepare("SELECT comments.*,
								users.username  
								FROM comments
								INNER JOIN
       							users ON users.userID=comments.user_id WHERE
       							item_id=?

								  ");
		$stmt->execute(array($itemid));
		//assign to variables
		$rows =$stmt->fetchall();
		if (!empty($rows)) {
			
		
	?>

	<h1 class="text-center">Manage [<?php echo $item['Item_Name'] ?>] Comments </h1>
		
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>Comment</td>
						<td>User Name</td>
						<td>Added Date </td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($rows as $com) {
						echo "<tr>";
							echo "<td>". $com['comment'] ."</td>";
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
			<?php } ?>
			</div>
			
	

<!--////////////////////////////////////////////-->





			</div>

		
<?php 
	}else{
		echo "<div class='container'>";
		$theMsg= "<div class='alert alert-danger'>there is no such id= $itemid</div>";
		redirectHome($theMsg);
		echo "</div>";
	}
	
	}


 	//////////////////////////////update page///////////////////////////////////////////////////////

 } elseif ($do=='Update') {


			echo "<h1 class='text-center'>update Item</h1>";
			echo "<div class='container'>";	
			if ($_SERVER['REQUEST_METHOD']=='POST') {
			///////////get varriables update form///////////
				$id=$_POST['itemid'];
				$Name=$_POST['Name'];
				$Description=$_POST['Description'];
				$price=$_POST['price'];
				$Countarymade=$_POST['Countarymade'];
				$status=$_POST['status'];
				$Category=$_POST['Category'];
				$Member=$_POST['Member'];
				
				//////////////validate the form/////////////////////
				//////////////validate the insert form/////////////////////
				$formErrors=array();

				if (empty($Name)) {
				$formErrors[]='Name cannot be <Strong>Empty</Strong>';
				}
				if (empty($Description)) {
				$formErrors[]='Description cannot be <Strong>Empty</Strong>';

				}
				if(empty($price)){
					$formErrors[]='price cannot be <Strong>Empty</Strong>';
				
				}
				if(empty($Countarymade)){
					$formErrors[]='Countary Made cannot be <Strong>Empty</Strong>';
				
				}
				if($status==0){
					$formErrors[]='You must choose <Strong>status</Strong>';
				
				}
				if($Member==0){
					$formErrors[]='You must choose <Strong>member</Strong>';
				
				}
				if($Category==0){
					$formErrors[]='You must choose <Strong>Category</Strong>';
				
				}
				
				////loop into errors array and echo it/////
					foreach ($formErrors as $errors) {
						echo '<div class="alert alert-danger">'. $errors . '<br>'.'</div>';
					}

					////if there is no errors /////
					if(empty($formErrors)){
				//update database with the new info
				$stmt=$con->prepare("UPDATE
										 items 
									 SET 
									 	Item_Name=? ,item_Description=? ,item_price=? ,Countary_made=? ,item_status=?,cat_ID=? ,Member_ID=?
									 	 WHERE Item_ID=?");
				$stmt->execute(array($Name , $Description,$price,$Countarymade,$status,$Category,$Member,$id));

				//echo sucess update
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record updated'."</div>";
				redirectHome($theMsg,'back',4);
			}


		
		}else{
			$theMsg="<div class='alert alert-danger'>YOU cannot browse this page direct</div>";
		redirectHome($theMsg);
		}
		echo "</div>";



///////////////////////////////Delete page////////////////////////////////////////////
 } elseif ($do=='Delete') {

echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['itemid']) &&is_numeric($_GET['itemid'])) {
				$itemid= intval($_GET['itemid']);
				$check=checkItem('Item_ID',' items',$itemid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("DELETE FROM items WHERE Item_ID=:zid");//to delete by id
				$stmt->bindParam("zid",$itemid);//to connect user by id for delete
				$stmt->execute();
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Deleted'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $itemid not exist</div> ";
				redirectHome($theMsg);

			}

		}echo "</div>";

//////////////////////Approve page///////////////////////////////////////////////
 } elseif ($do=='Approve') {

echo "<h1 class='text-center'>Approve Item</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['itemid']) &&is_numeric($_GET['itemid'])) {
				$itemid= intval($_GET['itemid']);
				$check=checkItem('Item_ID','items',$itemid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("UPDATE items SET Approve=1 WHERE Item_ID=? ");//to delete by id
				$stmt->execute(array($itemid));
				echo "<div class='container'>";
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record Approved'."</div>";
				redirectHome($theMsg,'back');
				echo "</div>";

			}else{

				$theMsg= "<div class='alert alert-danger'>this ID = $itemid not exist</div> ";
				redirectHome($theMsg);

			}

		}echo "</div>";


/////////////////////////////////////////////////////////////////////
 }
  	include $tpl . 'footer.php';
 }else{

 	header('location:index.php');
 	exit();
 }


ob_end_flush();//release the output

?>


