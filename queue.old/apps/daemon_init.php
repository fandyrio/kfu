<?php 
	session_start();

		include "mysql_connect.php";
		$result = pg_query($dbconn,'SELECT client From client_antrian'); // execution
		while ($rows = pg_fetch_array($result)) {
			$rst = pg_query($dbconn,"SELECT max(id) as id FROM data_antrian WHERE counter ='$rows['client']' and status=2 "); // execution
			$row = pg_fetch_array($rst);
			if ($row['id']==NULL)
			$id=0;
			else
			$id=$row['id'];
			$_SESSION["next_server"][$rows['client']] = $id;
			$_SESSION["counter_server"][$rows['client']] = $rows['client'];
		}
		include 'mysql_close.php';
	
?>