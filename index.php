 <?php 
 ob_start();
session_start();
 	$pageTitle='Homepage';
	include'init.php';?>


 <div class="container">
 	<div class="row">
	 	<?php
	 		$allItems=getAllFrom('items','Item_ID','where Approve=1');
	 		foreach ( $allItems as $item) {
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
	 	 ?>
 	 </div>



 	 
 </div>














	 <?php include $tpl . 'footer.php';
ob_end_flush();
 	?>


