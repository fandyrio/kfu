<form method="post" enctype="multipart/form-data" id="lab_analysis">
	<div class="card-header d-flex align-items-center">
	  Tambah
	</div>
    <div class="card-body">
        <b>Pilih Analysis</b>
         <table id="myTable9" class="table table-sm example2" >
                        <thead class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th>Harga Modal</th>
                          <th width="40px">Price</th>
                        </thead>
                        <tbody>
                     <?php

                        $id_unit= $_SESSION['id_units'];
                        $res =pg_query($dbconn, "SELECT  *
                            FROM    lab_analysis m
                            WHERE   NOT EXISTS
                                    (
                                    SELECT  null 
                                    FROM    lab_analysis_kategori_harga_unit d
                                    WHERE   d.id_lab_analysis = m.id and d.id_unit='$id_unit' and d.id_kategori_harga='$_SESSION[id_perusahaan]'
                                    ) ");

                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td ><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_lab[]" /></td>
                                <td ><?php echo $row["nama"] ?></td>
                                <td ><?php echo number_format($row["harga_modal"],'0','','.') ?></td>
                                <td>
                                <input type="text" name="harga[]" value="<?php echo $row["harga_modal"] ?>" placeholder="Rp" disabled /></td>
                           
                               
                                </tr>
                            
                         
                         <?php } ?> 
                        </tbody>
                        <tfoot>
                    
                        </tfoot>

                      </table>
	</div>
    <div class="card-footer">
		<button type="button" class="btn btn-primary btn-flat" id="btnTambahlab"> SIMPAN</button>
    </div>
</form>     


          
        
          
        