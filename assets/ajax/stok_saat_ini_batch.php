            <?php
            error_reporting(0);
            session_start();
              include_once('../../config/conn.php');
              include_once('../../config/function.php');

              $nama_brand = $_GET['nama'];
              $id_departemen = $_GET['id_departemen']; 
               $bal = $_GET['bal'];
              $query="Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,   
                    b.availableqty, b.availablecost,b.id_satuan, a.suppname, a.costin, a.cost_out, a.qtyin, a.qty_out
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE   v.id_departemen='".$id_departemen."' and b.nama='".$nama_brand."' and v.id_unit='$_SESSION[id_units]' and a.id_unit='$_SESSION[id_units]' and b.id_unit='$_SESSION[id_units]'";
               $res=pg_query($dbconn,$query); 

              
            ?>
              <div class="box-body form-horizontal" >
                  <div class="form-group">
                   
                    <label class="col-sm-3">Nama Brand</label>

                    <div class="col-sm-4">                     
                        <input  class='form-control'  value="<?php echo $nama_brand ?>" readonly>
                        
                    </div>


                  </div>  
                   
                </div>
                  <table   class="table table-bordered " >
                      <thead class="table-info">
                      <tr >
                        <th>No</th>
                        <th>No Batch</th>
                        <th>Tanggal Dokumen</th>
                        <th>Manufacture</th>
                        <th>Expiry Date</th>
                       <!--  <th>Base UOM</th> -->
                        <th>Balance Quantity</th>
                        <th>Balance Cost</th> 
                        <th>Harga Unit</th>                        
                        <th>Nama Supplier</th>
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       while ($row=pg_fetch_assoc($res)) {
                        $harga_unit = ($row['costin']-$row['cost_out'])/($row['qtyin']-$row['qty_out']);
                        $qtybal = $row['qtyin']-$row['qty_out'];
                        $no++;

                           ?>
                             <tr>
                              <td><?php echo  $no; ?></td>
                              <td><?php echo  $row['no_batch']; ?></td>
                              <td><?php echo  tgl_indo($row['doc_date']); ?></td>
                              <td><?php echo  tgl_indo($row['manufacdate']); ?></td>
                             <!--  <td style="text-align: center"><?php echo  $row['id_satuan']; ?></td> -->
                              <td style="text-align: center"><?php echo  $row['no_batch']; ?></td>
                              <td style="text-align: right"><?php echo  $row[stockbal] ?></td>

                              <td style="text-align: right"><?php echo  number_format(($row['costin']-$row['cost_out']), 0, ',', '.'); ?></td>
                              <td style="text-align: right"><?php echo number_format($harga_unit, 0, ',', '.');  ?></td>
                              <td><?php echo  $row['suppname']; ?></td>    
                              </tr>
         
                       <?php } ?> 
                      </tbody>
                    </table>