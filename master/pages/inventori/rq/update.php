  <div class="content-wrapper">
    <section class="content-header">
      <h1>
       Permintaan Penawaran Harga
      </h1> 
    </section>
    <section class="content">

        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body"> 
              
          <!-- Horizontal Form -->
        <div class="box-header">
                        <div class="col-md-6 text-left">
                            <h3 class="box-title"><b>Tambah Permintaan</b></h3>
                          </div>
                          <div class="col-md-6 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_update_rq_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_update_rq_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
            <?php
               $id=$_GET['id'];
               $res =pg_query($dbconn, "SELECT * FROM rq_hdr where id='$id'");
               $data =pg_fetch_array($res);

               $_SESSION['id_rq_hdr'] = $data['id'];

               //var_dump($res);
             ?>
           <form method="POST" enctype="multipart/form-data" id="update_rquohdr">
           <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body form-horizontal" >
              <div class="col-md-8">

                <div class="form-group">
                  <label class="col-sm-2">No. Dokumen  </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo $data['doc_no'] ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Tgl. Dokumen</label>

                  <div class="col-sm-6">
                      <input type="text" name="doc_date" value="<?php echo $data['doc_date'] ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>

                 <div class="form-group">
                  <label  class="col-sm-2">Supplier</label>

                  <div class="col-sm-6">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                          if($data['id_supplier'] ==$row['id']){
                              echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                            }
                            else echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                                 
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-2">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' value="<?php echo $data['catatan'] ?>"  class='form-control' required>
                      
                  </div>
                  </div>
             
              </div>



                <div class="col-sm-4">
              
                <div class="form-group">
                  <label class="col-sm-3">Aktif</label>

                  <div class="col-sm-9">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='TL'>Tidak Dilanjutkan</option>
                      <option value='D'>Hapus</option>
                      
                      </select>
                  </div>
                </div>
                   <div class="form-group">
                     
                     <label class="col-sm-3"> Kunci</label>

                      <div class="col-sm-9">

                        <?php
                          if($data['islock'] ==1)
                              echo "<input type='checkbox' class='tambah' checked name='islock'>";
                            
                          else
                                  echo "<input type='checkbox' class='tambah'  name='islock' >";
                            ?>

                       
                        
                      </div>
                  </div>
                </div>
                
          
                </div>

             </form>

              <!-- /.box-body -->           
            </div>
        </div>
         
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  <div class="box-footer text-left">
          <div id="update_ln">
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
                      <input type="text"  value="<?php echo $data['tanggal'] ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2">Responsible</label>
                  <div class="col-sm-6">                     
                      <input class='form-control' readonly>                    
                  </div>
                  </div>
             </div>
             </div>
              
            </div>
        </div>
       <div class="box-footer text-right">
               
          </div>

    </section>
  </div>
