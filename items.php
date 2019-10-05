 <?php 
 	ob_start();
session_start();
 	$pageTitle='show items';
	include'init.php';	

		//check if itemID is_numeric and get integr value
	$itemid=isset($_GET['itemid']) &&is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;
		$stmt=$con->prepare("SELECT items.* , categories.Name ,users.username 
									from items
									INNER JOIN 
									categories
									ON
									categories.ID =items.cat_ID
									INNER JOIN 
									users
									ON
									users.userID=items.Member_ID
							 Where 	Item_ID =? AND Approve=1");
		$stmt->execute(array($itemid));
		$count=$stmt->rowCount();
		if ($count>0) {
			
		

		$item=$stmt->fetch();//get data from select in array	
		
	?>
	<h1 class="text-center"><?php echo $item['Item_Name']; ?> </h1>;	
	<div class="text-center">
		<div class="row">
			<div class="col-md-3">
				<img class="img-responsive img-thumbnail" src="images.jpg" alt="" />
			</div>
			<div class="col-md-6 item-info items">

				<h2><?php echo $item['Item_Name']; ?></h2>
				<p><?php echo $item['item_Description']; ?></p>
				<ul class="list-unstyled">

					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Added Date :</span><?php echo $item['ADD_DATE']; ?></li>
					<li>
						<i class="fa fa-money-bill fa-fw"></i>
						<span>price: </span><?php echo $item['item_price']; ?> $</li>
					<li>
						<i class="fa fa-building fa-fw"></i>
						<span>Made IN: </span><?php echo $item['Countary_made'];?></li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Category : </span><a href="categories.php?pageid=<?php echo $item['cat_ID']?> "><?php echo $item['Name']; ?></a></li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Added by : </span> <a href="#"><?php echo $item['username'];?></a>
					</li>

					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Tags  </span> : 
						<?php  
						$alltages=explode(",", $item['tags']);
						foreach ($alltages as $tages) {
							 $tages=str_replace(' ','',$tages);
							 $lowtages=strtolower($tages);
							if (!empty($tages)) {
								
							 echo "<a href='tags.php?name={$lowtages}'>".$tages.'</a>|';
									}
							}		

						?>
					</li>
				</ul>

			</div>
		</div>
</div>
<!--start add comment -->
<?php 	if (isset($_SESSION['user'])) { ?>
<hr class="custom-hr">
<div class="row">
	<div class="col-md-3 offset-md-3">
		<div class="add-comment">
			 <h3 class="text-center">Add Your Comment</h3>
			 <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
				<textarea name="comment" required></textarea>
				<input class="btn btn-primary add-comment" type="submit" value="Add Comment" name=""  />
			 </form>
			 <?php 
			 if ($_SERVER['REQUEST_METHOD']=='POST') {
			 	$comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
			 	$itemid=$item['Item_ID'];
				$userid=$_SESSION['uid'];

			 	if(!empty($comment)){
			 	
			 	$stmt=$con->prepare(" INSERT INTO comments(comment,Cstatus,added_Date,item_id,user_id) VALUES(:zcomment,0,NOW(), :zitem_id, :zuser_id) ");
			 	$stmt->execute(array(
			 							'zcomment'=> $comment,
			 							'zitem_id'=> $itemid,
			 							'zuser_id'=> $userid
			 						));
			 	if ($stmt) {
			 		echo '<div class="alert alert-info">Comment Added</div>'  ;
			 	}

			 	}
			 }
			 ?>
		</div>
	</div>
</div>
<!--end add comment -->
<?php } else{
	echo "<hr>";
	echo '<div class="alert alert-danger"><h6 class="text-center"><a href="login.php " target="_blank">'.'login or Register to add comment'.'</a></h6></div>' ;
}?>
<hr class="custom-hr">

<?php
////////to show comments
$stmt=$con->prepare("SELECT comments.*,
								users.username  AS Member
								FROM comments
								INNER JOIN
       							users ON users.userID=comments.user_id 
       							Where Item_ID=? AND Cstatus=1
       							ORDER BY user_id DESC

								  ");
		$stmt->execute(array($item['Item_ID']));
		//assign to variables
		$comments =$stmt->fetchall();
 ?>

		<?php 
			foreach ($comments as $comment ) {
			echo '<div class="comment-box">';
				echo '<div class="row">';
					echo '<div class="col-sm-2 text-center">';
						echo '<img class="img-responsive img-thumbnail img-circle" src="images.jpg" alt="" />';
						echo $comment['Member'] ;
					echo '</div> ';	
					echo '<div class="col-sm-10 "><p class="lead">'. $comment['comment'].'</p></div> ';
			
		   		echo '</div> ';
			echo '</div>';
			echo '<hr>';
				 	}	?>


	

	
<?php


}else{
	echo '<div class="alert alert-danger">There Is no such Id Or This Item Not Approved Yet</div>';
} {
	# code...
}
 include $tpl . 'footer.php';
	ob_end_flush();
 ?>









