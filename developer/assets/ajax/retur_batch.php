<?php 
error_reporting(0);
$id= 0;
if($_GET['id']){
  $id=$_GET['id'];
  $_SESSION['id_retur_ln_temp'] =$id;

}else $_SESSION['id_retur_ln_temp']=0;
if($_GET['nama']){
    $_SESSION['nama_brand_retur']= $_GET['nama'];
}
if($_GET['id_satuan']){
    $_SESSION['id_satuan']= $_GET['id_satuan'];
}
if($_GET['nama_satuan']){
    $_SESSION['nama_satuan']= $_GET['nama_satuan'];
}
?>                 
                 
                 <div class="form-group">
                  <div class="col-sm-6">
                   <button  id="add_retur_batch" class="btn-xs btn-primary">Pilih Batch</button>
                 </div>
                  <div class="col-sm-6">
                    <input value="<?php echo $_SESSION['nama_brand_retur']; ?>" name="nama_b" readonly type="text" class="form-control">                   
                    <input value="<?php echo $_SESSION['id_satuan']; ?>" name="nama_b" readonly type="hidden" class="form-control">
                    <input value="<?php echo $_SESSION['nama_satuan']; ?>" name="nama_b" readonly type="hidden" class="form-control">
                  </div>
                </div>
                  <table  class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">No. Batch</th>
                        <th width="">QTY</th>
                        <th width="">Satuan</th>                        
                        <th width="">Tgl. Expired</th>
                        <th width="">Remark</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $jum = 0;
                       $res=pg_query($dbconn,"Select retur_batch_temp.*,  inv_satuan.nama  as  \"nama_satuan\" from retur_batch_temp
                       INNER JOIN inv_satuan on inv_satuan.id=retur_batch_temp.id_satuan 
                       WHERE retur_batch_temp.id_users='".$_SESSION['id_users']."' and retur_batch_temp.id_retur_ln ='".$_SESSION['id_retur_ln_temp']."'");
                       

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["no_batch"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["tgl_expired"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["catatan"] ?></td>
                          <td class="text-center" style="vertical-align:middle;">
                               <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_retur_batch"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                               </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>
			
			