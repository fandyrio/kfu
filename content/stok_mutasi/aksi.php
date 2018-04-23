<?php
if($_GET['proses']){
	$res=pg_query($dbconn,"Update stok_trf_hdr set proses_by='".$_SESSION['id_users']."' WHERE id='".$_GET["id"]."' ");

	//var_dump("Update stok_trf_hdr set proses_by='".$_SESSION['id_users']."' WHERE id='".$_GET["id"]."' ");

	$query=pg_query($dbconn,"select stok_trf_hdr.*, stok_trf_ln.id_inv, stok_trf_ln.id_satuan, stok_trf_batch.qty, stok_trf_ln.id as \"id_ln\",  stok_trf_batch.no_batch, stok_trf_batch.dari_id_hdr, stok_trf_batch.dari_id_ln, stok_trf_batch.dari_id_batch, stok_trf_batch.dari_doc_type,stok_trf_batch.total_cost,
        stok_trf_batch.id as \"id_trf_batch\" from stok_trf_hdr 
        INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
        INNER JOIN stok_trf_batch on stok_trf_batch.id_hdr = stok_trf_hdr.id and stok_trf_batch.id_ln = stok_trf_ln.id
		Where stok_trf_hdr.id='".$_GET["id"]."'");

			  
        while ($data=pg_fetch_assoc($query)) {               

          		$fifo= pg_query($dbconn, "select * from inv_fifo where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='".$data['dari_doc_type']."' " );
                if($jlh=pg_num_rows($fifo)>0){

                    $fifetch = pg_fetch_array($fifo);
                    $qtynew= $fifetch["qty_out"] + $data['qty'];
                    $costnew = $fifetch["cost_out"]+ $data['total_cost'] ;

                   	pg_query($dbconn,"update inv_fifo set qty_out='".$qtynew."', cost_out='".$costnew."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='".$data['dari_doc_type']."' "); 

                   	

                }  
                pg_query($dbconn,"INSERT INTO inv_fifo (id_hdr,doc_no,id_ln, id_batch, qty_out, cost_out, doc_type, id_inv) 
                            VALUES(
                            '".$data['id']."',
                            '".$data['doc_no']."',
                            '".$data['id_ln']."',
                            '".$data['id_trf_batch']."',
                            0,
                            0,     
                            'TRF',
                            '".$data['id_inv']."') "); 

                 
         
                pg_query($dbconn,"Delete from inv_fiforeserve where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' and ke_id_ln='".$data['id_ln']."' and ke_id_batch ='".$data['id_trf_batch']."' and id_users='".$_SESSION['id_users']."' "); 

              


       	if($fifo){
		
			
			?>
			<script>
				document.location.href = "inventori-stok-mutasi";
				
			</script>
			<?php
			
		}         
  			
      }

}
else{
	$id = $_GET["id"];
	


	$query=pg_query($dbconn,"select stok_trf_hdr.*, stok_trf_ln.id_inv, stok_trf_ln.id_satuan, stok_trf_batch.qty, stok_trf_ln.id as \"id_ln\", stok_trf_ln.total_cost, stok_trf_batch.no_batch, stok_trf_batch.dari_id_hdr, stok_trf_batch.dari_id_ln, stok_trf_batch.dari_id_batch,
        stok_trf_batch.id as \"id_trf_batch\" from stok_trf_hdr 
        INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
        INNER JOIN stok_trf_batch on stok_trf_batch.id_hdr = stok_trf_hdr.id and stok_trf_batch.id_ln = stok_trf_ln.id
		Where stok_trf_hdr.id='".$_GET["id"]."'");

			  
        while ($data=pg_fetch_assoc($query)) { 

        	 pg_query($dbconn,"Delete from inv_alokasi where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' and ke_id_ln='".$data['id_ln']."' and ke_id_batch ='".$data['id_trf_batch']."'  ");


        	 pg_query($dbconn,"Delete from inv_fiforeserve where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' and ke_id_ln='".$data['id_ln']."' and ke_id_batch ='".$data['id_trf_batch']."' and id_users='".$_SESSION['id_users']."' ");



        }

    $res=pg_query($dbconn,"DELETE FROM stok_trf_hdr WHERE id = '".$id."'");
	$res=pg_query($dbconn,"DELETE FROM stok_trf_ln WHERE id_hdr = '".$id."'");
	$res=pg_query($dbconn,"DELETE FROM stok_trf_batch WHERE id_hdr = '".$id."'");    

	if($res){
		
		$_SESSION["msg"] = 'Data berhasil dihapus.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "inventori-stok-mutasi";
			
		</script>
		<?php
		
	}
	
}

?>