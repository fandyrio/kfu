<?php
	include "../../config/conn.php";
	$desa=pg_query($dbconn,"SELECT * FROM master_kelurahan WHERE id_kecamatan='$_POST[id_kecamatan]'");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($desa)){
		echo"
		<option value='$r[id]'>$r[nama]</option>
		";
	}
	
	pg_close($dbconn);
?>