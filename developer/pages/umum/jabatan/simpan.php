<?php
switch($_GET['act'])
{
	case "baru":
	    $jabatan = $_POST['jabatan'];

		$res=pg_query($dbconn,"INSERT INTO master_karyawan_jabatan (nama) VALUES('".$jabatan."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=jabatan";
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
	$jabatan = $_POST['jabatan'];
	$result=pg_query($dbconn,"UPDATE master_karyawan_jabatan SET nama='".$jabatan."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=jabatan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=jabatan";
			
		</script>
		<?php
	}

	

	break;
}

?>