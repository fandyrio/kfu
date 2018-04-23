
<?php
	include "../config/conn.php";
	$kabupaten=pg_query($dbconn,"SELECT * FROM master_lokasi_body WHERE id_body='$_POST[id]'");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($kabupaten)){
		echo"
		<option value='$r[id]'>$r[nama_lokasi]</option>
		";
	}
	
	pg_close($dbconn);
?>
