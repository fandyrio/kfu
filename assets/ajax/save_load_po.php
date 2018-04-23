<?php 
$imp = "('".implode("','",array_values($_POST['id_rq']))."')";
echo $imp;

$result=pg_query($dbconn,"INSERT INTO po_ln_temp (id_users, id_inv,nama_brand, jumlah, id_satuan, harga_unit, total_harga, diskon_persen, diskon_amt, nett_total, id_q)
  											SELECT '".$_SESSION['id_users']."', id_inv, nama_brand, jumlah, id_satuan, harga_unit, 
  												gross_total,
  												
  												disc_perc, 
  												disc_amount,
  												net_price, 
  												id
  											FROM q_ln
  											WHERE id_hdr in $imp");

/*var_dump("INSERT INTO po_ln_temp (id_users, id_inv,nama_brand, jumlah, id_satuan, harga_unit, total_harga, komen, diskon_persen, diskon_amt, nett_total, id_q)
  											SELECT '".$_SESSION['id_users']."', id_inv, nama_brand, jumlah, id_satuan, harga_unit, 
  												gross_total,
  												komen 
  												disc_perc, 
  												disc_amount,
  												net_price, 
  												id
  											FROM q_ln
  											WHERE id_hdr in $imp");*/
  					
					 
?>