 <?php

  			$id = $_POST['id'];
  			$jumlah = $_POST['jumlah'];
  			$catatan = $_POST['remark'];

            $res=pg_query($dbconn,"UPDATE stok_trf_ln_temp set qty='".$jumlah."', catatan='".$catatan."' WHERE id = $id ");
           
?>  