
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Purchase Order
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content">

        
<!--form method="POST" enctype="multipart/form-data" action="media.php?inventori=inven&modul=simpan&act=baru"-->
    

        <div class="col-xs-12">
          <div class="box box-primary">
 

 
           
            <!-- /.box-header -->
            <div class="box-body">
     
              
          <!-- Horizontal Form -->
        <div class="box-header">
        <div class="col-md-6 text-left">
                            <h3 class="box-title"><b>Update Purchase Order</b></h3>
                          </div>
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_update_rq_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_update_po_hdr">Simpan</button>
                          </div>
              </div>

            <?php
               $id=$_GET['id'];
               $res =pg_query($dbconn, "SELECT * FROM po_hdr where id='$id'");
               $data =pg_fetch_array($res);

               $_SESSION['id_po_hdr'] = $data['id'];

               //var_dump($res);
             ?>
           <form method="POST" enctype="multipart/form-data" id="update_po_hdr">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body form-horizontal" >
              <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3">No. PO  </label>

                  <div class="col-sm-8">
                      <input type="text" value="<?php echo Random("PO") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>
                 <div class="form-group">
                  <label  class="col-sm-3">Supplier</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required id="supplier_po">
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        if($data['id_unit'] ==$row['id']){
                              echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                            }
                         else echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-3">Departemen</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        if($data['id_departemen'] ==$row['id']){
                              echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                            }
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-3">Ditujukan</label>

                  <div class="col-sm-8">                     
                      <input name='ditujukan' value="<?php echo $data['attention_to'] ?>" class='form-control' required>
                      
                  </div>
                  </div>
                  <div class="form-group">
                  <label  class="col-sm-3">No Referensi</label>

                  <div class="col-sm-8">                     
                      <input name='refno' value="<?php echo $data['refno'] ?>" class='form-control' required>
                      
                  </div>
                  </div>
          
          <span class="btn btn-info" id="alamat_po">Alamat Pengirim dan Penerima</span><br>
         <div class="form-group alamat_po_hidden">
            <label class="col-sm-3">Alamat Pengirim</label>

            <div class="col-sm-8">
              <input type="text"  autocomplete="off" value="<?php echo $data['shipping_address'] ?>" class="form-control"  name="shipping_address">
            </div>
        </div>
        
        <div class="form-group alamat_po_hidden">
            <label class="col-sm-3">Alamat Penerima</label>

            <div class="col-sm-8">
              <input type="text"  autocomplete="off" class="form-control" value="<?php echo $data['delivery_address'] ?>"  name="delivery_address">
            </div>
        </div>

             
              </div>



                <div class="col-sm-6">
              
                <div class="form-group">
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-8">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='E'>Expired</option>
                      <option value='B'>Batal</option>
                      
                      </select>
                  </div>
                </div>
                   <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Dokumen</label>

                  <div class="col-sm-8">
                      <input type="text" name="doc_date" value="<?php echo $data['doc_date'] ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Expected</label>

                  <div class="col-sm-8">
                      <input type="text" name="expected_date" value="<?php echo $data['expected_date'] ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                  <div class="form-group" >
                    <label for="jm" class="col-sm-3">Tgl. Expired</label>

                    <div class="col-sm-8">
                        <input type="text" name="tanggal_expire" value="<?php echo $data['tanggal_expire'] ?>" id="datepicker" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                  <label  class="col-sm-3">Komentar</label>

                  <div class="col-sm-8">                     
                      <input name='komentar' value="<?php echo $data['komentar'] ?>" class='form-control' required>
                      
                  </div>
                  </div>
                </div>
                
                </div>
                

             </form>

              <!-- /.box-body -->
                          
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

        </div>
        <!-- /.col -->
         

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
                <div class="box-footer text-left">
              <div id="update_p_ln">
              </div>
        
              </div>
        
        </div>
            </div>
          </div>
    
        <div class="box-body">

      
            <div class="box-body form-horizontal">

           
              <div class="col-md-8">

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Tanggal</label>

                  <div class="col-sm-6">
                      <input type="text" name="tanggal_lahir" value="<?php echo $data['createddate'] ?>" class="form-control" readonly>
                  </div>
                </div>


                <div class="form-group">
                  <label  class="col-sm-2">Responsible</label>

                  <div class="col-sm-6">                     
                      <input name='kode' class='form-control' readonly>
                      
                  </div>
                  </div>
             </div>
             </div>
              
            </div>
        </div>
  
      <!-- /.row -->
       <div class="box-footer text-right">
               
          </div>


      
      <!--/form-->


      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
