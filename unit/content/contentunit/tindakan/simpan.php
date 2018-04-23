<?php
switch($_GET['act'])
{
	case "baru": 
	    $unit = $_SESSION['id_unit'];
	    $id_tindakan = $_POST['id_tindakan'];
	    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    	$id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

		$row = pg_fetch_row($res); 
		$sql =pg_query($dbconn, "INSERT INTO tindakan_kategori_harga_unit (id_tindakan, id_unit, harga, id_kategori_harga )  select $id_tindakan , $unit, *
					from unnest($harga, $id_layanan)");
	

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			
			 document.location.href = "media.php?content=tindakan";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
				//window.alert("data ada yang kosong");
				window.history.go(-1);
			</script>
			<?php
	    }
	break;

	case "edit":
	$id_tindakan = $_POST['id_tindakan'];
	$unit = $_SESSION['id_unit'];
	$harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

	$delete =pg_query($dbconn, "DELETE FROM tindakan_kategori_harga_unit WHERE id_tindakan='$id_tindakan' and id_unit='$unit'");

	if($delete){
		$sql =pg_query($dbconn, "INSERT INTO tindakan_kategori_harga_unit (id_tindakan,id_unit, harga, id_kategori_harga ) 
                         SELECT $id_tindakan,$unit, *
					from unnest($harga, $id_layanan)");


	}



	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=tindakan";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=tindakan";
			
		</script>
		<?php
	}

	

	break;
}

?>