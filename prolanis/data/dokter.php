<?php
	include "../config/conn.php";
	$dokter=pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id_departemen='$_POST[id_poli]' AND id_jabatan='1'");
	while($r=pg_fetch_array($dokter)){
		echo"<option value='$r[id]'>$r[nama]</option>";
	}
	
	pg_close($dbconn);
?>