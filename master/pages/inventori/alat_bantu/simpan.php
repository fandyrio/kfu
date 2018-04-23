<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $satuan = $_POST['satuan'];
	    $jumlah = $_POST['jumlah'];

		$res=pg_query($dbconn,"INSERT INTO inv_alat_bantu (nama, satuan, jumlah, id_users) 
			VALUES('$nama','$satuan', '$jumlah',
			 '".$_SESSION['id_users']."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=alat_bantu";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			
			?>
			<script>
			//document.location.href = "media.php?inventori=alat_bantu";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$satuan = $_POST['satuan'];
	 $jumlah = $_POST['jumlah'];
	$result=pg_query($dbconn,"UPDATE inv_alat_bantu SET 
	nama='".$nama."',
	satuan='".$satuan."',
	jumlah='".$jumlah."' 
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=alat_bantu";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=alat_bantu";
			
		</script>
		<?php
	}

	

	break;
}

?>