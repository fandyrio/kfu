<?php 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;

for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}

if(sizeof($check)>0){

}

for( $y=0; $y<sizeof($check); $y++){

  var_dump(sizeof($check));
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
  var_dump($total_unit_nett);
            //$harga_unit = str_replace('.', '', $harga_unit);
           $string_sql = "INSERT INTO stok_adj_batch (id_ln,id_users, no_batch, expired_date,manufacdate, qty, id_satuan, nama_brand, total_harga, dari_id_hdr, dari_id_ln, dari_id_batch, dari_doc_type   )
                        VALUES ('".$_SESSION['id_adj_ln']."',
                        '".$_SESSION['id_users']."', 
                            '".$pieces[3]."', 
                            '".$pieces[4]."', 
                            '".$pieces[5]."',
                            '"."-".$taken[$y]."',
                            '".$pieces[7]."',
                            '".$_SESSION['nama_brand']."',
                            '".$total_unit_nett."',
                            '".$pieces[0]."',
                            '".$pieces[1]."',
                            '".$pieces[2]."',
                            '".$pieces[8]."'
                            ) RETURNING id ";

          $res=pg_query($dbconn,$string_sql);

          
          var_dump($string_sql);


          $row = pg_fetch_row($res);

          $result=pg_query($dbconn,"INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_adj_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");

          var_dump("INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_adj_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");

           $result=pg_query($dbconn,"UPDATE stok_adj_ln set total_harga='$total_nett' WHERE id='".$_SESSION['id_adj_ln']."'
      	    ");
      	
      			
}		

               
            unset($_SESSION['nama_brand']);
            unset($_SESSION['id_satuan']);
            unset($_SESSION['id_adj_ln']);
            
              echo "success";
          
              echo "failed".$string_sql;
          	
?>