<?php 
    		$nama 	= $_POST['analysis'];
			$catatan 	= $_POST['deskripsi'];
            $kode 	= $_POST['code'];			
			$harga_modal	= $_POST['harga_modal'];						
			$id_users 	= $_SESSION['id_users'];
			$info_url	= $_POST['info_url'];			
			$id_specimen	= $_POST['id_specimen'];
			$satuan	= $_POST['satuan'];

			if (!isset($harga_modal) || empty($harga_modal)) {
				    $harga_modal = 0;
				   
			} 
			else{
				    $harga_modal = "'" .pg_escape_string($harga_modal) . "'";
				   
			}

            
        $res=pg_query($dbconn,"UPDATE lab_analysis SET 
				   nama='".$nama."',
				   kode='$kode',
				   harga_modal=$harga_modal,
				   info_url='$info_url',		   
				   catatan='$catatan',
				   satuan='$satuan',			  
				   id_lab_specimen='".$id_specimen."'
				   WHERE id= '".$_SESSION['id_lab']."'
				   " );

        var_dump("UPDATE lab_analysis SET 
				   nama='".$nama."',
				   kode='$kode',
				   harga_modal='$harga_modal',
				   info_url='$info_url',		   
				   catatan='$catatan',
				   satuan='$satuan',			  
				   id_lab_specimen='".$id_specimen."'
				   WHERE id= '".$_SESSION['id_lab']."'
				   ");



          		if (!isset($_POST['kategori']) || empty($_POST['kategori'])) {
				  
						} 
					else{
				  $kategori = 'ARRAY['. implode(',', $_POST['kategori']). ']';	          			
           		  $sql =pg_query($dbconn, "Delete from lab_analysis_kategori where id_lab_analysis='".$_SESSION['id_lab']."' ");
           		

		          $sql =pg_query($dbconn, "INSERT INTO lab_analysis_kategori(id_lab_analysis, id_lab_kategori ) 
		                         select '".$_SESSION['id_lab']."' id , x
							from unnest($kategori) x");

		       }
		      
		      if (!isset($_POST['location']) || empty($_POST['location'])) {
				  
						} 
					else{

				  $location = 'ARRAY['. implode(',', $_POST['location']). ']';		
		          $sql =pg_query($dbconn, "Delete from lab_analysis_location where id_lab_analysis='".$_SESSION['id_lab']."' ");
		         
		          $sql =pg_query($dbconn, "INSERT INTO lab_analysis_location(id_lab_analysis, id_lab_location ) 
		                         select '".$_SESSION['id_lab']."',*
							from unnest($location)");
		      }

		      if (!isset($_POST['additional_info']) || empty($_POST['additional_info'])) {
				  
						} 
					else{

				  $additional_info = 'ARRAY['. implode(',', $_POST['additional_info']). ']';		
		          $sql =pg_query($dbconn, "Delete from lab_analysis_additional_info where id_lab_analysis='".$_SESSION['id_lab']."' ");


			       $sql =pg_query($dbconn, "INSERT INTO lab_analysis_additional_info(id_lab_analysis, id_lab_additional_info ) 
		                         select '".$_SESSION['id_lab']."',*
							from unnest($additional_info)");

		       
		      }



		      
				  if($res){

				  	$data=pg_query($dbconn,"UPDATE lab_analisis_referal_range set id_users='0'
				  	 where id_lab_analisis='".$_SESSION['id_lab']."'
					");

					
  					echo "success";
				    }

        		
			  
?>