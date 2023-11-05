<?php
	$tpl 	= 'includes/'; // Template Directory
	$css 	= 'Layout/css/'; // Css Directory
	$js 	= 'Layout/js/'; // Js Directory

	// Include The Important Files
	
	include         'connect.php';
	include $tpl  . 'header.php';
	if(!isset($noNavbar12)){
        include $tpl."navbar.php";
     }

	