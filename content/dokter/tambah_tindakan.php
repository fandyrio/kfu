<form method="post" enctype="multipart/form-data" id="lab_tindakan">
    <input id="id_perusahaan" type="hidden" value="<?php echo $_GET["id"] ?>">
  <div class="card-header d-flex align-items-center">
    Tambah 
  </div>
    <div class="card-body">
    
        <b>Pilih Tindakan</b>
         <table id="myTable11"  class="table table-sm example1" >
                        <thead class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th>Harga Jual</th>
                          <th>Harga</th>
                          <th>Persen dokter %</th>
                          <th>Persen Perawat %</th>
                        </thead>
                        <tbody>
                     <?php

                        $id_unit= $_SESSION['id_units'];  
                        $res =pg_query($dbconn, "SELECT  *
                                      FROM    tindakan m
                                      WHERE   NOT EXISTS
                                              (
                                              SELECT  null 
                                              FROM    tindakan_dokter_unit d
                                              WHERE   d.id_tindakan = m.id and d.id_unit='$id_unit' 
                                              and d.id_karyawan='$_SESSION[id_dokter]'
                                              ) and id_poly = '$_GET[poly_id]' ");

                                               
                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_tindakan[]" /></td>
                                <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                                <td style="vertical-align:middle;"><?php echo number_format($row["total"],'0','','.') ?></td>
                                <td style="vertical-align:middle;"> <input type="text" style="width:60px" name="harga[]"  value="<?php echo $row[total] ?>" disabled /></td>
                                <td>
                                <input type="text" style="width:60px" name="persen_dokter[]" value="0" placeholder="%" disabled />
                                </td>

                                <td>
                                <input type="text" style="width:60px" name="persen_perawat[]" value="0" placeholder="%" disabled /></td>
                           
                               
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


          
        
          
        