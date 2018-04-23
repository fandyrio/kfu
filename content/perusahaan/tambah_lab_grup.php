<form method="post" enctype="multipart/form-data" id="lab_analysis">
	<div class="card-header d-flex align-items-center">
	  <h3 class="h4">Tambah </h3>
	</div>
    <div class="card-body">
        <b>Pilih Analysis Group</b>
         <table class="table table-sm example2" >
                        <thead class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th width="40px">Price</th>
                        </thead>
                        <tbody>
                     <?php

                        $id_unit= $_SESSION['id_units'];
                        $res =pg_query($dbconn, "SELECT  *
                            FROM    lab_analysis_group g
                            WHERE   NOT EXISTS
                                    (
                                    SELECT  null 
                                    FROM    lab_analysis_group_unit d
                                    WHERE   d.lab_analysis_group = g.id and d.id_unit='$id_unit' and d.id_kategori_harga='$_SESSION[id_perusahaan]'
                                    ) ");

                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_lab[]" /></td>
                                <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                                <td>
                                <input type="text" name="harga[]" placeholder="Rp" disabled /></td>
                           
                               
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


          
        
          
        