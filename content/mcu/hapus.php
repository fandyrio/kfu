<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM billing_paket WHERE id = '".$id."'");
$res=pg_query($dbconn,"DELETE FROM billing_paket_detail WHERE id_billing_paket = '".$id."'");
$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit WHERE id_billing_paket = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "mcu";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "mcu";
		</script>
		<?php
	}
?>