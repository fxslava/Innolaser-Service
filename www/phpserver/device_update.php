<pre>
<?php
	session_start();
	
	$ip = $_SERVER["REMOTE_ADDR"];
	
	// Проверяем авторизацию устройства
	if ($_SESSION["authorized"])
	{
		$device_id = $_SESSION["device_id"];
		
		// добавление новой записи в таблицу
		// набор правильных ключей
		$keys = array(	"login"				, //0  STRING
						"password"			, //1  STRING
						"device_id"			, //2  INT
						"device_serial_num" , //3  INT 
						"board_version"		, //4  INT
						"firmware_version"	, //5  INT
						"cooling_level"		, //6  INT
						"working"			, //7  BOOL
						"cooling"			, //8  BOOL
						"peltier"			, //9  BOOL
						"temperature"		, //10 FLOAT
						"install_date"		, //11 DATE
						"last_activity");	  //12 TIMESTAMP
	
		// массив ключей и значений в запросе
		$q = array();
		$v = array();
	
		// заполняем массивы согласно http запросу
		for ($i = 0; $i < 2; ++$i) {
			if (isset($_GET[$keys[$i]])) {
				array_push($q, $keys[$i]);
				array_push($v, "'" . $_GET[$keys[$i]] . "'");
			}
		}
		
		for ($i = 2; $i < count($keys); ++$i) {
			if (isset($_GET[$keys[$i]])) {
				array_push($q, $keys[$i]);
				array_push($v, $_GET[$keys[$i]]);
			}
		}
		
		$p = "";
		// массив параметров ключ = значение в виде строки
		for ($i = 0; $i < count($q); ++$i)
			$p = $p . " " . $q[$i] . " = " . $v[$i] . ",";
		
		// соединяемся с базой данных
		$mydb = new mysqli( 'localhost', 'root', 'SG1kqvAN', 'innolaser');
		$mydb->query("UPDATE devices SET" . $p . " last_activity = NOW() WHERE device_id = " . $device_id); // обновляем состояние устройства в базе данных
		
		echo "UPDATE devices SET" . $p . " last_activity = NOW() WHERE device_id = " . $device_id . "\n";
		
		$logk = array(	"cooling_level"		, //0 INT
						"working"			, //1 BOOL
						"cooling"			, //2 BOOL
						"peltier"			, //3 BOOL
						"temperature"		, //4 FLOAT
						"frequency"			, //5 FLOAT
						"power");			  //6 INT
						
		// массив ключей и значений в запросе
		$q_ = array();
		$v_ = array();
	
		// заполняем массивы согласно http запросу
		for ($i = 0; $i < count($logk); ++$i) {
			if (isset($_GET[$logk[$i]])) {
				array_push($q_, $logk[$i]);
				array_push($v_, "'" . $_GET[$logk[$i]] . "'");
			}
		}
		
		// собираем строки
		$p = implode(", ", $q_);
		$s = implode(", ", $v_);
		
		$mydb->query("INSERT INTO log(" . $p . ", device_id, time, ip) VALUES(" . $s . ", " . $device_id . ", NOW(), INET_ATON('" . $ip . "'))");
		echo "INSERT INTO log(" . $p . ", device_id, time, ip) VALUES(" . $s . ", " . $device_id . ", NOW(), INET_ATON('" . $ip . "'))\n";
		
		$mydb->close();
	}
?>
</pre>