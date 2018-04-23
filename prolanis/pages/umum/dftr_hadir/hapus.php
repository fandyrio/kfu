<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM pro_dftr_hadir WHERE id = '".$id."'");
$res=pg_query($dbconn,"DELETE FROM pro_dftr_hadir_dtl WHERE id_dftr_hdr = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=dftr_hadir";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=dftr_hadir";
		</script>
		<?php
	}
?>