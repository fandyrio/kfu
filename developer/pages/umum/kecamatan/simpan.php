<?php
switch($_GET['act'])
{
	case "baru":
	    $kecamatan = $_POST['kecamatan'];
	    $id_kab= $_POST['id_kab'];

		$res=pg_query($dbconn,"INSERT INTO master_kecamatan (nama, id_kabupaten) VALUES('".$kecamatan."','".$id_kab."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=kecamatan&modul=data&id_kab=<?php echo $id_kab ?>";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$id_kab= $_POST['id_kab'];
	$kecamatan = $_POST['kecamatan'];
	$result=pg_query($dbconn,"UPDATE master_kecamatan SET nama='".$kecamatan."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kecamatan&modul=data&id_kab=<?php echo $id_kab ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kecamatan&modul=data&id_kab=<?php echo $id_kab ?>";
			
		</script>
		<?php
	}

	

	break;
}

?>