<?php
switch($_GET['act'])
{
	case "baru":
	    $id_provinsi = $_POST['id_provinsi'];
	    $nama = $_POST['nama'];

		$res=pg_query($dbconn,"INSERT INTO master_kabupaten (nama, id_provinsi) VALUES('".$nama."', '".$id_provinsi."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=kabupaten&id_prov=<?php echo $id_provinsi; ?>";
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
	$nama = $_POST['nama'];
	$result=pg_query($dbconn,"UPDATE master_kabupaten SET nama='".$nama."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kabupaten&id_prov=<?php echo $id_provinsi; ?>";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kabupaten&id_prov=<?php echo $id_provinsi; ?>";
			
		</script>
		<?php
	}

	

	break;
}

?>