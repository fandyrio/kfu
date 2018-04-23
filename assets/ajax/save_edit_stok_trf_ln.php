 <?php

  			$id = $_POST['id'];
  			$jumlah = $_POST['jumlah'];
  			$catatan = $_POST['remark'];

            $res=pg_query($dbconn,"UPDATE stok_trf_ln set qty='".$jumlah."', catatan='".$catatan."' WHERE id = $id ");
			$res=pg_query($dbconn,"UPDATE inv_fiforeserve set qty_out='".$jumlah."' WHERE ke_id_ln = $id ");

            var_dump("UPDATE stok_trf_ln set qty='".$jumlah."', catatan='".$catatan."' WHERE id = $id ");
           
?>  