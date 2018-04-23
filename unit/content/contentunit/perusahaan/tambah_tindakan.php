<form method="post" enctype="multipart/form-data" id="lab_tindakan">
    <input id="id_perusahaan" type="hidden" value="<?php echo $_GET["id"] ?>">
  <div class="card-header d-flex align-items-center">
    <h3 class="h4">Tambah </h3>
  </div>
    <div class="card-body">
        <b>Pilih Tindakan</b>
         <table  class="table table-sm example2" >
                        <thead class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th>Price</th>
                        </thead>
                        <tbody>
                     <?php

                        $id_unit= $_SESSION['id_unit'];  
                        $res =pg_query($dbconn, "SELECT  *
                                      FROM    tindakan m
                                      WHERE   NOT EXISTS
                                              (
                                              SELECT  null 
                                              FROM    tindakan_kategori_harga_unit d
                                              WHERE   d.id_tindakan = m.id and d.id_unit='$id_unit' 
                                              and d.id_kategori_harga='$_SESSION[id_perusahaan]'
                                              ) ");

                           
                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_tindakan[]" /></td>
                                <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                                <td>
                                <input type="text" name="harga_tindakan[]" placeholder="Rp" disabled /></td>
                           
                               
                                </tr>
                            
                         
                         <?php } ?> 
                        </tbody>
                        <tfoot>
                    
                        </tfoot>

                      </table>
  </div>
    <div class="card-footer">
    <button type="button" name="simpan" class="btn btn-sm btn-primary btn-flat" id="btnTambahTindakan"> SIMPAN</button>
    </div>
</form>     


          
        
          
        