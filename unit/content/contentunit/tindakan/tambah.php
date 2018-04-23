           
           
           <form class="form-horizontal" method="post" action="media.php?content=tindakan&modul=simpan&act=baru">  

            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Tambah </h3>
            </div>
            <div class="card-body">
                  <div class="form-group row">
                   <label class="col-sm-3 control-label">Tindakan</label>
                   <div class="col-sm-8">
                        <?php
                        $id_unit= $_SESSION['id_unit'];  
                     $result =pg_query($dbconn, "SELECT  *
                                      FROM    tindakan m
                                      WHERE   NOT EXISTS
                                              (
                                              SELECT  null 
                                              FROM    tindakan_kategori_harga_unit d
                                              WHERE   d.id_tindakan = m.id and d.id_unit='$id_unit'
                                              ) ");
                     
                      ?>
                      <select name='id_tindakan' class='form-control' required>
                      
                      <option value=''>Pilih Tindakan</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                      </div>
                  </div>


          
          <table id="example2" class="table table-sm">
                        <thead>
                        <b>Kategori Harga</b>
                        </thead>
                        <tr class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th>Price</th>
                        </tr>
                        <tbody>
                     <?php

                         $unit = $_SESSION['id_unit'];
                         $res=pg_query($dbconn,"Select * from master_unit_perusahaan where id_unit='$unit' order by id_perusahaan asc");

                         while ($row=pg_fetch_assoc($res)) {

                           $data=pg_fetch_array(pg_query($dbconn,"Select * from master_kategori_harga where id = '".$row["id_perusahaan"]."'"));

                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id_perusahaan'] ?>"  name="id_layanan[]"  /></td>
                                <td style="vertical-align:middle;"><?php echo $data["nama"] ?></td>
                                <td>
                                <input type="text" name="harga[]" placeholder="Rp" disabled /></td>
                           
                               
                                </tr>
                            
                         
                         <?php } ?> 
                        </tbody>
                        <tfoot>
                    
                        </tfoot>

                      </table>
                      <br>

                  </div>
                  <div class="card-footer">
                        <button type="submit"  class="btn btn-sm btn-primary " >SIMPAN</button>
                        </div>
                  </form>

                
         

