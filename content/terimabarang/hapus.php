<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM grn_hdr WHERE id = '".$id."'");
$res1=pg_query($dbconn,"DELETE FROM grn_ln WHERE id_hdr = '".$id."'");
$res2=pg_query($dbconn,"DELETE FROM grn_batch WHERE id_hdr = '".$id."'");
$res2=pg_query($dbconn,"DELETE FROM inv_fifo WHERE id_hdr = '".$id."' AND doc_type='GRN' ");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "inventori-grn";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "inventori-grn";
		</script>
		<?php
	}
?>