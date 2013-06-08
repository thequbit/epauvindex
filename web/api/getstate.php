<?php

	require_once("../tools/UvindicesManager.class.php");
	
	$errorcode = 0;
	$errormsg = "None.";
	$results = "[]";
	
	if( !isset($_GET['date']) || !isset($_GET['hour']) || !isset($_GET['state']) )
	{
		$errorcode = 3;
		$errormsg = "No Date and/or Hour and/or State Passed In.  Use /getstate.php?date=1970-1-1&hour=13&state=NY";
	}
	else
	{
		$date = $_GET['date'];
		$hour = $_GET['hour'];
		$state = $_GET['state'];
	
		if( strlen($state) != 2 )
		{
			$errorcode = 5;
			$errormsg = "Invalid State.  Use Two Letter Code.  Use /getstate.php?date=1970-1-1&state=NY";
		}
		else
		{
			$mgr = new UvindicesManager();
			$time = $hour . ":00:00";
			$results = $mgr->getstatebydatetime($date,$time,$state);
			
			echo json_encode($results);
		}
	}

	exit;

?>