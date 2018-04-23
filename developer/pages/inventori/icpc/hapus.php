<?php
$id = $_GET["id"];
$res=pg_query($dbconn,"DELETE FROM master_icpc WHERE id = '".$id."'");

//die("copo");
if($res)
	{
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=icpc";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal dihapus.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			//document.location.href = "media.php?inventori=icd10";
			//alert("lappet");
		</script>
		<?php
	}
?>