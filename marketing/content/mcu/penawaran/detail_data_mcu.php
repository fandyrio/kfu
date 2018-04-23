<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
  header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";

?>
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
                          echo "Multi ".$a['nama'];
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
                            <a href="media.php?content=mcu&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
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
<?php	
}
?>