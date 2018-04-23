
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
       Penawaran Harga
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Penawaran Harga</li>
      </ol>
    </section>
    <section class="content">
      <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body"> 
		           

        <div class="box-header">
                        <div class="col-md-6 text-left">
                            <h3 class="box-title"><b>Update Penawaran Harga</b></h3>
                          </div>
                          <div class="col-md-6 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_update_hdr_q">Cancel</button>
                                 <button class="btn-xs btn-success" id="update_penawaran_harga_save">Simpan</button>
                          </div>
              </div>

          <!-- Horizontal Form -->
            <!-- /.box-header -->
            <!-- form start -->

              <?php
               $id=$_GET['id'];
               $res =pg_query($dbconn, "SELECT * FROM q_hdr where id='$id'");
               $data =pg_fetch_array($res);

               $_SESSION['id_q_hdr'] = $data['id'];

               //var_dump($res);
             ?>
      <form method="POST" enctype="multipart/form-data" id="update_form_penawaran">
      <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body form-horizontal">
              <div class="col-md-8">

                <div class="form-group">
                  <label class="col-sm-2"> No. Penawaran</label>

                  <div class="col-sm-5">
                      <input  class='form-control' value="<?php echo $data['no_dok'] ?>" readonly >
                     
                  </div>
                </div>

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Supplier</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' id="id_suppli" class='form-control' required>
                      
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
                  <label  class="col-sm-2">Tgl Valid</label>

                  <div class="col-sm-8">                     
                      <input name='validfrom' value="<?php echo $data['validfrom'] ?>" id="datepicker"  required>to
                      <input name='validto' value="<?php echo $data['validto'] ?>" id="datepicker2"  required>
                      
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-2">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' value="<?php echo $data['catatan'] ?>" class='form-control' required>
                      
                  </div>
                  </div>
                
              </div>



                <div class="col-sm-4">
            
                <div class="form-group">
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='K'>Kadaluwarsa</option>
                      <option value='C'>Cancel</option>
                      
                      </select>
                            </div>
                          </div>
                  <div class="form-group">
                            <label  class="col-sm-3">Tgl Doc</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_dok' id="datepicker3" value="<?php echo $data['tgl_dok'] ?>"  class='form-control' required>
                                
                            </div>
                          </div>
                  <div class="form-group">
                            <label  class="col-sm-3">Kunci</label>

                            <div class="col-sm-6">                     
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

              <!-- /.box-body -->
              </form>
         
        
		        </div>
        </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"> Item Penawaran Harga </a></li>           
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
              <div class="box-footer text-left">
                <div id="update_q_ln">
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
                      <input type="text" value="<?php echo $data['createddate'] ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2">Responsible</label>
                  <div class="col-sm-6">                     
                      <input  class='form-control' readonly>                    
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
