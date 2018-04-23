    <?php
        $q= "Select nama_paket, tgl_awal, tgl_akhir from billing_paket where id='$_GET[id]' ";
         $res=pg_query($dbconn,$q);
         $r=pg_fetch_array($res);

         $result =pg_fetch_array(pg_query($dbconn, "SELECT p.nama, p.id, k.id_unit FROM billing_paket_kategori_harga_unit k 
          INNER JOIN master_kategori_harga p ON p.id=k.id_kategori_harga where k.id_billing_paket= '$_GET[id]' "));

        
    ?>
      <div class="container-fluid">

    <div class="animated fadeIn">

    <div class="card">
    <div class="card-header">
              <i class="icon-grid"></i> Jadwal MCU
            </div>
       <div class="row">
        <!-- left column -->
      <div class="col-md-12 card-body" >
         
            
            <form role="form" action="update-jadwal-mcu" method="post">
             <input type="hidden" name="id" class="form-control"  required autofocus value="<?php echo $_GET[id]; ?>">
             <input type="hidden" name="created_unit" class="form-control"  required autofocus value="<?php echo $res[created_unit]; ?>">
              <div class="box-body">
                <div class="form-horizontal">
                   
                    <div class="form-group row">
                      <label class="col-md-1">Nama Paket</label>
                      <div class="col-md-6">
                      <?php echo $r[nama_paket]; ?>
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
                      <input type="text" name="tgl_awal" class="form-control " id="datepicker" value="<?php echo DateToIndo2($r[tgl_awal]); ?>"  required autofocus>
                      </div>

                       <label class="col-md-1">s/d</label>
                      <div class="col-md-3">
                      <input type="text" name="tgl_akhir" class="form-control " id="datepicker2" value="<?php echo DateToIndo2($r[tgl_akhir]); ?>"  required autofocus>
                      </div>
                    </div>
                  
                </div>
                <!-- -->
                <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#unit" role="tab" aria-controls="home">Unit</a>
                </li>
                 
                
              </ul>
                
              <div class="card-block">
                <div class="tab-content">
                      <div class="tab-pane active" id="unit" role="tabpanel">
                         <div class="form-group" >
                           <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                          <table class="table">
                            <thead>
                              <tr><th width="">Nama</th></tr>
                            </thead>
                                <tbody> 
                                <?php 
                                if($_SESSION['id_units']>1){
                                   $
                                  $unit=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM billing_paket_kategori_harga_unit p 
                                  INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_kategori_harga='$result[id]'
                                  AND u.id='$_SESSION[id_units]' AND p.id_billing_paket='$_GET[id]'");
                                }
                                else{
                                $unit=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM billing_paket_kategori_harga_unit p 
                                  INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_kategori_harga='$result[id]' AND p.id_billing_paket='$_GET[id]'");
                                }
                                while ($row =pg_fetch_assoc($unit)){
                                         ?>
                                <tr>
                                   <td class="text-left"><?php echo $row["nama"];?></td>  
                                </tr>
                                <?php 
                                }  
                                ?>                     
                                 </tbody>
                          </table>
                  </div> 
                      </div>
                      
                <!-- -->


                   

      


                </div>


          
              
             
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                <button type="button" class="btn btn-warning btn-flat" onclick="location.href='mcu-jadwal'">Kembali</button>
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
