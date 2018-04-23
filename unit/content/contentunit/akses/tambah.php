 <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Tambah Akses </h3>
                    </div>
  <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="media.php?content=akses&modul=simpan&act=baru">
        
            <div class="form-group row col-xs-10 ">
                    <label for="jm">Pilih Level</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM auth_level where id <4");
                     
                      ?>
                      <select name='id_level' class='form-control' required>
                      
                      <option value=''>Pilih Level</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
            </div>
            <!-- /.box-header -->
            <b>Pilih Menu</b>
            <div class="box-body" >

              <table  class="table">
                <thead class="table-success">               
                  <th >Menu</th>
                  <th ><input type="checkbox" name="select-tambah" id="select-tambah" /> Tambah</th>
                  </thead>
                <tbody >
                <?php
                 $res=pg_query($dbconn,"Select * from auth_menu order by id asc");
                 while ($row=pg_fetch_assoc($res)) {

                     ?>
                       <tr>
                       <input type="hidden" name="id_modul[]" value="<?php echo $row['id'] ?>"> 
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                         <td style="vertical-align:middle;"><input type="checkbox" class="tambah" value="<?php echo $row['id'] ?>" name="id_menu[]" /></td>
                                       
                        </tr>              
                 <?php }
                  ?>
                </tbody>
                <tfoot>
              
                </tfoot>

              </table>
              <button type="submit" name="simpan" class="btn btn-primary btn-flat">SIMPAN</button>
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>
      </div>
      <!-- /.row -->
    
  <!-- /.content-wrapper -->
