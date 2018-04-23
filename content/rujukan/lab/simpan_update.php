<?php
		
		$id = $_POST['pasien_rujukan'];
	    $id_unit = $_POST['id_unit'];
	    $tipe_rujukan = $_POST['tipe_rujukan'];
	    $id_perusahaan = $_POST['id_perusahaan'];
	    $tgl = DateToEng($_POST['tgl']);
	   

		$res=pg_query($dbconn,"UPDATE  pasien_rujukan SET tanggal='$tgl' where id='$id' "); 
		 if (!isset($_POST['rujukan__']) || empty($_POST['rujukan__'])) {
				  
		} 
		else{
			  $sql_delte =pg_query($dbconn, "Delete from pasien_rujukan_detail where id_rujukan='$id' ");	
				$check =array_values($_POST['rujukan__']);  
				for( $y=0; $y<sizeof($check); $y++){
				  $pieces = explode("_", $check[$y]);
				 	$sql =pg_query($dbconn, "INSERT INTO pasien_rujukan_detail (id_rujukan, id_pasien, id_detail, jenis_pemeriksaan, id_lab_order ) 
                         VALUES('$id','$pieces[1]','$pieces[0]','$pieces[2]', '$pieces[3]') ");
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