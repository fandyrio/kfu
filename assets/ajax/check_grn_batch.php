<?php
	
if ($_SESSION['id_grn_ln'] =='0'){
	echo "2";
}else {
	$sql = pg_query($dbconn, "Select id from grn_batch
		where id_ln='".$_SESSION['id_grn_ln']."'");
	$rows = pg_num_rows($sql);
	if($rows>=1){
		echo "1";
	}else echo "0";
}

	//var_dump("delete from q_ln_temp where id='$id'");
?>