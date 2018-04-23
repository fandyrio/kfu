<?php
$id = $_GET['id']; 
$total_cost = $_GET['total_cost']; 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;



for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}

for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[3];


  $jlh=pg_num_rows(pg_query($dbconn,"SELECT * from stok_trf_batch where id_ln='".$id."'
                              AND dari_id_hdr='".$pieces[0]."' AND dari_id_ln='".$pieces[1]."' AND dari_id_batch='".$pieces[2]."' "));

  if($jlh<0){

    $result=pg_query($dbconn,"INSERT INTO stok_trf_batch (
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
                            '".$pieces[2]."' ) RETURNING id
                        ");


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
    
  }

  if(sizeof($check)>0){
  
    $total_edit = $total_nett + (int)$total_cost;

    var_dump($total_nett);
    var_dump($total_edit);
    $result=pg_query($dbconn,"UPDATE stok_trf_ln set total_cost='$total_edit', with_batch='1',qty='$total_taken' WHERE id=$id");

    

}

  					
					 
?>