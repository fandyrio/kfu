 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Stok Adjustment
      </h1>
    
    </section>

    <section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">

                <div class="box-header">
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <button type="button" onclick="location.href='media.php?inventori=stok_adjustment&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> New</button> 
                         <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> View</button>
                           <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Delete</button>  
                            <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Setting</button>  
                      </div>
                     
                    </div>
          
              <div class="box-body form-horizontal" >
                <div class="form-group">
                  <label class="col-sm-1">Unit  </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo createRandomPassword() ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                  <label class="col-sm-1">Aktif</label>

                  <div class="col-sm-4">
                       <?php 
                      $result =pg_query($dbconn, "SELECT DISTINCT id_brand FROM inv_inventori");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['id_brand']."</option>";
                      }
                      ?>
                      </select>
                  </div>


                </div>


                 <div class="form-group">
                  <label  class="col-sm-1">Supplier</label>

                  <div class="col-sm-4">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>    
                </div>

             <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td>Minimum Date:</td>
                        <td><input name="min" id="min" type="text"></td>
                    </tr>
                    <tr>
                        <td>Maximum Date:</td>
                        <td><input name="max" id="max" type="text"></td>
                    </tr>
                </tbody>
           </table>
           <br>
              <!-- /.box-body -->
               <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Departemen</th>
                   <th >Tanggal</th>
                    <th >No Document </th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"select h.doc_no,h.createddate,l.qty, d.nama as \"nama_departemen\" , s.nama as \"nama_satuan\", b.nama_brand as \"nama_brand\" 
                from stok_adj_hdr as h
                LEFT OUTER JOIN stok_adj_ln as l on l.id_adj_hdr = h.id
                LEFT OUTER JOIN stok_adj_batch as b on b.id_adj_hdr = h.id
                LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
                LEFT OUTER JOIN inv_satuan as s on s.id = l.id_satuan");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $row['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['createddate'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        
                       </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              

              </table>

                </div>
        </div>
      </div>
      </div>
    </section>
  </div>
