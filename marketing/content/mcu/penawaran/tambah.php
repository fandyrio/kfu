 <?php session_start(); 
 // var_dump($_SESSION);
 ?>

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
            <input type="hidden" name="maks_diskon" id="maks_diskon"  class="form-control" value="<?php echo $_SESSION['maks_diskon'] ?>">
              <div class="box-body">
                <div class="form-horizontal">
                   
                    <div class="form-group row">
                      <label class="col-md-1">Nama Paket</label>
                      <div class="col-md-6">
                      <input type="text" name="nama" class="form-control"  required autofocus>
                      </div>
                    </div> 

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
                      <label class="col-md-1">Keterangan/Catatan</label>
                      <div class="col-md-6">
							<textarea name="keterangan" class="form-control"></textarea>
                      </div>
                    </div> 
                </div>
				<hr>
                <!-- -->
                <div class="row">
                 <div class="card-block col-md-6" id="data_penawaran">
                  <table id="myTable" class="table ">
                <thead class="table-success">
                <tr>
                <th width="10px">No.</th>
                  <th width="">Nama Pemeriksaan</th>
                  <th width="">Harga</th>
                  
                   <th width="60px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
             $id_users =$_SESSION['login_user'];
           
                  $q= "Select * from billing_paket_detail  
                       where id_users= '$id_users' ORDER BY id ASC";
                              
            
            
                 $res=pg_query($dbconn,$q);
                 $no=1;
                 $total_harga=0;

                 while ($row=pg_fetch_assoc($res)) {
                    $total_harga+=$row["harga"];

                     ?>
                       <tr>     
                       <td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td> 
                        <?php
                          if($row['jenis']=='L'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Single  ".$nama_transaksi="$a[nama]";
                        echo '</td>'; 
                      
                      } 
                       else if($row['jenis']=='G'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Multi ".$a[nama];
                        echo '</td>'; 
                      
                      } else if($row['jenis']=='T'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Non Lab ".$a[nama];
                        echo '</td>'; 
                      
                      } 

                        ?>
                        <td class="text-right"><?php echo number_format($row["harga"],0,',','.');?></td>
                       
                        <td class="text-center" style="vertical-align:middle;">                           
                            <a href="media.php?content=mcu&modul=hapus_ADD&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
               

              </table>
              <div class="col-md-12 pull-right">
              <div class="form-group row">
                      <label class="col-md-2">Harga Total</label>
                      <div class="col-md-4">
                      <input type="text" name="harga" value="<?php echo $total_harga; ?>" class="form-control text-right " id="harga"  required onchange="hitung__cost()">
                      </div>
                    </div>
                    <div class="form-group row status_nasional">
                    <label class="col-md-2 control-label">Diskon</label>
                    <div class="col-md-3">        
                      <select name='opsi_persen' id='opsi_persen' class='form-control ' onchange="hitung__cost()">
                      <option value='Y' selected>%</option>
                      <option value='N' >Amount</option>
                      </select>
                    </div>
                  </div>
                     <div class="form-group row">
                      <label class="col-md-2">Diskon</label>
                      <div class="col-md-2">
                      <input type="text" name="diskon" class="form-control text-right " id="diskon"  onchange="hitung__cost()" autofocus>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-2">Harga Nett</label>
                      <div class="col-md-4">
                      <input type="text" name="harga_nett" class="form-control text-right" id="harga_nett"  required value="<?php echo $total_harga; ?>" readonly>
                      </div>
                    </div>
                  </div>
                  </div>
                  
             
             
                
              <div class="card-block col-md-6">

                <ul class="nav nav-tabs" role="tablist">
                
                 <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#singletest" role="tab" aria-controls="home">Single Test</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#multipletest" role="tab" aria-controls="bar">Multiple Test</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#nonlab" role="tab" aria-controls="bar">Non Lab</a>
                </li>
                
              </ul>
                <div class="tab-content">
                      
                      <div class="tab-pane active" id="singletest" role="tabpanel">
                          <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                     <div class="form-group">
          
                     <table id="myTable7" class="table table-responsive">
                    <thead class="table-info">
                    <tr>
                    
                      <th>Nama</th>
                      <th width="80px">Harga Modal</th> 
                       <th width="50px">Harga</th>  
                       <th>#</th>
                       </tr>
                    </thead>
                    <tbody>                   
                              <?php

                            $res=pg_query($dbconn,"Select * from lab_analysis");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                         
                                          <input style="vertical-align:left; margin: 5px" type="hidden"  value="<?php echo $row['id'] ?>" name="lab_analysis"  />
                                         
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <?php echo number_format($row["harga_modal"], 0,',','.');?> 
                                          </td>
                                          <td class="text-right">
                                            <input style="vertical-align:right; margin: 5px" type="text" 
                                          value="" name="harga_lab_penawaran[]"/>
                                          </td>
                                          <td>
                                            <a untuk="lab" href="#" class="btn  btn-sm btnSave"><i class="fa fa-save"></i></a>
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
          
                    <table id="myTable4" class="table table-sm">
                    <thead class="table-info">
                    <tr>  
                                    
                      <th width="">Nama</th>
                      <th width="">Harga Modal</th>  
                      <th width="50px">Harga</th>  
                       <th width="50px">#</th>                            
                    
                      
                    </tr>
                    </thead>
                    <tbody>
                   
                              <?php

                            $res=pg_query($dbconn,"Select * from lab_analysis_group");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                         
                                          <input style="vertical-align:left; margin: 5px" type="hidden" value="<?php echo $row['id'] ?>" name="lab_analysis"/>
                                          
                                          <td class="text-left" ><?php echo $row["nama"] ?></td>
                                           
                                           <td class="text-right">
                                             <?php echo number_format($row["harga_modal"], 0,',','.') ?>
                                          </td>
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          name="harga_lab" />
                                          </td>
                                           <td>
                                            <a untuk="group" href="#" class="btn  btn-sm btnSave"><i class="fa fa-save"></i></a>
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
                
                  <th width="">Nama</th>
                  <th width="">Harga Modal</th>  
                  <th width="">Harga</th>
                  <th width="">#</th>    

                
                  
                </tr>
                </thead>
                <tbody>
                    <?php
                    $res=pg_query($dbconn,"Select * from tindakan");

                                  while ($row=pg_fetch_assoc($res)) {
                                       ?>
                                         <tr>
                                         <input style="vertical-align:left; margin: 5px" type="hidden" value="<?php echo $row['id'] ?>" name="tindakan[]" />
                                         
                                          <td class="text-left"><?php echo $row["nama"] ?></td>
                                          
                                          <td><?php echo number_format($row["total"], 0,',','.')  ?>
                                          </td>
                                           <td>
                                          <input style="vertical-align:right; margin: 5px" type="text" 
                                          name="harga_tindakan[]"  class="text-right" />  
                                          </td>
                                          <td>
                                            <a untuk="tindakan" href="#" class="btn  btn-sm btnSave"><i class="fa fa-save"></i></a>
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
                 
              </div>
                <!-- -->

                </div>
                   

			


                </div>


          
							
             
            

            
          </div>
		    
             
            <!-- /.box-body -->
          </div>
		  <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
				<a href="mcu-penawaran" class="btn btn-danger btn-flat">Batal</a>
              </div>
          <!-- /.box -->
</form>
          <!-- /.box -->
        </div>
        </div>
        </div>

  <script type="text/javascript">
   $('.btnSave').on('click', function() {
      var id= $(this).closest('tr').find("input:eq(0)").val();
      var harga= $(this).closest('tr').find("input:eq(1)").val();
      var jenis = $(this).attr("untuk");
     // alert(jenis);
      if(!harga){
         alert("isi harga");
          return;
      }
      var data ='id='+id+'&harga='+harga;
      alert(data);
      $.ajax({
          type: 'POST',
          url: 'media.php?content=mcu&modul=simpan&act='+jenis,
          data: data,
          success: function(msg){

            $('#data_penawaran').load('content/mcu/penawaran/detail_data_mcu.php');
          }
        });
      
      });
   function hitung__cost(){
          var total_nett=0;
            
           var maks_diskon   = $('#maks_diskon').val();             
           var opsi_persen   = $('#opsi_persen').val();
           var harga         = $('#harga').val();
           var harga_nett    = $('#harga_nett').val();
           var diskon        = $('#diskon').val();

           var how_amt_persen=0;
           if(!maks_diskon){
            maks_diskon=0;
           }

           if(opsi_persen=='Y'){
            if(parseInt (diskon)>parseInt(maks_diskon)){
              alert("AUTH PERSEN TIDAK DIIJINKAN");
              $('#diskon').val(maks_diskon);
              diskon =  maks_diskon;
            }
            total_nett = harga - (harga*diskon/100);
          }
          else{
            how_amt_persen = diskon/harga*100;
           
            if(parseInt(how_amt_persen)>parseInt(maks_diskon)){
                alert("AUTH PERSEN TIDAK DIIJINKAN");
                $('#diskon').val(0);
                diskon =0;
            }
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