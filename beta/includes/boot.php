<?php

error_reporting(1);
	ini_set('default_charset', 'charset=iso-8859-1');
	//ob_start();
	session_start();
	require("includes/config.inc.php");
	require("class/Database.class.php");
	require("class/pagination.class.php");
	require("includes/functions.php");
	// include "fbmain.php";
	//require("twitter/twitteroauth.php");
	//require 'config/twconfig.php';
	require("class/SimpleLargeXMLParser.class.php");
	require("includes/pagination.php");
	ini_set("display_errors","0");
	
	
	
	 
?>
