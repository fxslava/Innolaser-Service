<!DOCTYPE html>
<html>
	<head>
		<style>
			table {
				font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
				font-size: 14px;
				background: white;
				max-width: 70%;
				width: 70%;
				border-collapse: collapse;
				border: 2px solid white;
				text-align: left;
			}
			th {
				font-weight: normal;
				color: #039;
				border-bottom: 2px solid #6678b1;
				padding: 10px 8px;
			}
			td {
				color: #669;
				padding: 9px 8px;
				transition: .3s linear;
			}
			tr:hover td{
				color: #6699ff;
			}
		</style>
	</head>
	<body>
		<?php
			$mydb = new mysqli( 'localhost', 'root', 'SG1kqvAN', 'innolaser');
			$result = $mydb->query("SELECT time, device_id, working, cooling, peltier, temperature, cooling_level, frequency, power, INET_NTOA(ip) FROM log");
			
			$data = array();
			while($row = $result->fetch_assoc())
			{
				$data[] = $row;
			}
			$colNames = array_keys(reset($data));
			$userColNames = array("time", "device_id", "working", "cooling", "peltier", "temperature", "cooling_level", "frequency", "power", "ip");
			
			$mydb->close();
		?>
		<table border="1">
			<tr>
				<?php
				//print the header
				foreach($userColNames as $colName)
				{
					echo "<th>$colName</th>";
				}
				?>
			</tr>
		
			<?php
				//print the rows
				foreach($data as $row)
				{
				echo "<tr>\n\t\t";
					foreach($colNames as $colName)
					{
						echo "\t<td>".$row[$colName]."</td>";
					}
				echo "</tr>";
				}
			?>
		</table>
	</body>
</html>