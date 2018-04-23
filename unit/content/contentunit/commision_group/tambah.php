     <div class="card-header">
          <h3 class="h4">Tambah Commision </h3>
      </div>     
           <div class="card-body">           
           <form class="form-horizontal" method="post" action="media.php?content=commision_group&modul=simpan&act=baru"> 

            <div class="form-group row">
                   <label class="col-sm-3 text-label">Commision</label>
                   <div class="col-sm-8">
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM commision_group");
                     
                      ?>
                      <select name='id_commision' class='form-control' required>
                      
                      <option value=''>Pilih Commision</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                      </div>
                  </div> 

                  <div class="form-group row">
                   <label class="col-sm-3 text-label">Tindakan</label>
                   <div class="col-sm-8">
                        <?php 
                      $unit = $_SESSION['id_unit'];
                      $res=pg_query($dbconn,"Select distinct id_tindakan from tindakan_kategori_harga_unit where id_unit='$unit' order by id_tindakan asc");
                      ?>
                      <select name='id_tindakan' class='form-control' required>
                      
                      <option value=''>Pilih Tindakan</option>
                      <?php 
                      while ($row=pg_fetch_assoc($res)) {
                          $data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
                        echo "<option value='".$row['id_tindakan']."'>".$data['nama']."</option>";
                      }
                      ?>
                      </select>
                      </div>
                  </div>
                   <div class="form-group row">
                   <label class="col-sm-3 text-label">Dokter</label>
                   <div class="col-sm-8">
                        <?php 
                      $id_unit= $_SESSION['id_unit'];
                      $res=pg_query($dbconn,"Select u.id, u.id_karyawan from master_karyawan_unit u inner join master_karyawan v on v.id = u.id_karyawan where u.id_unit='$id_unit' and v.id_jabatan = 1 ");
                      ?>
                      <select name='id_karyawan' class='form-control' required>
                      
                      <option value=''>Pilih Dokter</option>
                      <?php 
                      while ($row=pg_fetch_assoc($res)) {
                        $view=pg_fetch_assoc(pg_query($dbconn,"Select * from master_karyawan WHERE id='$row[id_karyawan]'"));
                   
                        echo "<option value='".$row['id_karyawan']."'>".$view['nama']."</option>";
                      }
                      ?>
                      </select>
                      </div>
                  </div>
         
              <table id="example2" class="table table-sm ">
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

                        <button type="submit"  class="btn btn-sm btn-primary " >SIMPAN</button>
                  </form>
                  </div>

                
         

