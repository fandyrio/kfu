<?php 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;


    /*var_dump("UPDATE stok_trf_ln_temp set total_cost='$total_nett', with_batch='1', id_ln ='".$_SESSION['id_trf_ln']."' WHERE id='".$_SESSION['id_trf_ln']."'
    ");*/
for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}
for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
  //var_dump($total_unit_nett);

  $query="INSERT INTO stok_trf_batch_temp (
    id_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, createddate,total_cost,
    dari_id_hdr, dari_id_ln, dari_id_batch)
                        VALUES ('".$_SESSION['id_trf_ln']."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[3]."', 
                            '".$pieces[4]."', 
                            '".$pieces[5]."',
                            '".$taken[$y]."',
                            '".$pieces[7]."', 
                            '".date('Y-m-d')."', 
                            '".$total_unit_nett."',                       
                            '".$pieces[0]."',
                            '".$pieces[1]."',
                            '".$pieces[2]."' ) ";
  $result=pg_query($dbconn,$query);
  var_dump($query);

 

}


if(sizeof($check)>0){
    $result=pg_query($dbconn,"UPDATE stok_trf_ln_temp set total_cost='$total_nett', with_batch='1' WHERE id='".$_SESSION['id_trf_ln']."'
    ");

}

  					
					 
?>