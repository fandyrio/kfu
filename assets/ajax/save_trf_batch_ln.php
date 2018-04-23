<?php 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;
$total_taken=0;
$arrtaken = sizeof($taken);
for( $i=0; $i<$arrtaken; $i++){
  $total_taken += $taken[$i];
}


    /*var_dump("UPDATE stok_trf_ln_temp set total_cost='$total_nett', with_batch='1', id_ln ='".$_SESSION['id_trf_ln']."' WHERE id='".$_SESSION['id_trf_ln']."'
    ");*/
for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}
for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
  //var_dump($total_unit_nett);
if($_SESSION["id_trf_hdr"]!=NULL){

  $query="INSERT INTO stok_trf_batch (
    id_ln, id_hdr, id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, createddate,total_cost,
    dari_id_hdr, dari_id_ln, dari_id_batch, dari_doc_type)
                        VALUES ('".$_SESSION['id_trf_ln']."',
                        '".$_SESSION['id_trf_hdr']."',
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
                            '".$pieces[2]."',
                           '".$pieces[8]."' ) RETURNING id ";

}else{
  $query="INSERT INTO stok_trf_batch (
    id_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, createddate,total_cost,
    dari_id_hdr, dari_id_ln, dari_id_batch, dari_doc_type)
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
                            '".$pieces[2]."',
                             '".$pieces[8]."'
                             ) RETURNING id ";
}
  $result=pg_query($dbconn,$query);
  var_dump($query);
  var_dump($taken[$y]);

  $row = pg_fetch_row($result);

  
  $result=pg_query($dbconn,"INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_trf_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");



 

}


if(sizeof($check)>0){
    $result=pg_query($dbconn,"UPDATE stok_trf_ln set total_cost='$total_nett', with_batch='1',qty='$total_taken' WHERE id='".$_SESSION['id_trf_ln']."'
    ");

}

  	//$result=pg_query($dbconn,"UPDATE stok_trf_ln set qty='$total_taken' WHERE id='".$_SESSION['id_trf_ln']."'");				
					 
?>