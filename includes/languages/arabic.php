<?php
	function lang($phrase){
		static $lang=array( // stati to no re get it every time
			'MESSAGE' =>  'اwelcome in arabic',
			'admin' => 'administrator'
		);
		return $lang[$phrase];

	}