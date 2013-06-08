<?

	require_once("DatabaseTool.class.php");

	class ZipcodesManager
	{
		function add($zipcode,$city,$state,$latitude,$longitude,$timezone,$dst)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO zipcodes(zipcode,city,state,latitude,longitude,timezone,dst) VALUES(?,?,?,?,?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sssssss", $zipcode,$city,$state,$latitude,$longitude,$timezone,$dst);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('zipcodeid' => $row['zipcodeid'],'zipcode' => $row['zipcode'],'city' => $row['city'],'state' => $row['state'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'timezone' => $row['timezone'],'dst' => $row['dst']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($zipcodeid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM zipcodes WHERE zipcodeid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $zipcodeid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('zipcodeid' => $row['zipcodeid'],'zipcode' => $row['zipcode'],'city' => $row['city'],'state' => $row['state'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'timezone' => $row['timezone'],'dst' => $row['dst']);
	
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
				$query = 'SELECT * FROM zipcodes';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('zipcodeid' => $row['zipcodeid'],'zipcode' => $row['zipcode'],'city' => $row['city'],'state' => $row['state'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'timezone' => $row['timezone'],'dst' => $row['dst']);
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

		function del($zipcodeid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM zipcodes WHERE zipcodeid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $zipcodeid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($zipcode,$city,$state,$latitude,$longitude,$timezone,$dst)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE zipcodes SET zipcode = ?,city = ?,state = ?,latitude = ?,longitude = ?,timezone = ?,dst = ? WHERE zipcodeid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssssssss", $zipcode,$city,$state,$latitude,$longitude,$timezone,$dst, $zipcodeid);
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
