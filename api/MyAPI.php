<?php

	function basicAPI($parameter)
	{
		header('Content-Type: application/json');
		require('../php/config.php');
	
		if(isset($_GET['src']))
		{
			$records = array();
			switch($_GET['src'])
			{
				case 'chart':
					$records = select($mysqli, "SELECT $parameter AS name, count(*) AS data FROM toscana GROUP BY $parameter"); 
					for($i = 0; $i < count($records); $i++) 
					{
						$records[$i]['data'] = array(intval($records[$i]['data']));
                    }
					break;
				case 'map':
					$raw_records = select($mysqli, "SELECT $parameter AS type, nome AS name, indirizzo AS address, lt, lg FROM toscana ORDER BY RAND() LIMIT 1000"); 
					for($i = 0; $i < count($raw_records); $i++)
					{
						$records[$raw_records[$i]['type']][] = $raw_records[$i];
					}
					break;
			}
			return json_encode($records);
		}
		else
			return json_encode(array('status' => 'error', 'details' => 'no src provided'));
		
	}
	
?>