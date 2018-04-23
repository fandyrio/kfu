<?php
$id = $_GET["id"];
$unit = $_SESSION['id_unit'];
$res=pg_query($dbconn,"DELETE FROM tindakan_kategori_harga_unit WHERE id_tindakan = '$id' and id_unit='$unit' ");


if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=tindakan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=tindakan";
		</script>
		<?php
	}
?>