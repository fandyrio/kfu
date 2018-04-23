<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM pro_jadwal WHERE id = '".$id."'");
		pg_query($dbconn,"DELETE FROM pro_jadwal_dtl WHERE id_jadwal = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=jadwal";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=jadwal";
		</script>
		<?php
	}
?>