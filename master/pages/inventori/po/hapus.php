<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM po_hdr WHERE id = '".$id."'");
$result=pg_query($dbconn,"DELETE FROM po_ln WHERE id_hdr = '".$id."'");


if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=po";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=po";
		</script>
		<?php
	}
?>