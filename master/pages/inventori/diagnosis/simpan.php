<?php
switch($_GET['act'])
{
	case "baru":
		$code = $_POST['code'];
	    $nama = $_POST['nama'];
	    $parent_diafolder = $_POST['parent_diafolder'];

		$res=pg_query($dbconn,"INSERT INTO inv_diagnosis_folder (code,nama,parent_diafolder) VALUES('".$code."','".$nama."', '".$parent_diafolder."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=diagnosis";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();
			?>
			<script>
			
			</script>
			<?php

	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$code = $_POST['code'];
	$nama = $_POST['nama'];
	$parent_diafolder = $_POST['parent_diafolder'];
	$result=pg_query($dbconn,"UPDATE inv_diagnosis_folder SET
	code='".$code."',
	nama='".$nama."',
	parent_diafolder='".$parent_diafolder."'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=diagnosis";
			
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