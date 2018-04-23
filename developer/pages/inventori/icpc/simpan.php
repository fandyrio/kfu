<?php

switch($_GET['act'])
{
	case "baru":
	    $code = $_POST['code'];
	    $nama = $_POST['nama'];
	
		$res=pg_query($dbconn,"INSERT INTO master_icpc (kode,nama)
		VALUES('".$code."','".$nama."')");
		
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=icpc";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error($res);
			?>
			<script>
			 document.location.href = "media.php?inventori=icpc";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$code = $_POST['code'];
	$nama = $_POST['nama'];
		
	$result=pg_query($dbconn,"UPDATE master_icpc SET 
	kode='".$code."',
	nama='".$nama."'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=icpc";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=icpc";
			
		</script>
		<?php
	}

	

	break;
}

?>