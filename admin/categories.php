<?php
/* Categories page*/
ob_start();
 session_start();

  $pageTitle=' Categories';
 if(isset($_SESSION['Username'])){

include 'init.php';

if (isset($_GET['do'])) {
	$do= $_GET['do'];
}else{
	$do='manage'; //not return to main page
}

/////////////////////////////////////////////// manage page////////
 if ($do=='manage') {
 	$sort='ASC';
 	$sort_array= array("ASC","DESC" );
 	if (isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array)) {
 		$sort=$_GET['sort'];

 	}
 	$stmt2=$con->prepare("SELECT * FROM categories  Where parent=0 ORDER BY Ordering $sort");
 	$stmt2->execute();
 	$cats=$stmt2->fetchAll(); //to get all data from database

 		if (!empty($cats)) {
 			
 		
 	?>

 	<h1 class="text-center">Manage Categories</h1>
 	<div class="container Categories">
 		<div class="panel panel-default">
 				<div class="panel-heading"><i class="fa fa-edit"></i>Manage Categories
 				<div class="option float-right">
 					<i class="fa fa-sort"></i>Ordering:[
 					<a class="<?php if($sort=='ASC'){echo'active';} ?>" href="?sort=ASC">Asc</a> |
 					<a class="<?php if($sort=='DESC'){echo'active';} ?>" href="?sort=DESC">Desc</a> ]
 					 <i class="fa fa-eye"></i> view:[
 					<span class="active" data-view='Full'>Full</span> |
 					<span data-view='Classic'>Classic</span>]
 				</div>

 			</div>

 			<div class="card card-body">
 				<?php
 					foreach ($cats as $cat) {
 						echo "<div class='cat'>";
 							echo "<div class='hidden-buttons'>";
 								echo "<a href='categories.php?do=edit&catid=". $cat['ID'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
 								echo "<a href='categories.php?do=Delete&catid=". $cat['ID'] ."' class='confirm btn btn-xs btn-danger'><i class='fa fa-times'></i> Delete</a>";
 							echo"</div>";
	 						echo '<h3>'.$cat['Name'].'</h3>';
	 						echo "<div class='full-view'>";
		 						echo "<p>"; 
		 						if ($cat['Description'] == '') { echo 'this category has no description';}
		 						else{ echo $cat['Description'] ;}
		 					  	echo "</p>";
		 						if ($cat['Visibility'] == 1) {	echo'<span class="Visibility"><i class="fa fa-eye"></i> Hidden</span>';}
								if ($cat['Allow_Comments'] == 1) {	echo'<span class="comments"><i class="fa fa-times"></i> Comment Disabled</span>';}
								if ($cat['Allow_Advertisement'] == 1) {	echo'<span class="Advertisement"><i class="fa fa-times"></i> Advertisement Disabled</span>';}
 						
		//get child category/////////////////////////
  				 $childcat=getAllItems("*","categories","where parent={$cat['ID']}","","ID","ASC");
                 if(!empty($childcat)){
                 echo "<h5 class='child-head'>Child Categories</h5>";
                 echo "<ul class='list-unstyled child-cat'>";
                   foreach ($childcat as $c) {
						echo "<li> 
						<a class='child-a' href='categories.php?do=edit&catid=". $c['ID'] ."' class='child-cat'>". $c['Name']."</a>
				<a href='categories.php?do=Delete&catid=". $cat['ID'] ."' class='confirm show-delete'> Delete</a>
						</li>";}
				echo "</ul>";
					}
////////////////////////////////////////////////////////

 						echo "</div>";
 						echo "</div>";	
						echo "<hr>";
 					}
 				 ?>	


 				</div>

 		</div>
 		<a href="categories.php?do=add" class="btn btn-primary add-category"><i class="fa fa-plus"></i> Add New Category</a>


 		<?php } 
				else{
					echo '<div class="container">';

					echo '<div class="alert alert-info"> there\'s No Categories To Show..!</div>';
				echo '<a href="categories.php?do=add" class="btn btn-primary add-category"><i class="fa fa-plus"></i> Add New Category</a>';

					echo '</div>';
				}

			 ?>
 	</div>

<?php 
 	///////////////add category page//////////////////
 }elseif ($do=='add') {?>


<h1 class="text-center">Add new Category</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
				
				<!--start name field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Name</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="Name" class="form-control" autocomplete="off" required="required" placeholder="Name Of Category " />

					</div>
				</div>
				<!--end name field -->
				<!--start Description field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="description" class=" form-control"placeholder="Describe the Category "/>
					</div>
				</div>
				<!--end Description field -->
				<!--start Ordering field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Ordering</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="Ordering" class="form-control"placeholder="Number to ordering the Categories"/>
					</div>
				</div>

				<!--end Ordering field -->
			
				<!--start category type(parent,child) field -->
			<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Parent?</label>
					<div class="col-sm-10 col-md-4">
						<select name="parent">
							<option value="0">None</option>
							<?php

							$allcats=getAllItems("*","categories","","","ID","ASC");
							foreach ($allcats as $allcats) {

								echo "<option value='".$allcats['ID'] ."'>".$allcats['Name']."</option>";
								# code...
							}

							 ?>
						</select>

					</div>
				</div>


				<!--end category type(parent,child) field -->


				<!--start Visibility field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Visibility</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="vis-yes" type="radio" name="Visibility" value="0" checked>
							<label for="vis-yes">Yes</label>
						</div>
						<div>
							<input id="vis-no" type="radio" name="Visibility" value="1" >
							<label for="vis-no">No</label>
						</div>
					</div>
				</div>
				<!--end Visibility field -->

					<!--start Comments field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Commenting</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="com-yes" type="radio" name="Commenting" value="0" checked>
							<label for="com-yes">Yes</label>
						</div>
						<div>
							<input id="com-no" type="radio" name="Commenting" value="1" >
							<label for="com-no">No</label>
						</div>
					</div>
				</div>
				<!--end Comments field -->
					<!--start Advertisement field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Advertisement</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="addv-yes" type="radio" name="Advertisement" value="0" checked>
							<label for="addv-yes">Yes</label>
						</div>
						<div>
							<input id="addv-no" type="radio" name="Advertisement" value="1" >
							<label for="addv-no">No</label>
						</div>
					</div>
				</div>
				<!--end Advertisement field -->


		<!--start button field -->
		<div class="form-group form-group-lg">
					<div class="col-sm--offset-2 col-sm-10">
						<input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
					</div>
				</div>
		<!--end button field -->
			</form>
		</div>




<?php
///////////////////////////////Insert page related to add page/////////////////////////////////////////////
 }elseif ($do=='Insert') {

			if ($_SERVER['REQUEST_METHOD']=='POST') {

			echo "<h1 class='text-center'>Insert category</h1>";
			echo "<div class='container'>";	
			///////////get varriables from form///////////
				
				$Name=$_POST['Name'];
				$Desc=($_POST['description']);
				$parent=($_POST['parent']);
				$order=$_POST['Ordering'];
				$Visibe=$_POST['Visibility'];
				$comment=$_POST['Commenting'];
				$Advertis=$_POST['Advertisement'];
				//////////////validate the insert form/////////////////////
						////if there is no errors /////
					
					//Insert user info In Database 
								/////check if category exist in database///
							$check=checkItem("Name","categories",$Name);
							if ($check==1) {
							$theMsg="<div class='alert alert-danger'>sorry category is exist </div>";
								redirectHome($theMsg,'back');
									} else{
										//////////////insert in database

												$stmt=$con->prepare("INSERT INTO 
													categories (Name,Description,parent,Ordering,Visibility,Allow_Comments,Allow_Advertisement)
													VALUES(:zname,:zdesc,:zparent,:zorder,:zvisible,:zcomment,:zAdvertis)
													 ");

												$stmt->execute(array(
																':zname' => $Name,
																'zdesc' => $Desc,
																'zparent' => $parent,
																'zorder' => $order,
																'zvisible' => $Visibe,
																'zcomment' => $comment,
																'zAdvertis' => $Advertis
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



////////////////////edit page RELATET TO Update page//////////////////////////////////////////////////////

 }elseif ($do=='edit') {
 	//check if user cat id is_numeric and get integr value
	if (isset($_GET['catid']) &&is_numeric($_GET['catid'])) {
		$catid= intval($_GET['catid']);
		$stmt=$con->prepare("SELECT * from categories Where ID =? ");
		$stmt->execute(array($catid));
		$cat=$stmt->fetch();//get data from select in array

		$count =$stmt->rowCount();
		 // number of row in database
	if ($count > 0) { ?>
		<h1 class="text-center">Edit Category</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Update" method="POST">
				<input type="Hidden" name="catid" value="<?php echo$catid ?>">
				
				<!--start name field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2  control-label">Name</label>
					<div class="col-sm-10 col-md-4">
					<input type="text" name="Name" class="form-control"required="required" placeholder="Name Of Category " value="<?php echo $cat['Name'];?>" />

					</div>
				</div>
				<!--end name field -->
				<!--start Description field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="description" class=" form-control"placeholder="Describe the Category " value="<?php echo $cat['Description'];?>"/>
					</div>
				</div>
				<!--end Description field -->
				<!--start Ordering field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Ordering</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="Ordering" class="form-control"placeholder="Number to ordering the Categories" value="<?php echo $cat['Ordering'];?>"/>
					</div>
				</div>
				<!--end Ordering field -->


	<!--start category type(parent,child) field -->
			<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Parent?</label>
					<div class="col-sm-10 col-md-4">
						<select name="parent">
							<option value="0">None</option>
							<?php

							$allcats=getAllItems("*","categories","","","ID","ASC");
							foreach ($allcats as $c) {
								
								
								echo "<option value='".$c['ID']."' " ;
								if ( $cat['parent']==$c['ID']) {echo 'Selected';}
								echo ">". $c['Name']."</option>";
								# code...
								
							}


							 ?>
						</select>

					</div>
				</div>


				<!--end category type(parent,child) field -->


				<!--start Visibility field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Visibility</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="vis-yes" type="radio" name="Visibility" value="0" <?php if ($cat['Visibility']==0) {	echo "checked";	} ?>>
							<label for="vis-yes">Yes</label>
						</div>
						<div>
							<input id="vis-no" type="radio" name="Visibility" value="1" <?php if ($cat['Visibility']==1) {	echo "checked";	} ?> >
							<label for="vis-no">No</label>
						</div>
					</div>
				</div>
				<!--end Visibility field -->

					<!--start Comments field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Commenting</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="com-yes" type="radio" name="Commenting" value="0" <?php if ($cat['Allow_Comments']==0){echo "checked";} ?> >
							<label for="com-yes">Yes</label>
						</div>
						<div>
							<input id="com-no" type="radio" name="Commenting" value="1"<?php if ($cat['Allow_Comments']==1){echo "checked";} ?> >
							<label for="com-no">No</label>
						</div>
					</div>
				</div>
				<!--end Comments field -->
					<!--start Advertisement field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Advertisement</label>
					<div class="col-sm-10 col-md-4">
						<div>
							<input id="addv-yes" type="radio" name="Advertisement" value="0"<?php if($cat['Allow_Advertisement']==0){echo "checked";} ?>>
							<label for="addv-yes">Yes</label>
						</div>
						<div>
							<input id="addv-no" type="radio" name="Advertisement" value="1" <?php if($cat['Allow_Advertisement']==1){echo "checked";} ?> >
							<label for="addv-no">No</label>
						</div>
					</div>
				</div>
				<!--end Advertisement field -->


		<!--start button field -->
		<div class="form-group form-group-lg">
					<div class="col-sm--offset-2 col-sm-10">
						<input type="submit" value="Update Category" class="btn btn-primary btn-lg"/>
					</div>
				</div>
		<!--end button field -->
			</form>
		</div>


<?php 
	}else{
		echo "<div class='container'>";
		$theMsg= "<div class='alert alert-danger'>there is no such id= $catid</div>";
		redirectHome($theMsg);
		echo "</div>";
	}
	
	}




 	//////////////////////////////Update page/////////////////////////////////////////////////////////////////

 } elseif ($do=='Update') {


			echo "<h1 class='text-center'>update category</h1>";
			echo "<div class='container'>";	
			if ($_SERVER['REQUEST_METHOD']=='POST') {
			///////////get varriables update form///////////
				$id=$_POST['catid'];
				$name=$_POST['Name'];
				$desc=$_POST['description'];
				$order=$_POST['Ordering'];
				$parent=$_POST['parent'];
				$visible=$_POST['Visibility'];
				$comment=$_POST['Commenting'];
				$Advertis=$_POST['Advertisement'];
							//update database with the new info
				$stmt=$con->prepare("UPDATE categories SET Name	=? ,Description	=? ,Ordering=?,parent=? ,Visibility=?,Allow_Comments=? ,Allow_Advertisement=? WHERE ID=?");

				$stmt->execute(array($name,$desc,$order,$parent,$visible,$comment,$Advertis,$id));
				//echo sucess update
				$theMsg= "<div class='alert alert-success'>". $stmt->rowCount().'Record updated'."</div>";
				redirectHome($theMsg,'back',4);
		


		
		}else{
			$theMsg="<div class='alert alert-danger'>YOU cannot browse this page direct</div>";
		redirectHome($theMsg);
		}
		echo "</div>";


 	///////////////////////Delete page//////////////////////////////////////////////////////////////////////

 } elseif ($do=='Delete') {

 	echo "<h1 class='text-center'>Delete category</h1>";
			echo "<div class='container'>";	
				if (isset($_GET['catid']) &&is_numeric($_GET['catid'])) {
				$catid= intval($_GET['catid']);
				$check=checkItem('ID','categories',$catid);

				//$stmt->execute(array($userid));
			//	$count =$stmt->rowCount();
				 // number of row in database
			if ($check > 0) {
				$stmt=$con->prepare("DELETE FROM categories WHERE ID=:ZID");//to delete by id
				$stmt->bindParam("ZID",$catid);//to connect user by id for delete
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
 //////////////////////////////////////////////////////////////////////////
  	include $tpl . 'footer.php';
 }else{

 	header('location:index.php');
 	exit();
 }


ob_end_flush();//release the output

?>


 