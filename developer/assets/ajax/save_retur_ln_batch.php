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
  $total_unit_nett= $taken[$y] * $pieces[3];
  
$price= $pieces[5];
 $result=pg_query($dbconn,"INSERT INTO retur_batch_temp (id_retur_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan )
                        VALUES ('".$_SESSION['id_retur_ln']."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".$pieces[4]."') 
                        ");
                        



}
if(sizeof($check)>0){
    $result=pg_query($dbconn,"UPDATE retur_ln_temp set nett_cost='$total_nett',
        cost_unit ='".$pieces[3]."' WHERE id='".$_SESSION['id_retur_ln']."'
    ");

}
  					
					 
?>