<?php
$id = $_GET["id"];
$id_kec = $_GET["id_kec"];
$res=pg_query($dbconn,"DELETE FROM master_kelurahan WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kelurahan&modul=data&id_kec=<?php echo $id_kec ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kelurahan&modul=data&id_kec=<?php echo $id_kec ?>";
		</script>
		<?php
	}
?>