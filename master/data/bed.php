<?php
	include "../config/conn.php";
	$bed=pg_query($dbconn,"SELECT * FROM master_unit_bed WHERE id_ruangan='$_POST[id_ruangan]' AND status='N' ORDER BY nama");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($bed)){
		echo"
		<option value='$r[id]'>$r[nama]</option>
		";
	}
	
	pg_close($dbconn);
?>