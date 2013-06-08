<?

	require_once("DatabaseTool.class.php");

	class NodatazipsManager
	{
		function add($zipcode,$zipcodeid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO nodatazips(zipcode,zipcodeid) VALUES(?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ss", $zipcode,$zipcodeid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('nodatazipid' => $row['nodatazipid'],'zipcode' => $row['zipcode'],'zipcodeid' => $row['zipcodeid']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($nodatazipid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM nodatazips WHERE nodatazipid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $nodatazipid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('nodatazipid' => $row['nodatazipid'],'zipcode' => $row['zipcode'],'zipcodeid' => $row['zipcodeid']);
	
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
				$query = 'SELECT * FROM nodatazips';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('nodatazipid' => $row['nodatazipid'],'zipcode' => $row['zipcode'],'zipcodeid' => $row['zipcodeid']);
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

		function del($nodatazipid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM nodatazips WHERE nodatazipid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $nodatazipid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($zipcode,$zipcodeid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE nodatazips SET zipcode = ?,zipcodeid = ? WHERE nodatazipid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sss", $zipcode,$zipcodeid, $nodatazipid);
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
