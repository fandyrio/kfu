 <?php

            
            //$id = $_SESSION['id_users'];
  			$id = $_POST['id'];
  			$id_inv = $_POST['id_inv'];
            $nama_brand = $_POST['brand_nama'];
            $id_satuan = $_POST['id_satuan'];
            $jumlah = $_POST['jumlah'];


            $res=pg_query($dbconn,"UPDATE rq_ln_temp set id_inv='".$id_inv."', nama_brand='".$nama_brand."', id_satuan='".$id_satuan."', jumlah='".$jumlah."' WHERE id = $id");
            
        
          
		   /*var_dump("UPDATE rq_ln_temp set id_inv='".$id_inv."', nama_brand='".$nama_brand."', id_satuan='".$id_satuan."', jumlah='".$jumlah."' WHERE id = $id");*/
?>  