 <?php 

//to solve proble of header already sent
 ob_start();//output buffering start make buffering store on solve problem of bom 

 session_start();
 if(isset($_SESSION['Username'])){
 	
 	$pageTitle='Dashboard';
 	include 'init.php';
 	
 	/*start dashboard page*/
 	$numusers=6; //number of latest users 
$latestusers=getLatests("*","users","userID",$numusers);
 	$numitems=6; //number of latest users 
$latestitems=getLatests("*","items","Item_ID",$numitems);
$numComments=2;//number of  comments 

?>
	<div class="container home-states text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="state st-member">
					<i class="fa fa-users"></i>
					<div class="info">
							Total Members
						<span><a href="members.php" target="_blank"><?php echo countItems('userID','users') ?></a></span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="state st-Pending">
					<i class="fa fa-clock"></i>
					<div class="info">
						Pending members
					<span><a href="members.php?do=manage&page=Pending" target="_blank"><?php echo checkItem('RegStatus','users',0); ?></a></span>
					</div>

				</div>
			</div>
			<div class="col-md-3">
				<div class="state st-Items">
					<i class="fa fa-tag"></i>
					<div class="info">
					total Items
					<span><a href="item.php" target="_blank"><?php echo countItems('Item_ID',' items') ?></a></span>
					</div>				
				</div>
			</div>
			<div class="col-md-3">
				<div class="state st-Comments ">
					<i class="fas fa-comment"></i>
					<div class="info">
						total Comments
						<span><a href="comment.php" target="_blank"><?php echo countItems('cID',' comments') ?></a></span>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="container latest">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-users"></i> Latest <?php echo countItems('userID','users') ?> Registerd Users
					<span class="toggle-info float-right">
						<i class="fa fa-plus fa-lg"></i>
					</span>
				</div>
				<div class='card card-body'>
					<ul class="list-unstyled latest-users" >
				
					<?php
		if (!empty($latestusers)) {
					 	
									 		 
				 	foreach ($latestusers as $user) {
				 		echo '<li>';
				 		echo  $user['username'] ;
				 		echo' <a href="members.php?do=edit&userid='.$user['userID'].'">';
						echo '<span class="btn btn-success float-right">';
				 		echo '<i class="fa fa-edit"></i>Edit';
				 		if ($user['RegStatus']==0) {
													echo"<a href='members.php?do=Activate&userid=".$user['userID']."' class='btn btn-info activate float-right'><i class='fa fa-check'></i> Activate </a>";}
						echo '</span>';
						echo '</a>';
						echo '</li>';
				 	
				 	}
 				}else{
 						echo 'there\'s No Members To Show';
 				}

 	?>
</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-tag"></i>Latest <?php echo countItems('Item_ID','items')?> items added
					<span class="toggle-info float-right">
						<i class="fa fa-plus fa-lg"></i>
					</span>
				</div>
				<div class='card card-body'>
				<ul class="list-unstyled latest-users" >
					<?php 
		

						
		if (!empty($latestitems)) {			
		 	foreach ($latestitems as $item) {
		 		echo '<li>';
		 		echo  $item['Item_Name'] ;
		 		echo' <a href="item.php?do=edit&itemid='.$item['Item_ID'].'">';
				echo '<span class="btn btn-success float-right">';
		 		echo '<i class="fa fa-edit"></i>Edit';
		 		if ($item['Approve']==0) {
				echo"<a href='item.php?do=Approve&itemid=".$item['Item_ID']."' class='btn btn-info activate float-right'><i class='fa fa-check'></i> Approve </a>";}
				echo '</span>';
				echo '</a>';
				echo '</li>';
		 	
		 	}
 }else{
 						echo 'there\'s No Items To Show';
 				}
 	?>
</ul>
				</div>
			</div>
		</div>
</div>
<!--////////////////////////start add comment in home page//////////////////////////////////////////// -->
<div class="row">
	<div class="col-md-6">
			<div class="panel panel-default">
					<div class="panel-heading">
							<i class="fa fa-comments"></i> 
							Latest <?php echo countItems('cID','comments')?> Comments
							<span class="toggle-info float-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
					</div>
					<div class='card card-body'>
						<?php 

									$stmt=$con->prepare("SELECT comments.*,
										users.username As Member
										FROM comments
										INNER JOIN
		       							users ON users.userID=comments.user_id  
		       							ORDER BY cID DESC 

										  ");
									$stmt->execute();
									//assign to variables
									$comments =$stmt->fetchall();
									if(!empty($comments)){
										foreach ($comments as $comment) {
											echo'<div class="comment-box">'; 
											echo '<span class="member-n">'. $comment['Member'].'</span>';
											echo '<p class="member-c">'. $comment['comment'].'</p>';
											echo '</div>';
										}
									}else{
 											 echo 'there\'s No comments To Show';
 											}
						?>
					</div>
					<br>
			</div>
		</div>
		
		</div>

<!--/////////////////////////end of adding comment in home page////////////////////////////////////// -->
	</div>
</div>

<?php

 	 /*end dashboard page*/



 	include $tpl . 'footer.php';
 }else{

 	echo 'you are not authorized to see this page';
 	header('location:index.php');
 	exit();
 }
 ob_end_flush();

 ?>

