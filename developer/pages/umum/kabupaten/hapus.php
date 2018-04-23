<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM master_kabupaten WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kabupaten&id_prov=<?php echo $id_provinsi; ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kabupaten&id_prov=<?php echo $id_provinsi; ?>";
		</script>
		<?php
	}
?>