<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $satuan = $_POST['satuan'];

		$res=pg_query($dbconn,"INSERT INTO inv_atk (nama_barang,satuan, id_users) VALUES('".$nama."','".$satuan."', '".$_SESSION['user_login'])."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=atk";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			
			?>
			<script>
			document.location.href = "media.php?inventori=atk";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$satuan = $_POST['satuan'];
	$result=pg_query($dbconn,"UPDATE inv_atk SET 
	nama_barang='".$nama."',
	satuan='".$satuan."' 
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=atk";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=atk";
			
		</script>
		<?php
	}

	

	break;
}

?>