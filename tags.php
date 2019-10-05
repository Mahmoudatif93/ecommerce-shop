 <?php	
 session_start();
 include'init.php';
?>
	
 <div class="container">
 	<div class="row">


	 	<?php
	 	if (isset($_GET['name'])){
	 		$tag= $_GET['name'];
	 		echo "<h1 class='tag-head'>" .$tag."</h1>";	
	 	
		 	$tagitems=getAllItems("*","items","where tags like '%$tag%'","AND Approve=1","Item_ID");
		 		foreach ($tagitems as $item) {
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
		 	}else{
		 		echo "<div class='alert alert-danger'>You must Enter Tag Name</div>";
		 	}
	 	 ?>
 	 </div>



 	 
 </div>

 <?php  	include $tpl . 'footer.php';?>



