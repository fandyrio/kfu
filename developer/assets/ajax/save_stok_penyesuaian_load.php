<?php
/*ln */
$id_inv      = $_POST['id_inv'];
$nama_brand  = $_SESSION['stt_nama_brand'];
$id_satuan   = $_SESSION['stt_id_satuan'] ;
$stno        = '1';
$beda_qty    = $_SESSION['stt_beda_qty'];
$balance_qty =  $_SESSION['stt_"qty_baru'];
$baru_qty    = $_SESSION['stt_balance_qty'];
die;

$result=pg_query($dbconn,"INSERT INTO stok_take_qty_temp (
                                id_users, 
                                id_inv,
                                stno,
                                nama_brand, 
                                beda_qty, 
                                balance_qty,
                                baru_qty,
                                id_satuan
                        )
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$stno."', 
                            '".$nama_brand."', 
                            '".$beda_qty."',
                            '".$balance_qty."',
                             '".$baru_qty."',
                            '".$id_satuan."') RETURNING id");

 $row = pg_fetch_row($result);

 $_SESSION['id_stt_ln'] = $row[0];


/**////////////////// 
$check =array_values($_POST['check']);
$taken =array_values($_POST['taken2']);
$total =array_values($_POST['total']);

$arrlength = sizeof($total);
$total_nett =0;

for( $i=0; $i<$arrlength; $i++){
  $total_nett += $total[$i];
}

if(sizeof($check)>0){
	   /* $result=pg_query($dbconn,"UPDATE stok_trf_ln_temp set total_harga='$total_nett', arga with_batch='1' WHERE id='".$_SESSION['id_trf_ln']."'
	    ");*/

}
/*$row['id_hdr']."_".
$row['id_ln']."_".$row['id_batch']."_".$row['no_batch']."_".$row['expired_date']."_".$row['manufacdate']."_".$harga_unit."_".$row['id_satuan']*/
for( $y=0; $y<sizeof($check); $y++){
  $pieces = explode("_", $check[$y]);
  $total_unit_nett= $taken[$y] * $pieces[6];
  var_dump($total_unit_nett);
            //$harga_unit = str_replace('.', '', $harga_unit);
           $string_sql = "INSERT INTO stok_take_batch_temp (id_stok_take_ln,
           id_users, 
           no_batch, 
           tgl_expired,
           tgl_manufac, 
           qty, 
           id_satuan,
          nama_brand, 
           total_harga, 
           dari_id_hdr,            
           dari_id_ln, 
           dari_id_batch   )
                        VALUES ('".$_SESSION['id_stt_ln']."',
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
                            '".$pieces[2]."') RETURNING id ";

          $res=pg_query($dbconn,$string_sql);

         // var_dump(string_sql);

          
          var_dump($string_sql);


          $row = pg_fetch_row($res);

          $result=pg_query($dbconn,"INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_stt_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");

        /*  var_dump("INSERT INTO inv_fiforeserve (ke_id_ln, ke_id_batch, dari_id_hdr, dari_id_ln, dari_id_batch, qty_out,createddate, id_users   )
                        VALUES ('".$_SESSION['id_adj_ln']."',
                              $row[0],
                            '".$pieces[0]."', 
                            '".$pieces[1]."', 
                            '".$pieces[2]."',
                            '".$taken[$y]."',
                            '".date('Y-m-d')."',
                            '".$_SESSION['id_users']."') ");
*/
           $result=pg_query($dbconn,"UPDATE stok_take_qty_temp set total_harga='$total_nett' WHERE id='".$_SESSION['id_stt_ln']."'
      	    ");
      	
      			if($res){
      				 
      			//unset($_SESSION['nama_brand']);
      			//unset($_SESSION['id_satuan']);
      			//unset($_SESSION['id_adj_ln']);
      			
      				echo "success";
      			}
      			else{
      				echo "failed".$string_sql;
      			}
}			
?>