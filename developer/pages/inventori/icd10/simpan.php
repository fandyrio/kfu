<?php

switch($_GET['act'])
{
	case "baru":
	    $code = $_POST['code'];
	    $nama = $_POST['nama'];
	    $sex = $_POST['sex'];
	    $id_diagnosis = $_POST['id_diagnosis'];
	    $deskripsi = $_POST['deskripsi'];
	    $force_link = $_POST['force_link'];
	
		$res=pg_query($dbconn,"INSERT INTO master_icd10 (code,nama, sex, id_diagnosis_folder, force_link, deskripsi)
		VALUES('".$code."','".$nama."','".$sex."','".$id_diagnosis."','".$force_link."','".$deskripsi."')");
		
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=icd10";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error($res);
			?>
			<script>
			 document.location.href = "media.php?inventori=icd10";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
		$code = $_POST['code'];
	    $nama = $_POST['nama'];
	    $sex = $_POST['sex'];
	    $id_diagnosis = $_POST['id_diagnosis'];
	    $deskripsi = $_POST['deskripsi'];
	    $force_link = $_POST['force_link'];
		
	$result=pg_query($dbconn,"UPDATE master_icd10 SET 
	code='".$code."',
	nama='".$nama."',
	id_diagnosis_folder='".$id_diagnosis."',
	deskripsi='".$deskripsi."',
	force_link='".$force_link."'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=icd10";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=icd10";
			
		</script>
		<?php
	}

	

	break;
}

?>