<?php
$id = $_GET["id"];


  $query=pg_query($dbconn,"select retur_hdr.*, retur_ln.id_inv, retur_ln.id_satuan, retur_batch.qty, retur_ln.id as \"id_ln\", retur_ln.nett_cost, retur_batch.no_batch, retur_batch.dari_id_hdr, retur_batch.dari_id_ln, retur_batch.dari_id_batch,
        retur_batch.id as \"id_str_batch\" from retur_hdr 
        INNER JOIN retur_ln on retur_ln.id_hdr = retur_hdr.id
        INNER JOIN retur_batch on retur_batch.id_hdr = retur_hdr.id and retur_batch.id_ln = retur_ln.id
				  					Where retur_hdr.id='".$id."'");

 while ($data=pg_fetch_assoc($query)) {  
	pg_query($dbconn,"update inv_fifo set qty_out=qty_out -'".$data['qty']."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='GRN'  ");  

	 pg_query($dbconn,"Delete from inv_alokasi where dari_id_hdr='".$data['dari_id_hdr']."' and dari_id_ln='".$data['dari_id_ln']."' AND dari_id_batch='".$data['dari_id_batch']."' and ke_id_ln='".$data['id_ln']."' and ke_id_batch ='".$data['id_str_batch']."' ");    
}

$res=pg_query($dbconn,"DELETE FROM retur_hdr WHERE id = '".$id."'");
	$res=pg_query($dbconn,"DELETE FROM retur_ln WHERE id_hdr = '".$id."'");
	$res=pg_query($dbconn,"DELETE FROM retur_batch WHERE id_hdr = '".$id."'"); 


		
?>
		<script>
			document.location.href = "inventori-kembali";
			
		</script>
