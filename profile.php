 <?php 
session_start();
 	$pageTitle='profile';
	include'init.php';
	if (isset($_SESSION['user'])) {
		$getuser=$con->prepare("SELECT * FROM users WHERE username=?");
		$getuser->execute(array($_SESSION['user']));
		$info=$getuser->fetch();
		
	?>

<h1 class="text-center">My Profile</h1>	
<div class="information block">
	<div class="container">
		<div class="card ">	
			<div class="card-header bg-primary">My Information</div>
			<div class="card-body">
				<ul class="list_unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
					<span>Login Name</span>: <?php echo $info['username'];?>
					</li>
					<li>
						<i class="fa fa-envelope fa-fw"></i>
						<span>Email</span>: <?php echo $info['Email'];?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>FullName</span>: <?php echo $info['FullName'];?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Register Date</span>: <?php echo $info['Date'];?>
					</li>
					<li>
						<i class="fa fa-tag fa-fw"></i>
						<span>favourite Category </span>: 
					</li>
				</ul>
				<a class="btn btn-primary">Edit Information</a>
			</div>
		</div>
	</div>
</div>

<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="card ">	
			<div class="card-header bg-primary">My Items</div>
			<div class="card-body">
						
				<div class="row">
			 	<?php
			 	$getit=getItems('Member_ID',$info['userID']);
			 		if (!empty($getit)){
			 				echo '<div class="row">';
						 	foreach (getItems('Member_ID',$info['userID'],1) as $item) {
						 			echo '<div class="main-item">';
						 				echo '<div class="thumbnail item-box">';
					 					if ($item['Approve']==0) {echo '<span class="approve-status">Waitting Approval</span>';}
						 						
						 					echo '<span class="price-tag">'.$item['item_price']. '$</span>';
						 					echo '<img class="img-responsive" src="images.jpg" alt="" />';
						 					echo '<div class="card">';
						 						echo ' <h3 class="item"><a href="items.php?itemid='.$item['Item_ID'].' "> '.$item['Item_Name']. '</a></h3> ';
						 						echo '<p>'. $item['item_Description'].'</p>';
						 						echo '<div class="date">'.$item['ADD_DATE'].'</div>';

						 					echo '</div>';
						 				echo '</div>';
						 			echo '</div>';

						 	}

						 	echo'</div>';
						 	} else{
		 						echo "there is no advertisement To Show, Create <a href='newad.php'> New Ad </a> ";}
				 ?> 
		 	 </div>
		 	
		 


			</div>
		</div>
	</div>
</div>

<div class="my-comment block">
	<div class="container">
		<div class="card ">	
			<div class="card-header bg-primary">latest comments</div>
			<div class="card-body"> 
				<?php
					$stmt=$con->prepare("SELECT comment FROM comments WHERE user_id= ? ");
					$stmt->execute(array($info['userID']));
					//assign to variables
					$comments =$stmt->fetchall();
					
					if (!empty($comments)) {
						foreach ( $comments as $comment) {
							echo '<p>'.$comment['comment'].'</p>';
						}
					}else{
						echo "no comments yet";
					}



				 ?>
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

