<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM pro_instruktur WHERE id = '".$id."'");

if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=instruktur";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=instruktur";
		</script>
		<?php
	}
?>