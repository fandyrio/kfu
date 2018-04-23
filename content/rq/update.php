 <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-rq">Permintaan Penawaran</a></li>
  <li class="breadcrumb-item active">Tambah Permintaan Penawaran</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">

       <div class="card-header">
                  <i class="icon-user"></i> Edit Permintaan Penawaran
                </div>
         <div class="box-header">
         <br>
                          <div class="col-md-12 text-right">
                                <button class="btn btn-xs btn-danger" id="cancel_update_rq_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_update_rq_hdr">Simpan</button>
                                
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
           <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="update_rquohdr">
           <input type="hidden" name="id" value="<?php echo $data['id'] ?>">

          <div class="card-block">
           <div class="row">
              <div class="col-md-8">

                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No. Dokumen  </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo $data['doc_no'] ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>

                <div class="form-group row" >
                  <label for="jm" class="col-sm-2 form-control-label">Tgl. Dokumen</label>

                  <div class="col-sm-6">
                      <input type="text" name="doc_date" value="<?php echo $data['doc_date'] ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>

                 <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Supplier</label>

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

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' value="<?php echo $data['catatan'] ?>"  class='form-control' required>
                      
                  </div>
                  </div>
             
              </div>



                <div class="col-sm-4">
              
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Aktif</label>

                  <div class="col-sm-9">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='TL'>Tidak Dilanjutkan</option>
                      <option value='D'>Hapus</option>
                      
                      </select>
                  </div>
                </div>
                   <div class="form-group row">
                     
                     <label class="col-sm-3 form-control-label"> Kunci</label>

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
                </div>
                

             </form>

              <!-- /.box-body -->           
       

         <div class="col-md-12 mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Details</a>
                      </li>
                        
                     </ul>

                    <div class="tab-content">
                             <div class="tab-pane active" id="home" role="tabpanel">
                                <div id="update_ln">
                        </div>
                            </div>
                
                    </div>
          </div>

         

        <div class="box-body">
            <div class="box-body form-horizontal">  
              <div class="col-md-8">
                <div class="form-group" >
                  <label for="jm" class="col-sm-2 form-control-label">Tanggal</label>
                   <div class="col-sm-6">
                      <input type="text"  value="<?php echo $data['tanggal'] ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 form-control-label">Responsible</label>
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

  </div>
  </div>
  </div>
  </div>
  <script src="assets/js/action/rq.js"></script>
