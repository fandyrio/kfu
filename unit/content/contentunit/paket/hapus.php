<?php
$id = $_GET["id"];
$unit = $_SESSION['id_unit'];
$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit WHERE id_billing_paket = '$id' and id_unit='$unit'");


if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=paket";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=paket";
		</script>
		<?php
	}
?>