<form method="post" enctype="multipart/form-data" action="media.php?content=analysis&modul=simpan&act=baru">
	<div class="card-header d-flex align-items-center">
	  <h3 class="h4">Tambah </h3>
	</div>
    <div class="card-body">
		<div class="form-group row">
            <label class="col-sm-12 control-label">Perusahaan</label>
			<div class="col-sm-12">
				<?php 
				  $id_unit= $_SESSION['id_unit'];  
				  $result =pg_query($dbconn, "SELECT  *
					FROM    master_unit_perusahaan m
					WHERE   NOT EXISTS
					        (
					        SELECT  null 
					        FROM    lab_analysis_kategori_harga_unit d
					        WHERE   d.id_kategori_harga= m.id_perusahaan and d.id_unit='$id_unit'
					        ) AND m.id_unit='$id_unit'");
		 
				  ?>
				  <select name='id_kategori_harga' class='form-control'>
				  
				  <?php 
				  while ($row =pg_fetch_assoc($result)){

				  	$data = pg_fetch_array(pg_query($dbconn, "SELECT  * FROM  master_kategori_harga m
					WHERE   m.id='$row[id_perusahaan]'"));

					echo "<option value='".$row['id_perusahaan']."'>".$data['nama']."</option>";
				  }
				?>
				  </select>
            </div>
        </div>


        <b>Pilih Analysis</b>
         <table id="myTable" class="table table-sm example2" >
                        <thead class="table-success">
                          <th></th>
                          <th>Nama</th>
                          <th>Price</th>
                        </thead>
                        <tbody>
                     <?php

                         $unit = $_SESSION['id_unit'];
                         $res=pg_query($dbconn,"Select * from lab_analysis order by id asc");

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
		<button type="submit" name="simpan" class="btn btn-primary btn-flat">SIMPAN</button>
    </div>
</form>     


          
        
          
        