<?php
	$id=$_GET['id'];
?>	  
     
           <form class="form-horizontal" method="post" action="media.php?content=tindakan&modul=simpan&act=edit"> 
           <div class="card-header d-flex align-items-center">
              <h3 class="h4">Edit</h3>
            </div>
            <div class="card-body"> 

                  <div class="form-group row">
                   <label class="col-sm-12 control-label">Tindakan</label>
                   <div class="col-sm-12">
                        <?php 
                      $row =pg_fetch_array( pg_query($dbconn, "SELECT * FROM tindakan where id='$id'"));
                     
                      ?>
                     <input value="<?php echo $row["id"]?>" type="hidden" name="id_tindakan">
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

                       $data=pg_fetch_array(pg_query($dbconn,"Select * from master_kategori_harga where id = '".$data_harga["id_perusahaan"]."'"));

                         $res=pg_query($dbconn,"Select id_tindakan, harga, id_kategori_harga from tindakan_kategori_harga_unit where id_tindakan='".$id."' and id_kategori_harga ='".$data_harga['id_perusahaan']."' ");
                    

                         $row=pg_fetch_assoc($res);
                          

                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" 
                                  value="<?php echo $data_harga['id_perusahaan'] ?>"
                                  name="id_layanan[]"  
                                   <?php
                                   if($data_harga['id_perusahaan']==$row['id_kategori_harga']){ echo "checked";    }
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
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary ">SIMPAN</button>
                      
                         <button type="button" value="batal" class="btn btn-sm btn-warning " onClick="window.location='media.php?content=tindakan';" >BATAL</button>
                      </div>   
                 
                  </form>
                  </div>

                
         






