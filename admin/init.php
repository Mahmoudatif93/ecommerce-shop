<?php

	include'connect.php';
	//Routes .

	$tpl='includes/templetes/';//templetes directory
	$lng='includes/languages/';//languages directory
	$func='includes/functions/';//functions directory
	$css='layout/css/'; //css directory
	$js='layout/js/';// js directory
	
	//include important links
include $func . 'functions.php';
include $lng . 'english.php';
include $tpl . 'header.php';

//incldse navbar on all pages except the one with $nonavbar variable
if (!isset($noNavbar)) {include $tpl . 'navbar.php';}
 ?>
