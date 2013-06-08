<?

	require_once("DatabaseTool.class.php");

	class ScraperunsManager
	{
		function add($uvdatadatetime,$startdatetime,$enddatetime,$zipcount,$httperrors)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO scraperuns(uvdatadatetime,startdatetime,enddatetime,zipcount,httperrors) VALUES(?,?,?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sssss", $uvdatadatetime,$startdatetime,$enddatetime,$zipcount,$httperrors);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('scraperunid' => $row['scraperunid'],'uvdatadatetime' => $row['uvdatadatetime'],'startdatetime' => $row['startdatetime'],'enddatetime' => $row['enddatetime'],'zipcount' => $row['zipcount'],'httperrors' => $row['httperrors']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($scraperunid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM scraperuns WHERE scraperunid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $scraperunid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('scraperunid' => $row['scraperunid'],'uvdatadatetime' => $row['uvdatadatetime'],'startdatetime' => $row['startdatetime'],'enddatetime' => $row['enddatetime'],'zipcount' => $row['zipcount'],'httperrors' => $row['httperrors']);
	
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
				$query = 'SELECT * FROM scraperuns';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('scraperunid' => $row['scraperunid'],'uvdatadatetime' => $row['uvdatadatetime'],'startdatetime' => $row['startdatetime'],'enddatetime' => $row['enddatetime'],'zipcount' => $row['zipcount'],'httperrors' => $row['httperrors']);
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

		function del($scraperunid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM scraperuns WHERE scraperunid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $scraperunid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($uvdatadatetime,$startdatetime,$enddatetime,$zipcount,$httperrors)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE scraperuns SET uvdatadatetime = ?,startdatetime = ?,enddatetime = ?,zipcount = ?,httperrors = ? WHERE scraperunid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssssss", $uvdatadatetime,$startdatetime,$enddatetime,$zipcount,$httperrors, $scraperunid);
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
