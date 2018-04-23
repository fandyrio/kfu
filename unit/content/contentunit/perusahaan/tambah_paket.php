
<form method="post" class="form-horizontal" action="media.php?content=perusahaan&modul=simpan_paket&act=baru">
	<input type="hidden" name="id_perusahaan" value="<?php echo $id_perusahaan; ?>">
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
				<select name='id_billing_paket' id='id_billing_paket' class='form-control '  >
					<?php 
					while ($row =pg_fetch_assoc($result)){
						echo "<option value='".$row['id']."'>".$row['nama_paket']."</option>";
					}
					?>
				</select>
			</div>
		</div>
			
			<div id="paket_detail" class="col-sm-12">
				
			</div>
	</div>
	<div class="card-footer">
		<button id="tambah_paket" type="button" name="simpan" class="btn btn-sm btn-primary btn-flat">SIMPAN</button>
	</div>
</form>