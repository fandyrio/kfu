  
  <?php 

    error_reporting(0);
    $id= 0;
    if($_GET['id']){
      $id=$_GET['id'];
      $_SESSION['id_trf_ln'] =$id;

    }else $_SESSION['id_trf_ln']=0;
    if($_GET['nama']){
        $_SESSION['nama_brand_trf']= $_GET['nama'];
    }
                       
 ?>
           <div class="form-group row">
          <!--  <div class="col-sm-2">
                <button  id="add_trf_ln" class="btn btn-xs btn-primary">Select all batch</button>
                </div>   -->      
          <div class="col-sm-6">
                <input name='terms' value="<?php echo $_SESSION['nama_brand_trf']; ?>" class='form-control' id="batch_nama" readonly> 
                </div>
            </div>
                  <table  class="table ">
                      <thead class="table-secondary">
                      <tr>
                      <th width="10px">No</th>
                        <th >Batch No</th>
                        <th >QTY</th>
                        <th >Satuan</th>
                        <th>Manufacture</th>
                        <th >Tgl. Expire</th>
                        <th>Remark</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;

                  
                       $res=pg_query($dbconn,"Select stok_trf_batch.*, inv_satuan.nama  as  \"nama_satuan\" from stok_trf_batch
                       INNER JOIN inv_satuan on inv_satuan.id=stok_trf_batch.id_satuan WHERE stok_trf_batch.id_ln='".$_SESSION['id_trf_ln']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						            //$jum +=;
						            $totalgross += $row["gross_total"];
                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["no_batch"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["tgl_manufac"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["tgl_expired"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["catatan"] ?></td>
                             <!--  <td class="text-center" style="vertical-align:middle;">
                                         
                              <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_trf_batch_ln"><i class="icon-trash"></i></a>
                            </td> -->
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>



			
			