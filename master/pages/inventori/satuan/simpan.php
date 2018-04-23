<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $deskripsi = $_POST['deskripsi'];
	    $short_deskripsi = $_POST['short_deskripsi'];
	    $parent_satuan = $_POST['parent_satuan'];
	    $qty = $_POST['qty'];
	    $active = (isset($_POST['active'])?'Y':'N');
	    $base_satuan = (isset($_POST['base_satuan'])?'Y':'N');

		$res=pg_query($dbconn,"INSERT INTO inv_satuan (nama, deskripsi,short_deskripsi,parent_satuan,active,base_satuan)
		VALUES('".$nama."', '".$deskripsi."','".$short_deskripsi."','".$parent_satuan."','".$active."','".$base_satuan."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=satuan";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();
			?>
			<script>
			document.location.href = "media.php?inventori=satuan";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
		$deskripsi = $_POST['deskripsi'];
	    $short_deskripsi = $_POST['short_deskripsi'];
	    $parent_satuan = $_POST['parent_satuan'];
	    $qty = $_POST['qty'];
	    $active = (isset($_POST['active'])?'Y':'N');
	    $base_satuan = (isset($_POST['base_satuan'])?'Y':'N');
		
	$result=pg_query($dbconn,"UPDATE inv_satuan SET
	nama='".$nama."',
	deskripsi='".$deskripsi."',
	short_deskripsi='".$short_deskripsi."',
	parent_satuan='".$parent_satuan."',
	qty='".$qty."',
	active='".$active."',
	base_satuan='".$active."'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=satuan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=satuan";
			
		</script>
		<?php
	}

	

	break;
}

?>