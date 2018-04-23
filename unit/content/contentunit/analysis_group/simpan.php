<?php
switch($_GET['act'])
{
	case "baru":
	
	$id_unit= $_SESSION['id_unit'];
	    if (!isset($_POST['id_lab']) || empty($_POST['id_lab'])) {
				  
		} 
		else{
				$id_lab = 'ARRAY['. implode(',', $_POST['id_lab']). ']'; 

				$sql =pg_query($dbconn, "INSERT INTO lab_analysis_group_unit (id_unit, id_lab_analysis_group ) 
                         select $id_unit, * from unnest($id_lab)");

				
				  
			}			
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?content=analysis_group";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			document.location.href = "media.php?content=analysis_group";
				
			</script>
			<?php
	    }
	break;

	case "delete":
	$id= $_GET['id'];
	$id_unit= $_GET['id_unit'];
		
	$result=pg_query($dbconn,"DELETE FROM lab_analysis_group_unit WHERE id = $id");
	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=analysis_group";
			</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=analysis_group";
			</script>
		<?php
	}

	

	break;
}

?>