  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">MCU</li>

</ol>



      <div class="container-fluid">

    <div class="animated fadeIn">

    <div class="card">
      <div class="card-header">
              <i class="icon-grid"></i> Tambah
      </div>
       <div class="row" style="padding-top: 5px">
        <!-- left column -->
      <div class="col-md-12 card-body" >
         
            
            <form role="form" action="media.php?content=mcu&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-horizontal">
                   
                    

                      <div class="form-group row">
                        <label class="col-md-1">Perusahaan</label>
                         <div class="col-md-6">
                            <?php 
                          if($_SESSION['id_units']>1){
                              $result =pg_query($dbconn, "SELECT h.* FROM master_kategori_harga h 
                                INNER JOIN master_unit_perusahaan p ON p.id_perusahaan = h.id WHERE p.id_unit='$_SESSION[id_units]'");
                          }
                          else{
                             $result =pg_query($dbconn, "SELECT * FROM master_kategori_harga ");
                          }
                          ?>
                          <select name='id_perusahaan' id="id_perusahaan" class='form-control select2' required>
                          
                          <option value=''>Pilih Perusahaan</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
                          </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-1">Nama Paket</label>
                      <div class="col-md-6" id="paket">
                       <select name='id_paket' id="id_paket" class='form-control ' disabled >
                          
                          <option value=''>Pilih Paket</option>
                         
                          </select>
                      </div>
                    </div>
                  
                </div>
                <!-- -->
                <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#unit" role="tab" aria-controls="home">Unit</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#singletest" role="tab" aria-controls="home">Single Test</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#multipletest" role="tab" aria-controls="bar">Multiple Test</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#nonlab" role="tab" aria-controls="bar">Non Lab</a>
                </li>
                
              </ul>
                
              <div class="card-block">
                <div class="tab-content">
                      <div class="tab-pane active" id="unit" role="tabpanel">
                         <div class="form-group" >
                          
                    <table id="myTable7" class="table">
                    <thead class="table-info">
                    <tr>
                    <th width="10px"><input type="checkbox"  id="select-unit" /></th>
                      <th width="">Nama</th>
                                                
                    
                      
                    </tr>
                    </thead>
                    <tbody id="unites">                        
                    </tbody>
                            </table>
                            </div> 
                      </div>
                      <div class="tab-pane" id="singletest" role="tabpanel">
                          <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                     <div class="form-group">
          
                     <table id="myTable6" class="table">
                    <thead class="table-info">
                    <tr>
                    <th width="10px"><input type="checkbox"  id="select-stest" /></th>
                      <th width="">Nama</th>
                      <th width="">Harga</th>                             
                    
                      
                    </tr>
                    </thead>
                    <tbody>                   
                              <?php

                            $res=pg_query($dbconn,"Select * from lab_analysis");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox"  value="<?php echo $row['id'] ?>" name="lab_analysis[]" class="stest" harga="<?php echo $row["harga_modal"]; ?>"/>
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($row["harga_modal"], 0,',','.') ?>" name="harga_lab[]" readonly/>
                                          </td>
                                     
                                         
                        </tr>     

                        <?php
                        }
                        ?>
                        </tbody>                 
                </table>
                </div>

                </div>
                <div class="tab-pane" id="multipletest" role="tabpanel">
                          <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                     <div class="form-group">
          
                    <table id="myTable4" class="table">
                    <thead class="table-info">
                    <tr>
                    <th width="10px"><input type="checkbox"  id="select-mtest" /></th>
                      <th width="">Nama</th>
                      <th width="">Harga</th>                             
                    
                      
                    </tr>
                    </thead>
                    <tbody>
                   
                              <?php

                            $res=pg_query($dbconn,"Select * from lab_analysis_group");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id'] ?>" name="lab_analysis_group[]" class="mtest" harga="<?php echo $row["harga_modal"];?>"/></td>
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($row["harga_modal"], 0,',','.') ?>" name="harga_lab[]" readonly/>
                                          </td>
                                     
                                         
                        </tr>     

                        <?php
                        }
                        ?>
                      </tbody>                 
                </table>
                </div>

                </div>
                <div class="tab-pane" id="nonlab" role="tabpanel">
                          <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                     <div class="form-group">
          
                <table id="myTable5" class="table">
                <thead class="table-info">
                <tr>
                <th width="10px"><input type="checkbox" id="select-nonlab" /></th>
                  <th width="">Nama</th>
                  <th width="">Harga</th>                             
                
                  
                </tr>
                </thead>
                <tbody>
                    <?php
                    $res=pg_query($dbconn,"Select * from tindakan");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                          <td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id'] ?>" name="tindakan[]" class="nonlab" harga="<?php echo $row["total"];?>"/></td>
                                         
                                          <td class="text-left"><?php echo $row["nama"] ?></td>
                                          
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="text" 
                                          value="<?php echo number_format($row["total"], 0,',','.')  ?>" name="harga_tindakan[]" readonly class="text-right" />
                                          
                                            
                                          </td>
                                     
                                         
                                      </tr>
                                     <?php 
                    } 
                  ?> 
                     </tbody>
                     </table>
                    
                </div>

                </div>
                     
                      
                </div>
                  <div class="form-group row">
                      <label class="col-md-1">Harga Total</label>
                      <div class="col-md-2">
                      <input type="text" name="harga" class="form-control text-right " id="harga"  required onchange="hitung__cost()">
                      </div>
                    </div>
                    <div class="form-group row status_nasional">
                    <label class="col-md-1 control-label">Diskon</label>
                    <div class="col-md-1">        
                      <select name='opsi_persen' id='opsi_persen' class='form-control ' onchange="hitung__cost()">
                      <option value='Y' selected>%</option>
                      <option value='N' >Amount</option>
                      </select>
                    </div>
                  </div>
                     <div class="form-group row">
                      <label class="col-md-1">Diskon</label>
                      <div class="col-md-1">
                      <input type="text" name="diskon" class="form-control text-right " id="diskon"  onchange="hitung__cost()" autofocus>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-1">Harga Nett</label>
                      <div class="col-md-2">
                      <input type="text" name="harga_nett" class="form-control text-right" id="harga_nett"  required autofocus readonly>
                      </div>
                    </div>
              </div>
                <!-- -->


                   

			


                </div>


          
							
             
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
              </div>

            </form>
          </div>
          <!-- /.box -->

             
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        </div>
        </div>

 <script type="text/javascript">
        $('#id_perusahaan').on('change', function() {
           var id=$(this).val();
           alert(id);

        $.ajax({
            type    : 'POST',
            url     : 'data/even.php',
            data    : 'id='+id,
            success : function(response){
               
                $('#paket').html(response);

            }
        });

      });

        
        
    </script>