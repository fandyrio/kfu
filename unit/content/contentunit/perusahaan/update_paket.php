<?php
  $id=$_GET['id'];
?>    
<form class="form-horizontal" method="post" action="media.php?content=paket&modul=simpan&act=edit">  
	<div class="card-header d-flex align-items-center">
		<h3 class="h4">Edit </h3>
	</div>
	<div class="card-body">
		<div class="form-group row">
			<label class="col-sm-3 ">Tindakan</label>
			<div class="col-sm-9">
				<?php 
				$row =pg_fetch_array( pg_query($dbconn, "SELECT * FROM billing_paket where id='$id'"));
				?>
				<input value="<?php echo $row["id"]?>" type="hidden" name="id_billing_paket">
				<input value="<?php echo $row["nama_paket"]?>" class="form-control" readonly>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-12 control-label">Kategori Harga</label>
			<div class="col-sm-12">
				<table id="example2" class="table table-sm">
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
                    $find_harga=pg_query($dbconn,"Select * from master_unit_perusahaan where id_unit='$unit' order by id_perusahaan asc");
                                    
                 while ($data_harga=pg_fetch_assoc($find_harga)) {

                       $row=pg_fetch_array(pg_query($dbconn,"Select * from master_kategori_harga where id = '".$data_harga["id_perusahaan"]."'"));

                         $q=pg_query($dbconn,"Select id_billing_paket, harga, id_kategori_harga from billing_paket_kategori_harga_unit where id_billing_paket='".$id."' and id_kategori_harga ='".$row['id']."' ");
						$data=pg_fetch_assoc($q);

						?>
						<tr>
							<td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $data_harga['id_perusahaan'] ?>"  name="id_layanan[]"  
							  <?php
							   if($data_harga['id_perusahaan']==$data['id_kategori_harga']){ echo "checked";    }
							   ?>
							  />
							</td>
							<td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
							<td>
							<input type="text" name="harga[]" placeholder="Rp" 
							value="<?php
							   if($data['harga'])
								{ echo $data['harga'];  
								  }
							   ?>"
							 <?php
							   if(!$data['harga'])
								{ echo  "disabled" ;
								  }
							   ?> 
							/>
							</td>
						</tr>
					<?php 
						} 
					?> 
					</tbody>
					<tfoot>
				
					</tfoot>

				  </table>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
		
		 <button type="button" value="batal" class="btn btn-sm btn-warning " onClick="window.location='media.php?content=paket';" >BATAL</button>
	</div>
</form>