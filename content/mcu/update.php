    <?php
        $q= "Select nama_paket, tanggal, harga_net, harga_gross, disc_amount, disc_persen, created_unit from billing_paket where id='$_GET[id]' ";
         $res=pg_query($dbconn,$q);
         $r=pg_fetch_array($res);

         $result =pg_fetch_array(pg_query($dbconn, "SELECT p.nama, p.id, k.id_unit FROM billing_paket_kategori_harga_unit k 
          INNER JOIN master_kategori_harga p ON p.id=k.id_kategori_harga where k.id_billing_paket= '$_GET[id]' "));

        
    ?>
      <div class="container-fluid">

    <div class="animated fadeIn">

    <div class="card">
    <div class="card-header">
              <i class="icon-grid"></i> Update
            </div>
       <div class="row">
        <!-- left column -->
      <div class="col-md-12 card-body" >
         
            
            <form role="form" action="media.php?content=mcu&modul=simpan&act=edit" method="post">
             <input type="hidden" name="id" class="form-control"  required autofocus value="<?php echo $_GET[id]; ?>">
             <input type="hidden" name="created_unit" class="form-control"  required autofocus value="<?php echo $res[created_unit]; ?>">
              <div class="box-body">
                <div class="form-horizontal">
                   
                    <div class="form-group row">
                      <label class="col-md-1">Nama Paket</label>
                      <div class="col-md-6">
                      <input type="text" name="nama" class="form-control"  required autofocus value="<?php echo $r[nama_paket]; ?>">
                      </div>
                    </div> 

                      <div class="form-group row">
                        <label class="col-md-1">Perusahaan</label>
                         <div class="col-md-6">
                          <input type="hidden" name="perusahaan" class="form-control"  required autofocus value="<?php echo $result[id]; ?>">
                          <b><?php echo $result['nama'];   ?></b>
                          </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-1">Tanggal</label>
                      <div class="col-md-3">
    <input type="text" name="tgl" class="form-control " id="datepicker" value="<?php echo DateToIndo2($r[tanggal]); ?>"  required autofocus>
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
                    <?php 
                    if($_SESSION['id_units']>1){
                      $unit=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM master_unit_perusahaan p 
                      INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_perusahaan='$result[id]'
                      AND u.id='$_SESSION[id_units]'");
                    }
                    else{
                    $unit=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM master_unit_perusahaan p 
                      INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_perusahaan='$result[id]'");
                    }
                   
                    while ($row =pg_fetch_assoc($unit)){
                   $perusahaan=pg_fetch_array(pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM master_unit_perusahaan p 
                    INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_perusahaan='$result[id]' 
                    AND u.id='$result[id_unit]'  AND u.id='$row[id_unit]'"));
                   

                            
                             ?>
                             <tr>
                             <td>
                             <input style="vertical-align:left; margin: 5px" type="checkbox" class="unit" value="<?php echo $row['id_unit'] ?>" name="unit[]" 
                             <?php 
                             if($row['id_unit']==$perusahaan[id_unit]){
                                echo "checked";
                             }
                             ?>
                             />
                             </td>                                   
                              <td class="text-left"><?php echo $row["nama"];?></td>  
                              </tr>
                             <?php 
                            }  
                            ?>                     
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
                             $data=pg_query($dbconn, "Select * from lab_analysis"); 
                           

                                  while ($data_lab=pg_fetch_assoc($data)) {
                                     $res=pg_fetch_array(pg_query($dbconn,"Select id_detail from billing_paket_detail WHERE id_billing_paket= '$_GET[id]' AND jenis='L' AND id_detail='$data_lab[id]' "));
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox"  value="<?php echo $data_lab['id'] ?>" name="lab_analysis[]" class="stest" harga="<?php echo $data_lab["harga_modal"]; ?>"
                                          <?php
                                           if($res['id_detail']==$data_lab['id']){
                                              echo "checked"; 
                                           }
                                           ?>
                                          />
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $data_lab["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($data_lab["harga_modal"], 0,',','.') ?>" name="harga_lab[]" readonly/>
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
                     <div class="form-group" style="overflow-y: scroll; height: 300px">
          
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

                            $resa=pg_query($dbconn,"Select * from lab_analysis_group");

                                  while ($row=pg_fetch_assoc($resa)) {
                                    $res=pg_fetch_array(pg_query($dbconn,"Select id_detail from billing_paket_detail WHERE id_billing_paket= '$_GET[id]' AND jenis='LG' AND id_detail='$row[id]' "));
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id'] ?>" name="lab_analysis_group[]" class="mtest" harga="<?php echo $row["harga"];?>"
                                          <?php
                                           if($row['id']==$res['id_detail']){
                                              echo "checked"; 
                                           }
                                           ?>
                                          />
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($row["harga"], 0,',','.') ?>" name="harga_lab[]" readonly/>
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
                    $tindakan=pg_query($dbconn,"Select * from tindakan");

                                  while ($row=pg_fetch_assoc($tindakan)) {
                                    $res=pg_fetch_array(pg_query($dbconn,"Select id_detail from billing_paket_detail WHERE id_billing_paket= '$_GET[id]' AND jenis='T' AND id_detail='$row[id]' "));
                                       ?>
                                         <tr>
                                          <td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id'] ?>" name="tindakan[]" class="nonlab" harga="<?php echo $row["total"];?>"
                                          <?php
                                           if($row['id']==$res['id_detail']){
                                              echo "checked"; 
                                           }
                                           ?>
                                          />
                                          </td>
                                         
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
                      <input type="text" name="harga" class="form-control text-right " id="harga"  value="<?php echo $r['harga_gross']; ?>" required autofocus>
                      </div>
                    </div>
                    <div class="form-group row status_nasional">
                    <label class="col-md-1 control-label">Diskon</label>
                    <div class="col-md-1">        
                      <select name='opsi_persen' id='opsi_persen' class='form-control ' onchange="hitung__cost()">
                      <option value='Y' 
                      <?php 
                        if($r['disc_persen']){
                      echo "selected"; 
                      }                      
                        ?>
                      >%</option>
                      <option value='N' <?php  if($r['disc_amount']){
                      echo "selected"; 
                      } ?> >Amount</option>
                      </select>
                    </div>
                  </div>
                     <div class="form-group row">
                      <label class="col-md-1">Diskon</label>
                      <div class="col-md-1">
                      <input type="text" name="diskon" class="form-control text-right " id="diskon"  onchange="hitung__cost()" autofocus 
                      value="
                      <?php 
                      if($r['disc_persen']){
                      echo $r['disc_persen']; 
                      }
                      else {
                      echo $r['disc_amount']; 
                      }

                      ?>"
                      required
                      >
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-1">Harga Nett</label>
                      <div class="col-md-2">
                      <input type="text" name="harga_nett" class="form-control text-right" id="harga_nett"  required autofocus readonly value="<?php echo $r['harga_net']; ?>">
                      </div>
                    </div>
              </div>
                <!-- -->


                   

      


                </div>


          
              
             
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                <button type="button" class="btn btn-warning btn-flat" onclick="location.href='mcu'">Kembali</button>
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
   var total=parseInt($('#harga').val());
         $('.stest ,.nonlab, .mtest').on('change', function() {

         var harga = $(this).attr('harga');
          var opsi_persen   = $('#opsi_persen').val();           
        var harga_nett    = $('#harga_nett').val();
       var diskon        = $('#diskon').val();
        if(!harga){
            harga=0;
        }

         if(!diskon){
            diskon=0;
        }
      if ($(this).is(':checked')) {
         total+=parseInt(harga);
      }
      else{
         total-=parseInt(harga);
      }
    

           if(opsi_persen=='Y'){
            total = total - (harga*diskon/100);
          }
          else{
            total = total - diskon;
          }
        

             $('#harga_nett').val(total);
        
       
       // alert(total);
      $('#harga').val(total);
      });

         function hitung__cost(){
          var total_nett=0;
                       
           var opsi_persen   = $('#opsi_persen').val();
           var harga         = $('#harga').val();
           var harga_nett    = $('#harga_nett').val();
           var diskon        = $('#diskon').val();

           if(opsi_persen=='Y'){
            total_nett = harga - (harga*diskon/100);
          }
          else{
            total_nett = harga - diskon;
          }
        if(total_nett <=0){
          alert("Harga bersih tidak diperbolehkan dibawah 0");
           total_nett = harga;
           $('#diskon').val(0);
        }

             $('#harga_nett').val(total_nett);


             
         }
        
    </script>