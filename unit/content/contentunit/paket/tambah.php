
<form method="post" class="form-horizontal" action="media.php?content=paket&modul=simpan&act=baru">
	<input type="text" name="id_perusahaan" value="<?php  ?>">
	<div class="card-header d-flex align-items-center">
		<h3 class="h4">Tambah</h3>
	</div>
	<div class="card-body">
		<div class="form-group row">
			<label class="col-sm-3 control-label">Billing Paket</label>
			<div class="col-sm-9">
				<?php
				$id_unit= $_SESSION['id_unit']; 
				$result =pg_query($dbconn, "SELECT  *
					FROM    billing_paket m
					WHERE   NOT EXISTS
					        (
					        SELECT  null 
					        FROM    billing_paket_kategori_harga_unit d
					        WHERE   d.id_billing_paket = m.id and d.id_unit='$id_unit'
					        ) ");
				
				?>
				<select name='id_billing_paket' class='form-control '  >
					<?php 
					while ($row =pg_fetch_assoc($result)){
						echo "<option value='".$row['id']."'>".$row['nama_paket']."</option>";
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-12 control-label">Kategori Harga</label>
			<div class="col-sm-12">
				<table id="myTable" class="table table-sm example2">
                   <thead>
                        <tr class="table-success">
                          <th></th>
                          <th>Kategori</th>
                          <th>Harga</th>
                        </tr>
					</thead>
                    <tbody>
                    <?php
                           $unit = $_SESSION['id_unit'];
                         $res=pg_query($dbconn,"Select * from lab_analysis order by id asc");

                         while ($row=pg_fetch_assoc($res)) {


                             ?>
                               <tr>
                                <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_lab[]"  /></td>
                                <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                                <td>
                                <input type="text" name="harga[]" placeholder="Rp" disabled /></td>
                           
                               
                                </tr>
                            
                         <?php 
						} 
						?> 
                    </tbody>
                </table>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" name="simpan" class="btn btn-sm btn-primary btn-flat">SIMPAN</button>
	</div>
</form>