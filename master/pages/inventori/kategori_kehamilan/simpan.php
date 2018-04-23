<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];

		$res=pg_query($dbconn,"INSERT INTO inv_kategori_kehamilan (nama) VALUES('".$nama."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=kategori_kehamilan";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			document.location.href = "media.php?inventori=kategori_kehamilan";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$result=pg_query($dbconn,"UPDATE inv_kategori_kehamilan SET nama='".$nama."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=kategori_kehamilan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=kategori_kehamilan";
			
		</script>
		<?php
	}

	

	break;
}

?>