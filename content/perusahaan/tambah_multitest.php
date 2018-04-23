<form method="post" enctype="multipart/form-data" action="media.php?perusahaan=analysis_group&modul=simpan&act=baru">
	<div class="card-header d-flex align-items-center">
		Tambah
	</div>
	<div class="card-body">
		<div class="form-group row">
			<b>Pilih Multitest</b>
         <table id="myTable10" class="table table-sm example2" >
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
                            FROM    lab_analysis_group m
                            WHERE   NOT EXISTS
                                    (
                                    SELECT  null 
                                    FROM    lab_analysis_group_unit d
                                    WHERE   d.id_lab_analysis_group = m.id and d.id_unit='$id_unit' 
                                    and d.id_kategori_harga='$_SESSION[id_perusahaan]'
                                    ) ");

                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td ><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_multi[]" /></td>
                                <td ><?php echo $row["nama"] ?></td>
                                 <td ><?php echo number_format($row["harga_modal"],'0','','.') ?></td>
                                <td>
                                <input type="text" name="harga_multi[]" value="<?php echo $row[harga_modal] ?>" placeholder="Rp" disabled /></td>
                           
                               
                                </tr>
                            
                         
                         <?php } ?> 
                        </tbody>
                        <tfoot>
                    
                        </tfoot>

                      </table>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-primary btn-flat" id="btnTambahMulti">SIMPAN</button>
	</div>
</form>		   


          
        
          
        