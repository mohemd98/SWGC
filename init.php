<?php

	$tpl 	= 'includes/templates/'; // Template Directory
	$lang 	= 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory

	// Include The Important Files
	
	include         'connect.php';
	include $func . 'functions.php';
	include $lang . 'english.php';
	include $tpl  . 'header.php';


	if(!isset($noNavbar12)){
        include $tpl."navbar.php";
     }

	