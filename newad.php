 <?php 
session_start();
 	$pageTitle='Create New Item';
	include'init.php';
	if (isset($_SESSION['user'])) {


		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$formErrors=array();
			$name=filter_var($_POST['Name'],FILTER_SANITIZE_STRING);
			$desc=filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
			$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
			$Countarymade=filter_var($_POST['Countarymade'],FILTER_SANITIZE_STRING);
			$status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
			$Category=filter_var($_POST['Category'],FILTER_SANITIZE_NUMBER_INT);
			$tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
			
  	if (strlen($name)<2) {
  		$formError[]="Item name must be more 2";	
  	}
if (strlen($desc)<10) {
  		$formError[]="Item Description must be more 10";	
  	}if (strlen($Countarymade)<2) {
  		$formError[]="Item Countary made must be more 2";	
  	}
  	if (empty($price)) {
  		$formError[]="Item price  must be not empty ";	
  	}

if (empty($status)) {
  		$formError[]="Item status  must be not empty ";	
  	}
  	if (empty($Category)) {
  		$formError[]="Item Category  must be not empty ";	
  	}

	////if there is no errors /////
						if(empty($formError)){
					//Insert user info In Database 
							
												$stmt=$con->prepare("INSERT INTO 
													 ITEMS (Item_Name,item_Description,item_price,Countary_made,item_status,ADD_DATE,cat_ID,Member_ID,tags)
													VALUES(:zname,:zdesc,:zprice,:zmade,:zstatus,now(),:zcat_ID,:zMember_ID,:ztags)
													 ");

												$stmt->execute(array(
																'zname' => $name,
																'zdesc' => $desc,
																'zprice' => $price,
																'zmade' => $Countarymade,
																'zstatus' => $status,
																'zcat_ID' => $Category,
																'zMember_ID' => $_SESSION['uid'],
																'ztags' => $tags
												));
												//echo sucess message update
												echo"<div class='container'>";
												if ($stmt) {
													$SuccessMesg="Item Added Successfully";
												}
												
												echo "</div>";
										
			}






		}
	?>

<h1 class="text-center">Create New Item</h1>	
<div class="Create-ad block">
	<div class="container">
		<div class="card ">	
			<div class="card-header bg-primary">Create New Item</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-8">
						

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">
							
							<!--start name field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">Name</label>
								<div class="col-sm-10 col-md-9">
									<input
									pattern=".{4,}"
									title="this field Require At least 4 characters"
									 type="text"
									 name="Name" class="form-control live-name" 
									   placeholder="Name Of The Item" required/>

								</div>
							</div>
							<!--end name field -->

							<!--start Description field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">Description</label>
								<div class="col-sm-10 col-md-9">
									<input type="text"

									 name="Description" class="form-control live-Description"  
									  placeholder="Description Of The Item " required />

								</div>
							</div>
							<!--end Description field -->
					

							<!--start price field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">price</label>
								<div class="col-sm-10 col-md-9">
									<input type="text"
									 name="price" class="form-control live-price"  
									  placeholder="price Of The Item " required />

								</div>
							</div>
							<!--end price field -->

				<!--start Countary made field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">Made</label>
								<div class="col-sm-10 col-md-9">
									<input type="text"
									 name="Countarymade" class="form-control"  
									   placeholder="CountaryMadeOfTheItem " required/>

								</div>
							</div>
							<!--end Countary made field -->

							<!--start  status field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">item status</label>
								<div class="col-sm-10 col-md-9">
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
							<!--start  Category field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2  control-label">Category</label>
								<div class="col-sm-10 col-md-9">
									<select  name="Category" >
										<option value="0">...</option>
											<?php
												$stmt=$con->prepare("SELECT * FROM categories");
												$stmt->execute();
												$cats=$stmt->fetchAll();
												foreach ($cats as $cat) {
													echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
													
												}
											 ?>	

								</select>

								</div>
							</div>
							<!--end Category field -->

							<!--start tags  field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2  control-label">Tags</label>
						<div class="col-sm-10 col-md-9">
							<input type="text"
							 name="tags" class="form-control"  
							   placeholder="Seperate Tags with comma(,)" value=""  />

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

					<!--////////////END OF FORM/////////// -->

					</div>
					<div class="col-md-4">
						<div class="thumbnail item-box live-preview">
		 					<span class="price-tag live-price">$0</span>
		 					<img class="img-responsive" src="images.jpg" alt="" />
		 					<div class="caption">
		 						<h3 class="live-title">Title</h3>
		 						<p class="live-desc">description</p>
		 					</div>
	 					</div>
					</div>
				</div>
				<!--start form errors -->
				<?php 
					if (!empty($formError)) {
						foreach ($formError as $Error) {
							echo '<div class="alert alert-danger">'.$Error.'</div>';
						}
					}elseif (isset($SuccessMesg)) {
						echo '<div class="alert alert-info">'.$SuccessMesg.'</div>';
					}
				?>
				<!--end form errors -->

			</div>
		</div>
	</div>
</div>

<?php
}else{
	header('location: login.php');
	exit();
}

 include $tpl . 'footer.php';?>

