<?php
	session_start();
	
	//echo $_SERVER["REMOTE_ADDR"] . "\n";
	
	if (!$_SESSION["login"])
	{
		$_SESSION["authorized"] = FALSE;
		
		// авторизация устройства
		$mydb = new mysqli( 'localhost', 'root', 'SG1kqvAN', 'innolaser');
		$result = $mydb->query("SELECT * FROM devices WHERE login = '" . $_GET["login"] . "'");
		
		// получаем результат запроса в виде массива
		$device = $result->fetch_array();
		
		// если результат запроса не пустой
		if (isset($device))
		{			
			// незащищенная проверка пароля
			if (strcmp($device["password"], $_GET["password"]) == 0)
			{
				echo "OK\n";
				$_SESSION["authorized"] = TRUE;
				$_SESSION["log_id"] = $device["log_id"];
				$_SESSION["device_id"] = $device["device_id"];
			}
			else
				echo "Access denied\n";
		}
		else
			echo "Access denied\n";
		
		$mydb->close();
	}
?>