<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $kategori = $_POST['id_kategori'];

		$res=pg_query($dbconn,"INSERT INTO inv_obat (nama, id_kategori) VALUES('".$nama."', '".$kategori."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=obat";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();
			?>
			<script>
			document.location.href = "media.php?inventori=obat";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$kategori = $_POST['kategori'];
	$result=pg_query($dbconn,"UPDATE inv_obat SET
	nama='".$nama."',
	id_kategori='".$kategori."',
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
	}

	

	break;
}

?>