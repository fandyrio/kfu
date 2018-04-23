<?php

$id = $_GET['id'];
if(isset($_POST['update'])){ 


  }
?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
        <form enctype="multipart/form-data" method="post" action="media.php?content=akses&modul=simpan&act=edit"> 
         <?php


          $data = pg_fetch_array(pg_query($dbconn,"SELECT * FROM auth_level WHERE id = '".$id."'"));
                          ?>    
        <div class="box-body">
              <div class="form-group col-xs-8">
                  <label for="exampleInputEmail1">Level</label>
                  <input type="text" name="level" class="form-control" value="<?php echo $data['nama']?>" readonly>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table  class="table table-bordered ">
               <input type="hidden" name="id_lev" value="<?php echo $data['id'] ?>"> 
                <thead>
                <b>Pilih Menu</b>

                </thead>
                <tr>
                
                  <th >Modul</th>
                  <th ><input type="checkbox" name="select-tambah" id="select-tambah" /> Akses</th>
                 

                </tr>
                <tbody>
            <?php
            echo $id_level;
             $res=pg_query($dbconn,"Select * from auth_menu");

                 while ($row=pg_fetch_assoc($res)) {   

                 $menu=pg_fetch_array(pg_query($dbconn,"Select * from auth_akses_menu where id_level='".$id."' AND id_menu='".$row['id']."'"));           
                     ?>
                       <tr>
                      
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>

                      
                         <td style="vertical-align:middle;">

                          <?php
                          if($menu['id_menu'] == $row['id'])
                                          echo "<input type='checkbox' checked name='id_menu[]' value='".$row['id']."'>";
                                        
                                      else
                                              echo "<input type='checkbox'   name='id_menu[]' value='".$row['id']."'>";
                            ?>
                         </td>
              
                        </tr>              
                  <?php 
               }
                  ?>
                </tbody>
                <tfoot>
              
                </tfoot>

              </table>
               <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?content=akses';" >BATAL</button>
            </div>
            <!-- /.box-body -->
          <!-- /.box -->
          </div>
          </form>

        </div>
        <!-- /.col -->
      </div>
      </div>
      <!-- /.row -->
