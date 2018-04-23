 <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-quotation"> Penawaran</a></li>
  <li class="breadcrumb-item active">Edit Penawaran</li>
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
                    
                          <div class="pull-right">
                                 <button class="btn btn-xs btn-danger" id="cancel_update_hdr_q">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="update_penawaran_harga_save">Simpan</button>
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
      <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="update_form_penawaran">
      <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="card-block">
              <div class="row">
              <div class="col-md-8">

                <div class="form-group row">
                  <label class="col-sm-2 form-control-label"> No. Penawaran</label>

                  <div class="col-sm-5 ">
                      <input  class='form-control' value="<?php echo $data['doc_no'] ?>" readonly >
                     
                  </div>
                </div>

                <div class="form-group row" >
                  <label  class="col-sm-2 form-control-label">Supplier</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier where id='".$data['id_supplier']."'");
                                  
                      $row =pg_fetch_assoc($result)
                       
                      ?>

                        <input  class='form-control' value="<?php echo $row['nama'] ?>" readonly >
                  </div>
                </div>

             <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Tgl Valid</label>

                  <div class="col-sm-8">                     
                      <input name='validfrom' value="<?php echo $data['validfrom'] ?>" id="datepicker"  required>to
                      <input name='validto' value="<?php echo $data['validto'] ?>" id="datepicker2"  required>
                      
                  </div>
                </div>

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' value="<?php echo $data['catatan'] ?>" class='form-control' required>
                      
                  </div>
                  </div>
                
              </div>



                <div class="col-sm-4">
            
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Status</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='K'>Kadaluwarsa</option>
                      <option value='C'>Cancel</option>
                      
                      </select>
                            </div>
                          </div>
                  <div class="form-group row">
                            <label  class="col-sm-3 form-control-label">Tgl Doc</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_dok' id="datepicker3" value="<?php echo $data['tgl_dok'] ?>"  class='form-control' required>
                                
                            </div>
                          </div>
                  <div class="form-group row">
                            <label  class="col-sm-3 form-control-label">Kunci</label>

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

             </div>

              <!-- /.box-body -->
              </form>
         
        
		        
     


                 <div class="col-md-12 mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Item Penawaran Harga </a>
                      </li>
                        
                     </ul>

                    <div class="tab-content">
                             <div class="tab-pane active" id="home" role="tabpanel">
                                <div id="update_q_ln">
                        </div>
                            </div>
                
                    </div>
            </div>
            </div>

   </div>

           <div class="box-body">
           <div class="card-block">
            <div class="box-body form-horizontal">  
              <div class="col-md-8">
                <div class="form-group row" >
                  <label class="col-sm-2 form-control-label">Tanggal</label>
                   <div class="col-sm-6">
                      <input type="text" value="<?php echo $data['createddate'] ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Responsible</label>
                  <div class="col-sm-6">                     
                      <input  class='form-control' readonly>                    
                  </div>
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
