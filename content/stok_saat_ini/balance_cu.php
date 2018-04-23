     <?php
     session_start();
      $id_departemen='1'; 
      if(isset($_POST["cari"]))
      {
         $id_departemen=$_POST['id_departemen'];

     }
     $tampil = pg_query($dbconn,"select distinct v.nama, sum(v.stockbal) as stock from view_inventoribatchbalance as v
               where v.id_departemen='".$id_departemen."' and v.id_unit='$_SESSION[id_units]' group by v.nama");
      
    
     /*$res=pg_query($dbconn,"Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,   
                    b.availableqty, b.availablecost,b.id_satuan
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE   v.id_departemen='".$id_departemen."' "); */
    
    
     ?>         
                  <table   class="table table-bordered stok_saat_ini" id="myTable" >
                      <thead class="table-success ">
                      <tr>
                      <th style="text-align:center">Nama Brand</th>
                        <th style="text-align:center">Balance Quality</th>
                        <th style="text-align:center">Balance Cost</th>
                         
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;                  
     

                         while ($row=pg_fetch_assoc($tampil)) {

                          $query="Select v.*,a.qtyin,  b.availablecost,b.availableqty
                          from view_inventoribatchbalance v 
                          left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                           left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                         WHERE   v.id_departemen='".$id_departemen."' and b.nama='".$row["nama"]."' and v.id_unit='$_SESSION[id_units]' and a.id_unit='$_SESSION[id_units]' and b.id_unit='$_SESSION[id_units]'";

                         $hasil = pg_query($dbconn, $query);
                         $data=pg_fetch_array($hasil);

                       
                     //$res=pg_query($dbconn,$query); 
                       
                        $no++;

                           ?>
                             <tr data-mit-brand="<?php echo $row["nama"]; ?>" data-mit-departemen="<?php echo $id_departemen; ?>" data-bal="<?php echo $row["availableqty"];?>">
                              <td style="text-align:center"><?php echo $row["nama"]; ?></td>
                              <td style="text-align:right"><?php echo $row['stock'];?></td>
                              <td style="text-align:right"><?php echo number_format($data["availablecost"], 0, ',', '.');?></td>
                              
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>