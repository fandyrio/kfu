<?php
switch($_GET['act'])
{
	case "baru":
	    $body = $_POST['body'];
	    $lokasi = $_POST['lokasi'];
	   
	  /*  if (!isset($unit_cost) || empty($unit_cost)) {
				    $unit_cost = 0;
				   
			} 
			else{
				    $unit_cost = "'" .pg_escape_string($unit_cost) . "'";
				   
			}

	    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    	$id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';*/

    	


		$res=pg_query($dbconn,"INSERT INTO master_lokasi_body(id_body,nama_lokasi) 
			VALUES('$body', '$lokasi')");
		

	/*	$row = pg_fetch_row($res); */

		/*$sql =pg_query($dbconn, "INSERT INTO tindakan_kategori_harga (id_tindakan, harga, id_kategori_harga ) 
                         select $row[0] ,*
					from unnest($harga, $id_layanan)");*/

		

		/*if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?tindakan=tindakan";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
				document.location.href = "media.php?tindakan=tindakan";
				
			</script>
			<?php
	    }*/
	break;

	case "edit":

	$idLokasi = $_POST['idLokasi'];
	$idBody = $_POST['idBody'];
	$nama = $_POST['nama'];
	
	$result=pg_query($dbconn,"UPDATE master_lokasi_body SET 
	nama_lokasi='$nama', id_body='$idBody'
	WHERE id = '$idLokasi'");

	break;


	case "delete":
	$id=$_POST['id'];

	$result=pg_query($dbconn, "DELETE from master_lokasi_body where id='$id'");

	break;
}

?>