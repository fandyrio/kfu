<?php
if(isset($_POST['simpan'])){

    $id_level = $_POST['id_level'];
    $tambah = "('".implode("','",array_values($_POST['tambah']))."')";
    $edit = "('".implode("','",array_values($_POST['edit']))."')";
    $hapus = "('".implode("','",array_values($_POST['hapus']))."')";
    $lihat = "('".implode("','",array_values($_POST['lihat']))."')";

    $post = 'ARRAY['. implode(',', $_POST['id_modul']). ']';

    $cek = pg_query($dbauth, "SELECT * FROM akses WHERE id_level ='".$id_level."'");
    $jumlah = pg_num_rows($cek);
    if(pg_num_rows($cek>0))
    {     
    }else{
      $sql =pg_query($dbauth, "INSERT INTO akses(id_level, id_modul) 
                          SELECT $id_level id, x
                          FROM unnest($post) x");
      $result =pg_query($dbauth, "UPDATE akses SET tambah='1' WHERE id_modul in $tambah AND id_level='".$id_level."'");
      $edit =pg_query($dbauth, "UPDATE akses SET edit='1' WHERE id_modul in $edit AND id_level='".$id_level."'");
      $hapus =pg_query($dbauth, "UPDATE akses SET hapus='1' WHERE id_modul in $hapus AND id_level='".$id_level."'");
      $lihat =pg_query($dbauth, "UPDATE akses SET lihat='1' WHERE id_modul in $lihat AND id_level='".$id_level."'");

    }
    /**/
  }
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
       Tambah Modul Akses
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
        <form enctype="multipart/form-data" method="post">
            <div class="box-header">
            </div>

            <div class="form-group col-xs-10 ">
                    <label for="jm">Pilih Level</label>
                        <?php 
                      $result =pg_query($dbauth, "SELECT * FROM level");
                     
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
            <div class="box-body">
              <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                
                  <th >Modul</th>
                  <th ><input type="checkbox" name="select-tambah" id="select-tambah" /> Tambah</th>
                  <th ><input type="checkbox" name="select-edit" id="select-edit" /> Edit</th>
                  <th ><input type="checkbox" name="select-hapus" id="select-hapus" /> Hapus</th>
                  <th ><input type="checkbox" name="select-lihat" id="select-lihat" /> Lihat</th>

                </tr>
                </thead>
                <tbody>
             <?php
             echo $tambah;
             echo $edit;
             echo $hapus;
                 $res=pg_query($dbauth,"Select * from modul");
                 while ($row=pg_fetch_assoc($res)) {

                     ?>
                       <tr>
                       <input type="hidden" name="id_modul[]" value="<?php echo $row['id'] ?>"> 
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                         <td style="vertical-align:middle;"><input type="checkbox" class="tambah" value="<?php echo $row['id'] ?>" name="tambah[]" /></td>
                         <td style="vertical-align:middle;"><input type="checkbox" class="edit" value="<?php echo $row['id'] ?>" name="edit[]" /></td>
                         <td style="vertical-align:middle;"><input type="checkbox" class="hapus" value="<?php echo $row['id'] ?>" name="hapus[]" /></td>
                         <td style="vertical-align:middle;"><input type="checkbox" class="lihat" value="<?php echo $row['id'] ?>" name="lihat[]" /></td>                  
                        </tr>              
                 <?php }
                  ?>
                </tbody>
               
              </table>
              <button type="submit" name="simpan" class="btn btn-success btn-flat">SIMPAN</button>
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
