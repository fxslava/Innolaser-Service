<?php
	$mydb = new mysqli( 'localhost', 'root', 'SG1kqvAN', 'innolaser');
	$result = $mydb->query("SELECT time, temperature FROM log WHERE device_id LIKE " . $_GET["device_id"] . " ORDER BY event_id DESC LIMIT 7000");
	
	$data = array();
	while($row = $result->fetch_assoc())
	{
		$data[] = $row;
	}
	
	header('Content-Type: application/json; charset=utf-8', true);
	if (isset($data))
		echo json_encode($data);
	
	$mydb->close();
?>