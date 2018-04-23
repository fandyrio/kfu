<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM inv_intruksi_obat WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=intruksi_obat";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=intruksi_obat";
		</script>
		<?php
	}
?>