<?php
session_start();
//error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
  include "../../../config/conn.php";
  include "../../../config/library.php";
  include "../../../config/fungsi_tanggal.php";

  $module=$_GET['module'];
  $act=$_GET['act'];

if ($module=='payment' AND $act=='inputform')
{


$id_pasien=$_POST['id_pasien'];
 
?>

        <div class="card">

         <div class="card-header">
            <i class="icon-user"></i> Tambah Pembayaran
          </div>
         <div class="box-header">
         <br>
                          <div class="col-md-12 text-right">
                                
                                 <button class="btn btn-xs btn-success" id="payment_save">Simpan</button>
                                
                          </div>
              </div>




          <!-- Horizontal Form -->
            <!-- /.box-header -->
            <!-- form start -->
      <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="form_penawaran">

          <div class="card-block">
             <div class="row">
              <div class="col-md-7">


                 <div class="form-group row">
                  <label class="col-sm-3 nopadding">Unit Kasir</label>

                  <div class="col-sm-6 nopadding">
                 
                      <select name='unit_kasir' class='form-control' required>
                      
                      <option value='A'>Kasir</option>
                      <option value='K'>Konsultasi Billing</option>
                      <option value='C'>0&G</option>
                      
                      </select>
                            </div>
                          </div>
                
              </div>



                <div class="col-sm-5">
            
                <div class="form-group row">
                  <label class="col-sm-4">Pembayaran</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Test</option>
                      <option value='K'>Kadaluwarsa</option>
                      <option value='C'>Cancel</option>
                      
                      </select>
                  </div>
                          </div>
                  
                
          
                </div>
                </div>

                <div class="row">
              <div class="col-md-7">


                 <div class="form-group row">
                  <label  class="col-sm-3">Jumlah</label>

                  <div class="col-sm-6">                     
                      <input name='jumlah' class='form-control' required>
                      
                  </div>
                  </div>

                  <div class="form-group row">
                  <label  class="col-sm-3">Diterima</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>
                   <div class="form-group row">
                  <label  class="col-sm-3">Kembalian</label>

                  <div class="col-sm-6">                     
                      <input name='Kembalian' class='form-control' required>
                      
                  </div>
                  </div>
                  <div class="form-group row">
                  <label  class="col-sm-3"></label>
                  <div class="col-sm-1">                     
                      <input name='checkbox' type="checkbox" class='form-control' required>
                      
                  </div>
                  <label  class="col-sm-3">Bayar Panjar</label>
                  </div>

                

                      
              </div>



                <div class="col-sm-5">            
                
                  <div class="form-group row">
                            <label  class="col-sm-4">Tgl Pembayaran</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_pembayaran' class="date"  class='form-control' required>
                                
                            </div>
                  </div>
                  
         
                
          
                </div>
                </div>


                <div class="row">
              <div class="col-md-7">


                 <div class="form-group row">
                  <label  class="col-sm-3">Mode Pembayaran</label>

                  <div class="col-sm-6">                     
                     <select name='status' class='form-control' required>
                      
                      <option value='A'>Cash</option>
                      <option value='K'>Kartu Kredit</option>
                      <option value='C'>Cek</option>
                      
                      </select>
                      
                  </div>
                  </div>

                  <div class="form-group row">
                  <label  class="col-sm-3">Type </label>

                  <div class="col-sm-6">                     
                       <select name='status' class='form-control' required>
                      
                      <option value='A'>Cash</option>
                      <option value='K'>Kartu Kredit</option>
                      <option value='C'>Cek</option>
                      
                      </select>
                      
                  </div>
                  </div>
                  <div class="form-group row">
                  <label  class="col-sm-3">nomor</label>

                  <div class="col-sm-6">                     
                      <input name='nomor' class='form-control' required>
                      
                  </div>
                  </div>
                   <div class="form-group row">
                  <label  class="col-sm-3">Kode Approve</label>

                  <div class="col-sm-6">                     
                      <input name='kode_approve' class='form-control' required>
                      
                  </div>
                  </div>
                  <div class="form-group row">
                            <label  class="col-sm-3">Tgl Expired</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_expired' class="date"  class='form-control' required>
                                
                            </div>
                  </div>
                   
                

                      
              </div>



                <div class="col-sm-5">      

                
                  <div class="form-group row">
                            <label  class="col-sm-4">Tgl Pembayaran</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_pembayaran' class="date"  class='form-control' required>
                                
                            </div>
                  </div>

                   <div class="form-group row">
                  <label  class="col-sm-4">Bayar Utk </label>

                  <div class="col-sm-6">                     
                       <select name='status' class='form-control' required>
                      
                      <option value='A'>Beli Obat</option>
                      <option value='K'>Biaya Rawat Jalan</option>
                      <option value='C'>Panjar</option>
                      
                      </select>
                      
                  </div>
                  
         
                
          
                </div>
                <div class="form-group row">
                            <label  class="col-sm-4">Deskripsi</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_pembayaran' class="date"  class='form-control' required>
                                
                            </div>
                  </div>
                </div>

                </div>

              <!-- /.box-body -->
              </form>
               <div class="col-md-12 mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">List Invoice</a>
                                </li>
                        
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="list_invoice">


                           <table id="myTable" class="table ">
                            <thead>
                            <tr>
                            <th width="10px">No</th>
                              <th width="">Ditujukan ke</th>
                              <th width="">Tgl./Waktu</th>
                              <th width="">No Invoice</th>
                              <th width="">Invoice ke</th>
                              <th width="">Jumlah</th>
                              <th width="">Outstanding</th>
                              <th width="">Apply Jumlah</th>
                               <th></th>
                              
                            </tr>
                            </thead>
                            <tbody>
                         <?php
                             $no = 0;
                             $res=pg_query($dbconn,"Select q_ln_temp.*, inv_satuan.nama  as  \"nama_satuan\" from q_ln_temp                 
                            INNER JOIN inv_satuan on inv_satuan.id=q_ln_temp.id_satuan 
                            WHERE q_ln_temp.id_user='".$_SESSION['id_users']."'");

                             $totalgross = 0;
                             $totalnet = 0;

                             while ($row=pg_fetch_assoc($res)) {

                              $totalgross += $row["gross_total"];
                              $totalnet += $row["net_total"];
                              $no++;

                                 ?>
                                   <tr>
                                    <td style="vertical-align:middle;"><?php echo $no ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row["jumlah"] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row["harga_unit"] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row["disc_amount"] ?></td>
                                    <td style="vertical-align:middle;"><?php echo number_format($row["gross_total"],0,',','.') ?></td>
                                    <td style="vertical-align:middle;"><?php echo number_format($row["net_total"],0,',','.') ?></td>
                             <td class="text-center" style="vertical-align:middle;">
                                        <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_qlist"><i class="icon-note"></i></a>
                                        <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_quotation"><i class="icon-trash"></i></a>
                                    </td>
                                   
                                    </tr>             
                             <?php } ?> 
                            </tbody>
                          </table>

                                <div class="col-md-12 text-right">
                                    <div class="form-horizontal ">  
                                        <div class="form-group row" >
                                          <label for="jm" class="col-sm-8 ">Gross Total</label>
                                           <div class="col-sm-4">
                                              <input type="text" name="tanggal_lahir" value="<?php echo  number_format($totalgross,0,',','.') ?>" placeholder="0" class="form-control text-right" readonly>
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label  class="col-sm-8">Net Total</label>
                                          <div class="col-sm-4">                     
                                              <input name="kode" class="form-control text-right" value="<?php echo  number_format($totalnet,0,',','.') ?>" placeholder="0" readonly>                    
                                          </div>
                                          </div>
                                     </div>  
                              </div>
                          
                                  </div>
                                </div>
                
                            </div>
                        </div>


              

        </div>

<?php
}



}?>

  <script >
   $(document).ready(function(){
  $(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});

      </script>