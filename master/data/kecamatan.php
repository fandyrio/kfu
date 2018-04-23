<?php
	include "../../config/conn.php";
	$kecamatan=pg_query($dbconn,"SELECT * FROM master_kecamatan WHERE city_id='$_POST[id_kabupaten]'");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($kecamatan)){
		echo"
		<option value='$r[id]'>$r[nama]</option>
		";
	}
	
	pg_close($dbconn);
?>