<?php
//var_dump($_POST); 
//die;
//echo $row['no_batch']."_".$row['expired_date']."_".$row['manufacdate']."_".$row['harga_unit']."_".$row['id_satuan']."_".$row['price']

$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;


for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}


$price="";
for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
  
$price= $pieces[5];
 $result=pg_query($dbconn,"INSERT INTO retur_batch (id_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan,  
                        dari_id_hdr, dari_id_ln, dari_id_batch )
                        VALUES ('".$_SESSION['id_retur_ln']."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[3]."', 
                            '".$pieces[4]."', 
                            '".$pieces[5]."',
                            '".$taken[$y]."',
                            '".$pieces[7]."',
                             '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."'
                             ) RETURNING id ");
                        


$row = pg_fetch_row($result);

$fiforeserve=pg_query($dbconn,"INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_retur_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");
}
if(sizeof($check)>0){
    $result1=pg_query($dbconn,"UPDATE retur_ln set nett_cost='$total_nett',
        cost_unit ='".$pieces[6]."' WHERE id='".$_SESSION['id_retur_ln']."'
    ");

var_dump("UPDATE retur_ln set nett_cost='$total_nett',
        cost_unit ='".$pieces[6]."' WHERE id='".$_SESSION['id_retur_ln']."'
    ");

}




  					
					 
?>