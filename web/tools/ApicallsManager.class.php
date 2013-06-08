<?

	require_once("DatabaseTool.class.php");

	class ApicallsManager
	{
		function add($apicalldt,$iphash)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO apicalls(apicalldt,iphash) VALUES(?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ss", $apicalldt,$iphash);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('apicallid' => $row['apicallid'],'apicalldt' => $row['apicalldt'],'iphash' => $row['iphash']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($apicallid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM apicalls WHERE apicallid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $apicallid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('apicallid' => $row['apicallid'],'apicalldt' => $row['apicalldt'],'iphash' => $row['iphash']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function getall()
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM apicalls';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('apicallid' => $row['apicallid'],'apicalldt' => $row['apicalldt'],'iphash' => $row['iphash']);
					$retArray[] = $object;
				}
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retArray;
		}

		function del($apicallid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM apicalls WHERE apicallid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $apicallid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($apicalldt,$iphash)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE apicalls SET apicalldt = ?,iphash = ? WHERE apicallid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sss", $apicalldt,$iphash, $apicallid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		///// Application Specific Functions

	}

?>
