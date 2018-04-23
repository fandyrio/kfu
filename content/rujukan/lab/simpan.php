<?php

	    $id_unit = $_POST['id_unit'];
	    $tipe_rujukan = $_POST['tipe_rujukan'];
	    $id_perusahaan = $_POST['id_perusahaan'];
	    $tgl = DateToEng($_POST['tgl']);
	   

	  //  $id_unit = $_POST['id_unit'];


		$res=pg_query($dbconn,"INSERT INTO pasien_rujukan (id_cabang_rujuk, id_cabang_dirujuk, tipe_rujukan, tanggal, status_diterima) 
			VALUES('$id_unit', '$id_perusahaan','$tipe_rujukan', '$tgl','1') RETURNING id");
		$row = pg_fetch_row($res); 
		 if (!isset($_POST['rujukan__']) || empty($_POST['rujukan__'])) {
				  
		} 
		else{
				$check =array_values($_POST['rujukan__']);  
				for( $y=0; $y<sizeof($check); $y++){
				  $pieces = explode("_", $check[$y]);
				 // if($pieces[3]){$pieces[2]=$pieces[2]."_".$pieces[3];}
				 	$sql =pg_query($dbconn, "INSERT INTO pasien_rujukan_detail (id_rujukan, id_pasien, id_detail, jenis_pemeriksaan, id_lab_order ) 
                         VALUES('$row[0]','$pieces[1]','$pieces[0]','$pieces[2]', '$pieces[3]') ");
				 	
				}
  

				

				
				  
			}

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "rujukan-laboratorium";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();
			?>
			<script>
			alert('gagal');
			document.location.href = "rujukan-laboratorium";
				
			</script>
			<?php
	    }
	

?>