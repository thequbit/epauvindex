<?php

	require_once("../tools/UvindicesManager.class.php");
	
	$errorcode = 0;
	$errormsg = "None.";
	$results = "[]";
	
	if( !isset($_GET['zipcode']))
	{
		$errorcode = 1;
		$errormsg = "No Zipcode Passed In.  Use /get.php?zipcode=90210";
	}
	else
	{
		$zipcode = $_GET['zipcode'];
		
		if( !is_numeric($zipcode) )
		{
			$errorcode = 2;
			$errormsg = "Invalid Zipcode.  Use /get.php?zipcode=90210";
		}
		else
		{
			$mgr = new UvindicesManager();
			$results = $mgr->getzipcode($zipcode);
		}
	}
	
	echo '{ "errorcode": ' . $errorcode . '", "errormsg": ' . $errormsg . '", "results": ' . json_encode($results) . '}';

	exit;

?>