<?php
switch($_GET['act'])
{
	case "baru":

		$id_unit= $_SESSION['id_units'];
		$id_perusahaan= $_POST['id_perusahaan'];
		$id_paket = $_POST['id_paket'];
	   	
	    $tgl_awal = DateToEng($_POST['tgl_awal']);
	    $tgl_akhir = DateToEng($_POST['tgl_akhir']);	
	    $unit = 'ARRAY['. implode(',', $_POST['unit']). ']'; 
	   
	    
	   


		$res = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga, id_unit) 
			select $id_paket, '$id_perusahaan',*	from unnest($unit)  RETURNING id "); 	
			pg_query($dbconn, "UPDATE billing_paket SET tgl_awal='$tgl_awal', tgl_akhir='$tgl_akhir', status='7' WHERE id='$id_paket' ");
		


		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "mcu-jadwal";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			
			?>
			<script>
				
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id_unit= $_SESSION['id_units'];
	$id_paket = $_POST['id'];	
	$id_perusahaan = $_POST['perusahaan'];
	$tgl_awal = DateToEng($_POST['tgl_awal']);
	$tgl_akhir = DateToEng($_POST['tgl_akhir']);

	
	
		$result=pg_query($dbconn,"UPDATE billing_paket SET 	tgl_awal='$tgl_awal', tgl_akhir='$tgl_akhir'  WHERE id = $id_paket");

		
	   

	
	

	/*if (!isset($_POST['unit']) || empty($_POST['unit'])) {
				  
		} 
		else{
			 $unit = 'ARRAY['. implode(',', $_POST['unit']). ']'; 
			pg_query($dbconn, "Delete from billing_paket_kategori_harga_unit where id_billing_paket='$id_paket' ");
			$result = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga , id_unit) 
			select $id_paket, '$id_perusahaan', *	from unnest($unit)"); 	

			
		
		}*/

		

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "mcu-jadwal";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "mcu-jadwal";
			
		</script>
		<?php
	}

	

	break;
}

?>