            <?php
              $nama_brand = $_GET['nama'];
              $id_departemen = $_GET['id_departemen']; 
               $bal = $_GET['bal'];
              $query="Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,   
                    b.availableqty, b.availablecost,b.id_satuan, a.suppname
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE   v.id_departemen='".$id_departemen."' and b.nama='".$nama_brand."'";
               $res=pg_query($dbconn,$query); 
               //var_dump($query);
            ?>
              <div class="box-body form-horizontal" >
                  <div class="form-group">
                   
                    <label class="col-sm-3">Nama Brand</label>

                    <div class="col-sm-4">                     
                        <input  class='form-control'  value="<?php echo $nama_brand ?>" readonly>
                        
                    </div>


                  </div>  
                   <div class="form-group">
                   
                    <label class="col-sm-3">Saat Ini</label>

                    <div class="col-sm-4">                     
                        <input  class='form-control'  value="<?php $bal; ?>" readonly>
                        
                    </div>


                  </div> 
                </div>
                  <table   class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Batch No</th>
                        <th>Document Date</th>
                        <th>Manufacture</th>
                        <th>Expiry Date</th>
                        <th>Base UOM</th>
                        <th>Balance Quantity</th>
                        <th>Balance Cost</th>
                        <th >Unit Cost</th>
                        <th>Supplier name</th>
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td><?php echo  $no; ?></td>
                              <td><?php echo  $row['no_batch']; ?></td>
                              <td><?php echo  $row['doc_date']; ?></td>
                              <td><?php echo  $row['manufacdate']; ?></td>
                              <td><?php echo  $row['id_satuan']; ?></td>
                              <td><?php echo  $row['no_batch']; ?></td>
                              <td><?php echo  $row['availableqty']; ?></td>
                              <td><?php echo  $row['availablecost']; ?></td>
                              <td><?php echo  $row['suppname']; ?></td>    
                              </tr>
         
                       <?php } ?> 
                      </tbody>
                    </table>