<?php 
error_reporting(0);
$id= 0;
if($_GET['id']){
  $id=$_GET['id'];
  $_SESSION['id_grn_ln_temp'] =$id;

}else $_SESSION['id_grn_ln_temp']=0;
if($_GET['nama']){
    $_SESSION['nama_brand_grn']= $_GET['nama'];
}
if($_GET['nama']){
    $_SESSION['id_satuan']= $_GET['id_satuan'];
}
if($_GET['nama_satuan']){
    $_SESSION['nama_satuan']= $_GET['nama_satuan'];
}


?>
                  <div class="form-group">
                  <div class="col-sm-6">
                   <button  id="add_grn_batch_update" class="btn-xs btn-primary">Tambah</button>
                 </div>
                  <div class="col-sm-6">
                    <input value="<?php echo $_SESSION['nama_brand_grn']; ?>" name="nama_b" readonly type="text" class="form-control">                   
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
                        <th width="">Tgl. Manufacture</th>
                        <th width="">Tgl. Expired</th>
                        <th width="">Remark</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $jum = 0;
                       $query="Select grn_batch.*, inv_satuan.nama  as  \"nama_satuan\"from grn_batch
                       INNER JOIN inv_satuan on inv_satuan.id=grn_batch.id_satuan WHERE grn_batch.id_grn_ln='".$_SESSION['id_grn_ln_temp']."'";
                       $res=pg_query($dbconn,$query);
                       //var_dump($query);

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["no_batch"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["manufacdate"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["expired_date"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["catatan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        
                             <td class="text-center" style="vertical-align:middle;">
                            <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_grn_ln_update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_batch_ln_update"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
              </td>
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>
			
			