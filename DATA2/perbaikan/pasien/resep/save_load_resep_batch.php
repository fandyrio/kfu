<?php 
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$id_pasien_resep =$_POST['id'];
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


for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}

var_dump(sizeof($check));

for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
 


  $query="INSERT INTO pasien_resep_batch (
    id_pasien_resep,id_users, no_batch, tgl_expired,tgl_manufac, qty, id_satuan, tgl_input,
    dari_id_hdr, dari_id_ln, dari_id_batch, dari_doc_type, harga)
                        VALUES ('".$id_pasien_resep."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[3]."', 
                            '".$pieces[4]."', 
                            '".$pieces[5]."',
                            '".$taken[$y]."',
                            '".$pieces[7]."', 
                            '".date('Y-m-d')."',                      
                            '".$pieces[0]."',
                            '".$pieces[1]."',
                            '".$pieces[2]."',
                             '".$pieces[8]."',
                             '".$pieces[6]."'
                             ) RETURNING id ";


  var_dump($query);

  $result=pg_query($dbconn,$query);
  $row = pg_fetch_row($result);

  
  $result=pg_query($dbconn,"INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$id_pasien_resep."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");



 

}


if(sizeof($check)>0){
    $result=pg_query($dbconn,"UPDATE pasien_resep set total_cost='$total_nett', qty='$total_taken' WHERE id='".$id_pasien_resep."'
    ");

}



  	//$result=pg_query($dbconn,"UPDATE stok_trf_ln set qty='$total_taken' WHERE id='".$_SESSION['id_trf_ln']."'");				
					 
?>