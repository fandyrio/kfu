<?php 
	session_start();

		include "mysql_connect.php";
		$data = array();
		$date = date("Y-m-d");
		// Jumlah Loket
		$results = pg_query($dbconn,"SELECT  count(*) as jumlah_loket FROM client_antrian");	
		$loket = pg_fetch_array($results);
		$data['jumlah_loket'] = $loket["jumlah_loket"]; // set jumlah loket
		$client1 = pg_query($dbconn,"SELECT client From client_antrian"); // execution
		while ($cl =pg_fetch_assoc($client1)) {
			$rst = pg_query($dbconn,"SELECT max(id) as id FROM data_antrian WHERE counter ='".$cl["client"]."' and status=2 ");
			
			$row = pg_fetch_array($rst);
			if ($row['id']==NULL) {
				$id=0;
			} else {
				$id=$row['id'];
			}
			$data["init_counter"][$cl["client"]] = $id; // inisial setiap loket
		}

		//STATUS
		//======
		//2 done
		//1 wait
		//0 execution
		$result_wait = pg_query($dbconn,'SELECT count(*) as count FROM data_antrian WHERE status=1'); // wait 1
		$wait = pg_fetch_array($result_wait);
		$count = $wait['count'];
		if ($count){
			//echo $count;
		}else{
			$result = pg_query($dbconn,'SELECT id, counter FROM data_antrian WHERE status=0 ORDER BY waktu ASC LIMIT 1'); // execution
			$rows =pg_fetch_array($result);
			if($rows['id']!=NULL)
			{
				$data['next'] = $rows['id'];	
				$data['counter'] = $rows['counter'];
				// set wait
				$_SESSION["next_server"][$rows['counter']] = $rows['id'];
				$_SESSION["counter_server"][$rows['counter']] = $rows['counter'];
				pg_query($dbconn,'UPDATE data_antrian SET status= 1 WHERE id='. $rows['id'] .''); // update to wait 1
			}
		}
		echo json_encode($data);
		include 'mysql_close.php';

?>