<?php 
$imp = "('".implode("','",array_values($_POST['id_rq']))."')";

$id_hdr = $_POST['id_h'];
//cho $imp;

$result=pg_query($dbconn,"INSERT INTO po_ln ( id_inv,nama_brand, jumlah, id_satuan, harga_unit, total_harga, diskon_persen, diskon_amt, nett_total, id_q, id_hdr)
  											SELECT  id_inv, nama_brand, jumlah, id_satuan, harga_unit, 
  												gross_total,
  												
  												disc_perc, 
  												disc_amount,
  												net_price, 
  												id, $id_hdr
  											FROM q_ln
  											WHERE id_hdr in $imp");


/*var_dump($_GET);*/

/*var_dump("INSERT INTO po_ln ( id_inv,nama_brand, jumlah, id_satuan, harga_unit, total_harga, diskon_persen, diskon_amt, nett_total, id_q, id_hdr)
                        SELECT  id_inv, nama_brand, jumlah, id_satuan, harga_unit, 
                          gross_total,
                          
                          disc_perc, 
                          disc_amount,
                          net_price, 
                          id, $id_hdr
                        FROM q_ln
                        WHERE id_hdr in $imp");*/
  					
					 
?>