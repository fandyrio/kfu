<?php
	include "../config/conn.php";
	$ruangan=pg_query($dbconn,"SELECT * FROM master_unit_ruangan WHERE id_lantai='$_POST[id_lantai]' ORDER BY nama");
	echo"<option value=''>Pilih</option>";
	while($r=pg_fetch_array($ruangan)){
		echo"
		<option value='$r[id]'>$r[nama]</option>
		";
	}
	
	pg_close($dbconn);
?>