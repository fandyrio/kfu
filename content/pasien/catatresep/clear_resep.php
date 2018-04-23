<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$_SESSION["id_pasien"]= $_POST['id_pasien'];
$_SESSION["id_kunjungan"]= $_POST['id_kunjungan'];

$id=(int)$_POST['id'];

 

 $query=pg_query($dbconn,"select * FROM pasien_resep_order_detail
		Where id_pasien_resep='".$id."'");
 while ($data=pg_fetch_assoc($query)) {
 	/* pg_query($dbconn,"Delete from inv_alokasi where dari_id_hdr='".$data['dari_id_hdr']."'  and dari_id_ln='".$data['dari_id_ln']."' and dari_id_batch ='".$data['dari_id_batch']."' and doc_type='RSP' ");

  	pg_query($dbconn,"update inv_fifo set qty_out= qty_out - '".$data['qty']."', cost_out= cost_out - '".$data['harga']."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."'  AND doc_type='".$data['dari_doc_type']."' ");*/


  }

pg_query($dbconn,"DELETE FROM  pasien_resep_order WHERE id='".$id."' ");
pg_query($dbconn,"DELETE FROM  pasien_resep_order_detail WHERE id_pasien_resep_order='".$id."' ");


?>