<?php
switch($_GET['act'])
{
	case "baru":
	    $kebangsaan = $_POST['kebangsaan'];
		$res=pg_query($dbconn,"INSERT INTO master_kebangsaan (nama) VALUES('".$kebangsaan."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=kebangsaan";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_error();
			?>
			<script>
			
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$kebangsaan = $_POST['kebangsaan'];
	$result=pg_query($dbconn,"UPDATE master_kebangsaan SET nama='".$kebangsaan."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=kebangsaan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=kebangsaan";
			
		</script>
		<?php
	}

	

	break;
}

?>