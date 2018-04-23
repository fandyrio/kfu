<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM inv_diagnosis_folder WHERE id = '".$id."' ");

var_dump($res);

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=diagnosis";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori";
		</script>
		<?php
	}
?>