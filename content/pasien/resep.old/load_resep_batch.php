<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
?>
               <table id="trf_batch_load" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th></th>
                 <th >No Batch</th>
                   <th >Tgl. Doc</th>              
                   <th >Tgl.expire</th>
                   <th >Manufacture</th>
                   <th >Qty</th>      
                   <th >Harga Unit</th>
                   <th>Price</th>
                  <th >Reserved Quantity</th>
                  <th>Tersedia</th>
                  <th>Ambil</th>       
                </tr>
                </thead>
                <tbody>
            <?php
                 $nama_brand = $_GET['brand'];
                
                 $dept = $_GET['dept'];
                 $brand= str_replace('_', ' ', $nama_brand);
                 $jenis_layanan = $_GET['jenis_layanan'];
                 $res=pg_query($dbconn,"Select v.*,a.qtyin,a.qty_out, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,  b.availableqty, b.availablecost,b.id_satuan,  a.doc_type
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join   view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE v.nama='".$brand."' and v.id_departemen='".$dept."' and a.id_unit='$_SESSION[id_units]' and b.id_unit='$_SESSION[id_units]' and v.id_unit='$_SESSION[id_units]' ");
               
                
                

                 while ($row=pg_fetch_assoc($res)) {

                 	$harga_layanan_obat="SELECT brand.id, harga.harga FROM inv_nama_brand brand 
                 	left outer join inv_kategori_harga harga ON harga.id_brand=brand.id 
                  where brand.nama='".$brand."' and harga.id_layanan='".$jenis_layanan."'";

                    $r=pg_fetch_array(pg_query($dbconn, $harga_layanan_obat));
                      //$harga_unit = $row['availablecost']/$row['qtyin'];
 						           $harga_unit = $r['harga'];
                           ?>
                      <tr id="<?php echo $row['id'] ?>" id_batch="<?php echo $row['stockbal']."_".$harga_unit ?>" >
                      <td style="vertical-align:middle;"><input type="checkbox" id="ceklis" value="<?php echo $row['id_hdr']."_".$row['id_ln']."_".$row['id_batch']."_".$row['no_batch']."_".$row['expired_date']."_".$row['manufacdate']."_".$harga_unit."_".$row['id_satuan']."_".$row['doc_type']; ?>" 
                        name="checkbox_x[]"/></td>

                        <td  style="vertical-align:middle;" >
                        <?php echo $row['no_batch'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['doc_date'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['expired_date'] ?></td>

                        <td style="vertical-align:middle;" >
                       <?php echo $row['manufacdate'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['qtyin'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $harga_unit ?></td>  
                        <td style="vertical-align:middle;" >
                        <?php echo $harga_unit ?></td>  
                        <td style="vertical-align:middle;" ><input type="hidden"  /></td>
                        <td style="vertical-align:middle;" ><input type="hidden" /><?php echo ($row['qtyin']-$row['qty_out']) ?></td> 

                        <td style="vertical-align:middle;" class="keyvalue"> <input class="clickable" name="taken_x[]" style="width: 40px;" type="text" disabled> <input style="width: 40px;" type="hidden" name="total_cost_x[]" disabled></td>  
                      </tr>
                    <?php } ?>
                    
            
                </tbody>
              

              </table>