<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];
	    $modify = $_POST['modify'];

		$res=pg_query($dbconn,"INSERT INTO inv_nama_generik (nama,modify_date) VALUES('".$nama."','".$modify."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=generik";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			document.location.href = "media.php?inventori=generik";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$modify = $_POST['modify'];
	$result=pg_query($dbconn,"UPDATE inv_nama_generik SET 
	nama='".$nama."',
	modify_date='".$modify."' 
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=generik";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=generik";
			
		</script>
		<?php
	}

	

	break;
}

?>