<?php
switch($_GET['act'])
{
	case "baru":
	    $kelurahan = $_POST['kelurahan'];
	    $id_kec= $_POST['id_kec'];
	    $kodepos = $_POST['kodepos'];

		$res=pg_query($dbconn,"INSERT INTO master_kelurahan (nama, id_kecamatan, kodepos) VALUES('".$kelurahan."','$id_kec', '$kodepos')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=kelurahan&modul=data&id_kec= <?php echo $id_kec ?>";
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
	$kelurahan = $_POST['kelurahan'];
	$id_kec= $_POST['id_kec'];
	$kodepos = $_POST['kodepos'];
	$result=pg_query($dbconn,"UPDATE master_kelurahan SET nama='".$kelurahan."', kodepos='$kodepos' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kelurahan&modul=data&id_kec= <?php echo $id_kec ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "";
			
		</script>
		<?php
	}

	

	break;
}

?>