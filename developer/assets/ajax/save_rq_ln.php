 <?php

            
            $id = $_SESSION['id_users'];
            $id_inv = $_POST['id_inv'];
            $nama_brand = $_POST['brand_nama'];
            $id_satuan = $_POST['id_satuan'];
            $jumlah = $_POST['jumlah'];


            $res=pg_query($dbconn,"INSERT INTO rq_ln_temp (id_users,nama_brand, id_satuan, jumlah, id_inv ) VALUES('".$id."',
            '".$nama_brand."'
              ,'".$id_satuan."'
              ,'".$jumlah."'
              ,'".$id_inv."')");  

		  var_dump("INSERT INTO rq_ln_temp (id_users,nama_brand, id_satuan, jumlah, id_inv ) VALUES('".$id."',
            '".$nama_brand."'
              ,'".$id_satuan."'
              ,'".$jumlah."'
              ,'".$id_inv."')");
?>  