<?php
	$id=$_GET['id'];
  $unit = $_SESSION['id_unit'];
  $res=pg_fetch_array(pg_query($dbconn,"Select * from commision_group_harga_unit where id_commision_group='$id' and id_unit='$unit' order by id_commision_group asc"));
?>	  
     <div class="card-header">
          <h3 class="h4">Update Commision </h3>
      </div>     
           <div class="card-body"> 
          <form class="form-horizontal" method="post" action="media.php?content=commision_group&modul=simpan&act=edit">  

                  <div class="form-group row">
                   <label class="col-sm-3 ">Commision</label>
                   <div class="col-sm-8">
                        <?php 
                      $row =pg_fetch_array( pg_query($dbconn, "SELECT * FROM commision_group where id='".$res["id_commision_group"]."'"));
                     
                      ?>
                     <input value="<?php echo $row["id"]?>" type="hidden" name="id_commision">
                     <input value="<?php echo $row["nama"]?>" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="form-group row">
                   <label class="col-sm-3 ">Tindakan</label>
                   <div class="col-sm-8">
                        <?php 
                      $row =pg_fetch_array( pg_query($dbconn, "SELECT * FROM tindakan where id='".$res["id_tindakan_unit"]."'"));
                     
                      ?>
                     <input value="<?php echo $row["id"]?>" type="hidden" name="id_tindakan">
                     <input value="<?php echo $row["nama"]?>" class="form-control" readonly>
                      </div>
                  </div>

                  <div class="form-group row">
                   <label class="col-sm-3 ">Dokter</label>
                   <div class="col-sm-8">
                        <?php 
                      $row =pg_fetch_array( pg_query($dbconn, "SELECT * FROM master_karyawan where id='".$res["id_karyawan_unit"]."'"));
                     
                      ?>
                     <input value="<?php echo $row["id"]?>" type="hidden" name="id_karyawan">
                     <input value="<?php echo $row["nama"]?>" class="form-control" readonly>
                      </div>
                  </div>


          
                 <table id="example2" class="table table-sm ">
                        <thead >
                        <b>Kategori Harga</b>
                        </thead>
                        <tr class="table-success">
                        <th></th>
                          <th>Nama</th>
                          <th>Harga</th>
                        </tr>
                        <tbody>
                     <?php
                     $unit = $_SESSION['id_unit'];
                     $find_harga=pg_query($dbconn,"Select * from master_unit_perusahaan where id_unit='$unit' order by id_perusahaan asc");
                                    
                       while ($data_harga=pg_fetch_assoc($find_harga)) {

                             $data=pg_fetch_array(pg_query($dbconn,"Select * from master_kategori_harga 
                                      where id = '".$data_harga["id_perusahaan"]."'"));

                             $res=pg_query($dbconn,"Select id_commision_group, harga, id_kategori_harga_unit from commision_group_harga_unit where id_commision_group='".$id."' 
                                  and id_kategori_harga_unit ='".$data_harga['id_perusahaan']."' and id_unit='$unit' ");
                              
                               $row=pg_fetch_assoc($res);
                                   
                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" 
                                  value="<?php echo $data_harga['id_perusahaan'] ?>"
                                  name="id_layanan[]"  
                                   <?php
                                   if($data_harga['id_perusahaan']==$row['id_kategori_harga_unit']){ echo "checked";    }
                                   ?>
                                 />
                               </td>
                                <td style="vertical-align:middle;"><?php echo $data["nama"] ?></td>
                                <td>
                                <input type="text" name="harga[]" placeholder="Rp" value="<?php
                                   if($row['harga'])
                                    { echo $row['harga'];  
                                      }
                                   ?>"
                                 <?php
                                   if(!$row['harga'])
                                    { echo  "disabled" ;
                                      }
                                   ?>
                                   />
                                </td>
                           
                               
                                </tr>
                            
                         
                         <?php 
                        
                      }
                         ?> 
                        </tbody>
                        <tfoot>
                    
                        </tfoot>

                      </table>
                      <br>
                  <button type="submit" class="btn btn-sm btn-primary ">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-sm btn-warning " onClick="window.location='media.php?content=commision_group';" >BATAL</button>
                 
                  </form>
                  </div>

                
         






