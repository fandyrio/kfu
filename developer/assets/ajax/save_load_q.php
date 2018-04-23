<?php 
$imp = "('".implode("','",array_values($_POST['id_rq']))."')";
echo $imp;

$result=pg_query($dbconn,"INSERT INTO q_ln_temp (id_user, id_inv,nama_brand, jumlah, id_satuan)
  											SELECT '".$_SESSION['id_users']."', id_inv, nama_brand, jumlah, id_satuan
  											FROM rq_ln
  											WHERE id_rq in $imp");

var_dump("INSERT INTO q_ln_temp (id_user, id_inv,nama_brand, jumlah, id_satuan)
  											SELECT '".$_SESSION['id_users']."', id_inv, nama_brand, jumlah, id_satuan
  											FROM rq_ln
  											WHERE id_rq in $imp");
  					
					 
?>