<?php
	function lang($phrase){
		static $lang=array( // stati to no re get it every time
			
		//navbar links
		'HOME_Admin' 	=> 'Home',
		'categories'    => 'categories',
		'Items'         => 'Items',
		'Members'       => 'Members',
		'Comments'    => 'Comments',
		'Statistics'    => 'Statistics',
		'Logs'          => 'Logs'

		);
		return $lang[$phrase];

	}


?>