<?php
$id = $_GET["id"];
$unit = $_SESSION['id_unit'];
$delete =pg_query($dbconn, "DELETE FROM commision_group_harga_unit WHERE id_commision_group='$id' and id_unit='$unit'");
if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=commision_group";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=commision_group";
		</script>
		<?php
	}
?>