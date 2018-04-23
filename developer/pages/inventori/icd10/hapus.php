<?php
$id = $_GET["id"];
$res=pg_query($dbinventory,"DELETE FROM master_icd10 WHERE id = '".$id."'");
//die("copo");
if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=icd10";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			//document.location.href = "media.php?inventori=icd10";
			alert("lappet");
		</script>
		<?php
	}
?>