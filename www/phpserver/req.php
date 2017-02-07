<?php
	session_start();
	// добавление новой записи в таблицу
	// набор правильных ключей
	$keys = array(	"device_id"			,
					"device_serial_num" , 
					"board_version"		,
					"firmware_version"	,
					"install_date"		,
					"working"			,
					"cooling"			,
					"peltier"			,
					"temperature"		,
					"cooling_level"		,
					"log_id"			,
					"login"				,
					"password");
	
	// массив ключей и значений в запросе
	$q = array();
	$v = array();
	
	// заполняем массивы согласно http запросу
	for ($i = 0; $i < count($keys); ++$i) {
		if (isset($_GET[$keys[$i]])) {
			array_push($q, $keys[$i]);
			array_push($v, "'" . $_GET[$keys[$i]] . "'");
		}
	}
	
	// собираем строки
	$q_ = implode(", ", $q);
	$v_ = implode(", ", $v);
	
	// формируем запрос к базе данных MySQL
	echo "INSERT INTO devices($q_) VALUES($v_);";
					
	$mydb = new mysqli( 'localhost', 'root', 'SG1kqvAN', 'innolaser');
	
	if ($mydb->connect_errno)
	{
		echo "Не удалось подключиться к MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
	}
	else
	{
		if (!$mydb->query("INSERT INTO devices(" . $q_ . ") VALUES(" . $v_ . ")"))
			echo "Не удалось подготовить запрос: (" . $mydb->errno . ") " . $mydb->error;
	}
?>
