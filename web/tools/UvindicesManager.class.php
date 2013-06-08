<?

	require_once("DatabaseTool.class.php");

	class UvindicesManager
	{
		function add($zipcode,$latitude,$longitude,$zipcodeid,$uvindexdate,$uvindextime,$uvindex)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO uvindices(zipcode,latitude,longitude,zipcodeid,uvindexdate,uvindextime,uvindex) VALUES(?,?,?,?,?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sssssss", $zipcode,$latitude,$longitude,$zipcodeid,$uvindexdate,$uvindextime,$uvindex);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('uvindexid' => $row['uvindexid'],'zipcode' => $row['zipcode'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'zipcodeid' => $row['zipcodeid'],'uvindexdate' => $row['uvindexdate'],'uvindextime' => $row['uvindextime'],'uvindex' => $row['uvindex']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($uvindexid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM uvindices WHERE uvindexid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $uvindexid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('uvindexid' => $row['uvindexid'],'zipcode' => $row['zipcode'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'zipcodeid' => $row['zipcodeid'],'uvindexdate' => $row['uvindexdate'],'uvindextime' => $row['uvindextime'],'uvindex' => $row['uvindex']);
	
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
				$query = 'SELECT * FROM uvindices';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('uvindexid' => $row['uvindexid'],'zipcode' => $row['zipcode'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'zipcodeid' => $row['zipcodeid'],'uvindexdate' => $row['uvindexdate'],'uvindextime' => $row['uvindextime'],'uvindex' => $row['uvindex']);
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

		function del($uvindexid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM uvindices WHERE uvindexid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $uvindexid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($zipcode,$latitude,$longitude,$zipcodeid,$uvindexdate,$uvindextime,$uvindex)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE uvindices SET zipcode = ?,latitude = ?,longitude = ?,zipcodeid = ?,uvindexdate = ?,uvindextime = ?,uvindex = ? WHERE uvindexid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssssssss", $zipcode,$latitude,$longitude,$zipcodeid,$uvindexdate,$uvindextime,$uvindex, $uvindexid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		///// Application Specific Functions

		function getzipcode($zipcode)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM uvindices WHERE zipcode = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s",$zipcode);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('uvindexid' => $row['uvindexid'],'zipcode' => $row['zipcode'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'zipcodeid' => $row['zipcodeid'],'uvindexdate' => $row['uvindexdate'],'uvindextime' => $row['uvindextime'],'uvindex' => $row['uvindex']);
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
		
		function getstatebydatetime($date,$time,$state)
		{
			try
			{
				$state = strtoupper($state);
			
				$db = new DatabaseTool(); 
				$query = 'select uvindices.* from uvindices join zipcodes on uvindices.zipcodeid = zipcodes.zipcodeid where uvindices.uvindexdate = ? and uvindices.uvindextime = ? and zipcodes.state = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sss",$date,$time,$state);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('lat' => $row['latitude'],'lng' => $row['longitude'],'count' => $row['uvindex']);
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

	}

?>
