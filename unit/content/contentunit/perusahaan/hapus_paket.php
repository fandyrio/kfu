<?php
$id = $_GET["id"];
$unit = $_SESSION['id_unit'];
$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit WHERE id = '$id' ");
$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit_detail WHERE id_paket_k_unit = '$id' ");


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