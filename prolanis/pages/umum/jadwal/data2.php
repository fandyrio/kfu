<?php
include "../../config/conn.php";

$sql=pg_query($dbconn, "Select * from pro_jadwal");
$data=array();

while ($row=pg_fetch_array($sql)){
		$data[]=array(
				'title'=>$row[nama],
				'start'=>"2018-02-18 16:00:00",
				'end'=>"2018-02-18 17:00:00",
				'time'=>$row[jam]
				);
}
echo json_encode($data);
?>