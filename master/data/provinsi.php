<?php
	include "../config/conn.php";
	$kabupaten=pg_query($dbconn,"SELECT * FROM master_provinsi");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($kabupaten)){
		echo"
		<option value='$r[id]'>$r[nama]</option>
		";
	}
	
	pg_close($dbconn);
?>