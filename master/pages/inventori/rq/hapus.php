<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM rq_hdr WHERE id = '".$id."'");
$result=pg_query($dbconn,"DELETE FROM rq_ln WHERE id_rq = '".$id."'");


if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=rq";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=rq";
		</script>
		<?php
	}
?>