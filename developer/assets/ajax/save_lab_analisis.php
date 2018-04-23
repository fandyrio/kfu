<?php 
    		$nama 	= $_POST['analysis'];
			$catatan 	= $_POST['deskripsi'];
            $kode 	= $_POST['code'];			
			$harga_modal	= $_POST['harga_modal'];					
			$id_users 	= $_SESSION['id_users'];		
			$info_url	= $_POST['info_url'];
			$satuan	= $_POST['satuan'];
			$id_specimen	= $_POST['id_specimen'];

			 if (!isset($harga_modal) || empty($harga_modal)) {
				    $harga_modal = 0;
				   
			} 
			else{
				    $harga_modal = "'" .pg_escape_string($harga_modal) . "'";
				   
			}
		          
           $res=pg_query($dbconn,"INSERT INTO lab_analysis (
				   nama,
				   kode,
				   harga_modal,
				   info_url,		   
				   catatan,
				   satuan,
				   id_lab_specimen				  
				   ) 
					VALUES(
					'".$nama."',
					'$kode',
					$harga_modal,
					'$info_url',
					'$catatan',
					'$satuan',			
					'".$id_specimen."'
					) RETURNING id" );



          			$row = pg_fetch_row($res); 

          		if (!isset($_POST['kategori']) || empty($_POST['kategori'])) {
				  
						} 
					else{
						$kategori = 'ARRAY['. implode(',', $_POST['kategori']). ']';

		          $sql =pg_query($dbconn, "INSERT INTO lab_analysis_kategori(id_lab_analysis, id_lab_kategori ) 
		                         select $row[0] id,x
							from unnest($kategori) x");
		      	}

		      	if (!isset($_POST['location']) || empty($_POST['location'])) {
				  
						} 
					else{
						$location = 'ARRAY['. implode(',', $_POST['location']). ']';
						 $sql =pg_query($dbconn, "INSERT INTO lab_analysis_location(id_lab_analysis, id_lab_location ) 
		                         select $row[0],*
							from unnest($location)");

					}


				if (!isset($_POST['additional_info']) || empty($_POST['additional_info'])) {
				  
						} 
					else{
					$additional_info = 'ARRAY['. implode(',', $_POST['additional_info']). ']';

			        $sql =pg_query($dbconn, "INSERT INTO lab_analysis_additional_info(id_lab_analysis, id_lab_additional_info ) 
		                         select $row[0],*
							from unnest($additional_info)");
					}


				  if($res){

				  	$data=pg_query($dbconn,"UPDATE lab_analisis_referal_range set id_lab_analisis=$row[0], id_users='0'
				  	 where id_users='".$id_users."'
					");

					
  					echo "success";
				    }

        		
			  
?>