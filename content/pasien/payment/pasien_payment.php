 <?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
if($d['jenkel']==1){
  $jenkel="<i class='icon-symbol-male'></i>";
}
else{
  $jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
  $foto="images/pasien/upload_$d[foto]";
}
else{
  $foto="images/default.png";
}

$id_pasien=$d['id'];
?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
          <div class="card">
            <div class="card-header">
              <i class="icon-grid"></i>Keuangan
            </div>

                  <div class="col-md-12 text-left">
                   <button type="button" class="btn btn-primary btn-xs btnTambahpay"><span class="fa fa-clone"></span>Tambah</button>  
                
                </div>
            <!-- /.box-header -->
            <div class="card-block">
              <table id="myTable" class="table">
                <thead>
                <tr>
                <th width="5" >No</th>
                  <th >Tanggal</th>
                  <th >Penerimaan</th>
                  <th >Supplier</th>
                  <th >Dibayar Oleh</th>
                   <th >Jenis Pembayaran</th>
                   <th >Jumlah</th>
                   <th >Digunakan</th>
                   <th >Balance</th>
                    <th>Refund</th>
                    <th>Kasir</th>

                   <th ></th>
                  
                </tr>
                </thead>
                <tbody>
              <?php
                 $res=pg_query($dbconn,"Select q_hdr.*, inv_info_supplier.nama as \"nama_supplier\", auth_users.username \"nama_admin\", q_ln.jumlah,q_ln.nama_brand, inv_satuan.nama as \"nama_satuan\",q_ln.harga_unit from q_hdr
                   INNER JOIN inv_info_supplier on inv_info_supplier.id= q_hdr.id_supplier
                   INNER JOIN auth_users on auth_users.id_users= q_hdr.createdby
                   INNER JOIN q_ln on q_ln.id_hdr= q_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = q_ln.id_satuan");

                 $no=1;
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        
                       <td style="vertical-align:middle;"><?php echo $no++ ?></td>
                       <td style="vertical-align:middle;"><?php echo $row['no_dok'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['tgl_dok'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                         <td style="vertical-align:middle;"><?php echo $row['harga_unit'] ?></td>
                          <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                         <td style="vertical-align:middle;"><?php echo $row['harga_unit'] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=pembayaran&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><i class="icon-note"></i></a>
                            <a href="media.php?inventori=pembayaran&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
               

              </table>
          
            </div>
            <!-- /.box-body -->
          <!-- /.box -->


        </div>
 
 <script>   
  $('.btnTambahpay').click(function()
  {
    var id_pasien=$("#id_pasien").val();
    var dataString2 = 'id_pasien='+id_pasien;
    alert("woi");
    $.ajax({
      type: 'POST',
      url: 'form-tambah-pasien-payment',
      data: dataString2,
      cache: false,
      success: function(msg){
       
        $("#data_pasien").html(msg);
      }
    });
    
  });
 </script>