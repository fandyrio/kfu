<?php
switch($_GET['act'])
{
	case "baru":

		$id_unit= $_SESSION['id_units'];
		$id_perusahaan= $_POST['id_perusahaan'];
	    $nama = $_POST['nama'];	
	    $tgl = DateToEng($_POST['tgl']);	
	    $unit = 'ARRAY['. implode(',', $_POST['unit']). ']'; 
	    $harga = $_POST['harga'];	
	    
	    $harga_nett = $_POST['harga_nett'];	
	    $opsi_persen = $_POST['opsi_persen'];
	    if($opsi_persen=='Y'){
	    	$disc=$_POST['diskon'];	
	    	$disc_type='disc_persen';	
	    }
	    else{
	    	$disc=$_POST['diskon'];	
	    	$disc_type='disc_amount';
	    }
	    if($id_unit>1){
	    	$nasional = 'N';
	    }



		$res1 = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga,  harga, id_unit) 
			select $row[0], '$id_perusahaan','$harga_nett',*	from unnest($unit)  RETURNING id "); 	

		


		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "mcu";
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
	$id_unit= $_SESSION['id_units'];
	$id_paket = $_POST['id'];
	$nama = $_POST['nama'];
	$id_perusahaan = $_POST['perusahaan'];
	$tgl = DateToEng($_POST['tgl']);	
	$created_unit = $_POST['created_unit'];

	$allow_update = false;
	if($created_unit == $id_unit){
		$allow_update = true;
	}
	
	if($allow_update){
		$result=pg_query($dbconn,"UPDATE billing_paket SET 
		nama_paket='".$nama."' WHERE id = $id_paket");

		if (!isset($_POST['tindakan']) || empty($_POST['tindakan'])) {
				  
		} 
		else{
			$check =$_POST['tindakan'];

			$arrlength = sizeof($check);
			$total_nett =0;

			for( $i=0; $i<$arrlength; $i++){
				$harga_tindakan = pg_fetch_array(pg_query($dbconn,"SELECT total from tindakan WHERE id='$check[$i]' "));
			  $total_nett += $harga_tindakan['total'];
			}
				$tindakan = 'ARRAY['. implode(',', $_POST['tindakan']). ']';

	  $sql =pg_query($dbconn, "Delete from billing_paket_detail where id_billing_paket='$id_paket' AND jenis='T' ");			  

		$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail ) 
                         select $id_paket, 'T',*
					from unnest($tindakan)");

		
				  
			}
	   
	     if (!isset($_POST['lab_analysis']) || empty($_POST['lab_analysis'])) {
				  
		} 
		else{
			$check1 =$_POST['lab_analysis'];
			$arrlength1 = sizeof($check1);
			$total_nett1 =0;

			for( $j=0; $j<$arrlength1; $j++){
			$harga_lab= pg_fetch_array(pg_query($dbconn,"SELECT harga_modal from lab_analysis WHERE id='$check1[$j]' "));
			  $total_nett1 += $harga_lab['harga_modal'];
			}

		$sql =pg_query($dbconn, "Delete from billing_paket_detail where id_billing_paket='$id_paket' AND jenis='L' ");		
		$lab = 'ARRAY['. implode(',', $_POST['lab_analysis']). ']';  
		$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail ) 
                         select $id_paket ,'L',*
					from unnest($lab)");

	

			}

		if (!isset($_POST['lab_analysis_group']) || empty($_POST['lab_analysis_group'])) {
				  
		} 
		else{
			$check2 =$_POST['lab_analysis_group'];
			$arrlength2 = sizeof($check1);
			$total_nett2 =0;

			for( $k=0; $k<$arrlength2; $k++){
			$harga_lab= pg_fetch_array(pg_query($dbconn,"SELECT harga from lab_analysis_group WHERE id='$check2[$k]' "));
			  $total_nett2 += $harga_lab['harga'];
			}

		$sql =pg_query($dbconn, "Delete from billing_paket_detail where id_billing_paket='$id_paket' AND jenis='LG' ");		
		$lab_analysis_group = 'ARRAY['. implode(',', $_POST['lab_analysis_group']). ']';  
		$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail ) 
                         select $id_paket ,'LG',*
					from unnest($lab_analysis_group)");

	

			}
			$harga_total_paket = 0;
			$harga_total_paket =  $total_nett1 +  $total_nett+$total_nett2;
			pg_query($dbconn, "UPDATE billing_paket SET harga_net='$harga_total_paket' WHERE id='$id_paket' ");
	}	

	//end permision
	else{
		if (!isset($_POST['tindakan']) || empty($_POST['tindakan'])) {
				  
		} 
		else{
			$check =$_POST['tindakan'];

			$arrlength = sizeof($check);
			$total_nett =0;

			for( $i=0; $i<$arrlength; $i++){
				$harga_tindakan = pg_fetch_array(pg_query($dbconn,"SELECT total from tindakan WHERE id='$check[$i]' "));
			  $total_nett += $harga_tindakan['total'];
			}
				$tindakan = 'ARRAY['. implode(',', $_POST['tindakan']). ']';
	 

		
				  
			}
	   
	     if (!isset($_POST['lab_analysis']) || empty($_POST['lab_analysis'])) {
				  
		} 
		else{
			$check1 =$_POST['lab_analysis'];
			$arrlength1 = sizeof($check1);
			$total_nett1 =0;

			for( $j=0; $j<$arrlength1; $j++){
			$harga_lab= pg_fetch_array(pg_query($dbconn,"SELECT harga_modal from lab_analysis WHERE id='$check1[$j]' "));
			  $total_nett1 += $harga_lab['harga_modal'];
			}


			}

		if (!isset($_POST['lab_analysis_group']) || empty($_POST['lab_analysis_group'])) {
				  
		} 
		else{
			$check2 =$_POST['lab_analysis_group'];
			$arrlength2 = sizeof($check1);
			$total_nett2 =0;

			for( $k=0; $k<$arrlength2; $k++){
			$harga_lab= pg_fetch_array(pg_query($dbconn,"SELECT harga from lab_analysis_group WHERE id='$check2[$k]' "));
			  $total_nett2 += $harga_lab['harga'];
			}
		

	

			}
			$harga_total_paket = 0;
			$harga_total_paket =  $total_nett1 +  $total_nett+$total_nett2;
			
	}
	

	if (!isset($_POST['unit']) || empty($_POST['unit'])) {
				  
		} 
		else{
			 $unit = 'ARRAY['. implode(',', $_POST['unit']). ']'; 
			pg_query($dbconn, "Delete from billing_paket_kategori_harga_unit where id_billing_paket='$id_paket' ");
			$result = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga , harga, id_unit) 
			select $id_paket, '$id_perusahaan', $harga_total_paket, *	from unnest($unit)"); 	

			
		
		}

		

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "mcu";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "mcu";
			
		</script>
		<?php
	}

	

	break;
}

?>