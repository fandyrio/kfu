<?php
$id = $_GET["id"];
$id_paket = $_GET["id_paket"];
$harga = $_GET["harga"];


$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$id_paket'"));
if($a['disc_amount']){
	$diskon = $a['disc_amount'];
}
else{
	$diskon = $a['disc_persen'];

}
$harga_kotor = $a['harga_gross'] - $harga;
$harga_bersih= $harga_kotor - ($harga_kotor * $diskon/100);
$update_harga=pg_query($dbconn,"UPDATE billing_paket SET harga_gross=$harga_kotor, harga_net=$harga_bersih WHERE id = '$id_paket' ");



$res=pg_query($dbconn,"DELETE FROM billing_paket_detail WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			//document.location.href = "media.php?content=mcu&modul=update&id="+<?php echo $id_paket; ?>;
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			//document.location.href = "media.php?content=mcu&modul=update&id="+<?php echo $id_paket; ?>;
		</script>
		<?php
	}
?>