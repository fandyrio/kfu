<?php
$id = $_GET["id"];
$id_kab = $_GET['id_kab'];
$res=pg_query($dbconn,"DELETE FROM master_kecamatan WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kecamatan&modul=data&id_kab=<?php echo $id_kab ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kecamatan&modul=data&id_kab=<?php echo $id_kab ?>";
			</script>
		<?php
	}
?>