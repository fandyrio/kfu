<?php
$id = $_GET['id']; 
$total_cost = $_GET['total_cost']; 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;

var_dump($_GET);

for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}

if(sizeof($check)>0){
  
    $total_edit = $total_nett + (int)$total_cost;

    var_dump($total_nett);
    var_dump($total_edit);
   $result=pg_query($dbconn,"UPDATE stok_trf_ln_temp set total_cost='$total_edit', with_batch='1' WHERE id=$id
    ");

    var_dump("UPDATE stok_trf_ln_temp set total_cost='$total_edit' WHERE id=$id");

}

for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[3];
  //var_dump($total_unit_nett);

  $result=pg_query($dbconn,"INSERT INTO stok_trf_batch_temp (id_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, createddate,total_cost   )
                        VALUES ('".$id."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".$pieces[4]."',
                            '".date('Y-m-d')."',
                            '".$total_unit_nett."') 
                        ");

var_dump("INSERT INTO stok_trf_batch_temp (id_ln,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, createddate,total_cost   )
                        VALUES ('".$id."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".$pieces[4]."',
                            '".date('Y-m-d')."',
                            '".$total_unit_nett."') 
                        ");

  
}

  					
					 
?>