<?php
switch($_GET['act'])
{
	case "baru":
	
	$id_unit= $_SESSION['id_unit'];
	    if (!isset($_POST['id_karyawan']) || empty($_POST['id_karyawan'])) {
				  
		} 
		else{
				$id_karyawan = 'ARRAY['. implode(',', $_POST['id_karyawan']). ']'; 

				$sql =pg_query($dbconn, "INSERT INTO master_karyawan_unit (id_unit, id_karyawan ) 
                         select $id_unit, * from unnest($id_karyawan)");				  
			}
	   
	

		if($sql){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "karyawan";
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

	case "delete":
	$id= $_GET['id'];
	$id_unit= $_SESSION['id_unit'];
		
	$result=pg_query($dbconn,"DELETE FROM master_karyawan_unit WHERE id = $id and id_unit='$id_unit'");
	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "karyawan";
			</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "karyawan";
			</script>
		<?php
	}

	

	break;
}

?>