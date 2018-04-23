  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Rujukan Laboratorium</li>

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
         
            
            <form action="media.php?module=rujukan_laboratorium&act=simpan" method="post">
              <div class="box-body">
                <div class="form-horizontal">
                <div class="row">
                   <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-2">Cabang</label>
                         <div class="col-md-6">
                            <?php 
                          if($_SESSION['id_units']>1){
                              $result =pg_query($dbconn, "SELECT id, nama FROM master_unit WHERE  id='$_SESSION[id_units]'");
                          }
                          else{
                             $result =pg_query($dbconn, "SELECT id, nama FROM master_unit");
                          }
                          ?>
                          <select name='id_unit' id="id_unit" class='form-control' required>
                          
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
                        <label class="col-md-2">Tipe Rujukan</label>
                         <div class="col-md-6">
                          <select name='tipe_rujukan' id="tipe_rujukan" class='form-control' required>
                          
                          <option value=''>--Pilih--</option>
                           <option value='1'>Internal</option>
                            <option value='2'>Eksternal</option>
                         
                          </select>
                          </div>
                    </div>

                      <div class="form-group row">
                        <label class="col-md-2">Cabang Rujukan</label>
                        
                         <div class="col-md-6" id="cabang_rujukan">
                          
                          </div>
                    </div>

                   
                  </div>
                   <div class="col-md-6">
                     <div class="form-group row">
                      <label class="col-md-2">Tanggal</label>
                      <div class="col-md-6">
                      <input type="text" name="tgl" class="form-control " id="datepicker"  required autofocus>
                      </div>
                    </div>
                   
                  </div>
                  </div>
                </div>
                <!-- -->
                <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#unit" role="tab" aria-controls="home">Data Pemeriksaan Pasien</a>
                </li>
                 
                
              </ul>
                
              <div class="card-block">
                <div class="tab-content">

        
                <div class="tab-pane active" id="unit" role="tabpanel">
                          <input name='id_paket' type="hidden" class='form-control' value="<?php echo $_GET['id_item'];  ?>">
                     <div class="form-group">
          
                    <table id="myTable4" class="table">
                    <thead class="table-info">
                    <tr>
                    <th width="10px"><input type="checkbox" /></th>
                      <th width="">NO RM</th>
                      <th width="">Nama</th>
                      <th width="">Test</th>
                      <th width="">Tanggal</th>                                
                    
                      
                    </tr>
                    </thead>
                    <tbody>
                  <?php
                  $query="SELECT trans.id_pasien, trans.waktu_input, o.id_detail, o.jenis, o.id, p.nama, p.no_rm FROM transaksi_invoice_detail trans 
                  LEFT OUTER JOIN lab_order o ON o.id_transaksi_invoice_detail = trans.id
									LEFT OUTER JOIN master_pasien p ON p.id = trans.id_pasien WHERE trans.id_unit='$_SESSION[id_units]'";
                  //var_dump($query);
                  $res=pg_query($dbconn,$query);
                      while ($row=pg_fetch_assoc($res)) {
                           	$tanggal= explode(" ", $row[waktu_input] );
                            
                        $td='<tr><td><input style="vertical-align:left; margin: 5px" type="checkbox" value="'.$row[id_detail]."_".$row[id_pasien]."_".$row[jenis]."_".$row[id].'" name="rujukan__[]" /></td>  <td class="text-left" >'.$row[no_rm].'</td> <td class="text-left" >'.$row[nama].'</td>';
                       if($row['jenis']=='S'){
											$jenis=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
										  echo $td ;
											echo '<td>';
												echo $nama_transaksi="$jenis[nama]";
											echo '</td><td class="text-left" >'.DatetoIndo($tanggal[0]).'</td></tr>';	
											
										}
										elseif($row['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
											echo $td;
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td><td class="text-left" >'.$tanggal[0].'</td></tr>';
										}
										elseif($row['jenis']=='N'){
                      echo $td;
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td><td class="text-left" >'.DatetoIndo($tanggal[0]).'</td></tr>';
										}
										elseif($row['jenis']=='E'){
                      $a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$row[id_detail]' order by d.id_detail ");
                      while($r=pg_fetch_assoc($a)){
                        ?>
                      <?php 
                        
                      if($r['jenis']=='L'){
                        $l=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
                         echo '<tr><td><input style="vertical-align:left; margin: 5px" type="checkbox" value="'.$r[id_detail]."_".$row[id_pasien]."_".$row[id_detail].'" name="rujukan__[]" /></td>  <td class="text-left" >'.$row[no_rm].'</td> <td class="text-left" >'.$row[nama].'</td>';
                        
                         echo '<td>'.$r[nama_paket]." - ".$l[nama].'</td><td class="text-left" >'.$tanggal[0].'</td>';  
                                          
                        
                      }
                      elseif($r['jenis']=='LG'){
                         $lg=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
                        echo '<tr><td><input style="vertical-align:left; margin: 5px" type="checkbox" value="'.$r[id_detail]."_".$row[id_pasien]."_".$row[id_detail].'" name="rujukan__[]" /></td>  <td class="text-left" >'.$row[no_rm].'</td> <td class="text-left" >'.$row[nama].'</td>';
                         echo '<td>'.$r[nama_paket]." - ".$lg[nama].'</td><td class="text-left" >'.$tanggal[0].'</td>';
                        
                      }
                      else{
                          
                        $t=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
                        echo '<tr><td><input style="vertical-align:left; margin: 5px" type="checkbox" value="'.$r[id_detail]."_".$row[id_pasien]."_".$row[id_detail].'" name="rujukan__[]" /></td>  <td class="text-left" >'.$row[no_rm].'</td> <td class="text-left" >'.$row[nama].'</td>';
                         echo '<td>'.$r[nama_paket]." - ".$t[nama].'</td><td class="text-left" >'.$tanggal[0].'</td>';
                                      
                      } 
                                              
                      }
                     
											
										}
                       ?>
                          

                        <?php
                        }
                        ?>
                      </tbody>                 
                </table>
                </div>

                </div>
    </div>
                   

                   

              </div>

                </div>     
              <div class="box-footer">
                <button type="submit" name="simpan" class="btn btn-primary btn-sm btn-flat">SIMPAN</button>
                 <a href="rujukan-laboratorium"><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</button></a>
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
        $('#tipe_rujukan').on('change', function() {
           var id=$(this).val();

        $.ajax({
            type    : 'POST',
            url     : 'data/rujukan.php',
            data    : 'id='+id,
            success : function(response){
                $('#rujukan').hide();
                $('#cabang_rujukan').html(response);

            }
        });

      });

        
        
    </script>