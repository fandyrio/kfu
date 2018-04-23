<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $alamat = $_POST['alamat'];
	    $telepon = $_POST['telepon'];

		$res=pg_query($dbconn,"INSERT INTO inv_info_supplier (nama, telepon, alamat) 
		VALUES(
		'".$nama."',
		'$telepon',
		'$alamat'
		)");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=info_supplier";
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
	 $telepon = $_POST['telepon'];
	 $alamat = $_POST['alamat'];
	 
	$result=pg_query($dbconn,"UPDATE inv_info_supplier 
	SET nama='".$nama."',
	telepon='$telepon',
	alamat='$alamat'
	WHERE id = $id");
	var_dump("UPDATE inv_info_supplier 
	SET nama='".$nama."',
	telepon='$telepon',
	alamat='$alamat'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=info_supplier";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
		alert('gagal');
		//document.location.href = "media.php?inventori=info_supplier";
			
		</script>
		<?php
	}

	

	break;
}

?>