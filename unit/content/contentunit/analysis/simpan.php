<?php
switch($_GET['act'])
{
	case "baru":
	
		$id_unit= $_SESSION['id_unit'];
		$id_kategori_harga = $_POST['id_kategori_harga'];
		$harga = 'ARRAY['. implode(',', $_POST['harga']).']';
    	$id_lab = 'ARRAY['. implode(',', $_POST['id_lab']).']';

		$row = pg_fetch_row($res); 
		$sql =pg_query($dbconn, "INSERT INTO lab_analysis_kategori_harga_unit (id_kategori_harga, id_unit, harga,id_lab_analysis  )  select $id_kategori_harga , $id_unit, *
					from unnest($harga, $id_lab)");


		if($sql){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "lab";
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
		
	$result=pg_query($dbconn,"DELETE FROM lab_analysis_kategori_harga_unit WHERE id_perusahaan = $id and id_unit='$id_unit'");
	
	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "lab";
			</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			//document.location.href = "lab";
			</script>
		<?php
	}

	

	break;
}

?>