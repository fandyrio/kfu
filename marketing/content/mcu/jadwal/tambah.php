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
         
            
            <form role="form" action="simpan-jadwal-mcu" method="post">
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
                    <div class="form-group row">
                      <label class="col-md-1">Tanggal</label>
                      <div class="col-md-2" >
                       <input name='tgl_awal' id="datepicker" class='form-control ' >
                      </div>
                      <label class="col-md-1">s/d</label>
                      <div class="col-md-2" >
                       <input name='tgl_akhir' id="datepicker2" class='form-control ' >
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
           //alert(id);

        $.ajax({
            type    : 'POST',
            url     : 'data/even.php',
            data    : 'id='+id,
            success : function(response){
               
                $('#paket').html(response);

            }
        });
         $.ajax({
            type    : 'POST',
            url     : 'data/unit.php',
            data    : 'id='+id,
            success : function(response){
                $('#unites').html(response);

            }
        });

      });
        

        
        
    </script>