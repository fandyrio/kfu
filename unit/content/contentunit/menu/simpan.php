<?php
switch($_GET['act'])
{
	case "baru":
	    $modul = $_POST['modul'];

		$res=pg_query($dbconn,"INSERT INTO auth_menu (nama) VALUES('".$modul."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?content=menu";
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
	$modul = $_POST['modul'];
	$result=pg_query($dbconn,"UPDATE auth_menu SET nama='".$modul."' WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=menu";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=menu";
			
		</script>
		<?php
	}

	

	break;
}

?>