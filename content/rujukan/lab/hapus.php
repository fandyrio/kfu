<?php
include "../../../config/conn.php";
error_reporting(0);

$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM pasien_rujukan_detail WHERE id_rujukan = '".$id."'");
$res=pg_query($dbconn,"DELETE FROM pasien_rujukan WHERE id = '".$id."'");



		if($res){
         ?>
			<script>
			document.location.href = "rujukan-laboratorium";
			</script>

		<?php
	    } else{
	    	
			echo pg_last_error();
			?>
			<script>
			alert('gagal');
			document.location.href = "rujukan-laboratorium";
				
			</script>
			<?php
	    }
?>