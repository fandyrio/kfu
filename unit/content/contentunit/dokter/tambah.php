<form method="post" enctype="multipart/form-data" action="media.php?content=dokter&modul=simpan&act=baru" class="form-horizontal">
	<div class="card-header d-flex align-items-center">
		<h3 class="h4">Tambah</h3>
	</div>
	<div class="card-body">
		<div class="form-group row">
			<label class="col-sm-12 control-label">Dokter</label>
			<div class="col-sm-12">
				<?php 
				$id_unit= $_SESSION['id_unit'];
				$result =pg_query($dbconn, "SELECT  *
					FROM    master_karyawan m
					WHERE   NOT EXISTS
					        (
					        SELECT  null 
					        FROM    master_karyawan_unit d
					        WHERE   d.id_karyawan = m.id and d.id_unit='$id_unit'
					        ) AND m.id_jabatan='1'");
				?>
				<select name='id_karyawan[]' class='form-control select2' multiple="multiple" >
				<?php 
				while ($row =pg_fetch_assoc($result)){
					echo "<option value='".$row['id']."'>".$row['nama']."</option>";
				}
				?>
				</select>
			</div>
		</div>  
	</div>	
	<div class="card-footer">
		<button type="submit" name="simpan" class="btn btn-sm btn-primary btn-flat">SIMPAN</button>
	</div>
</form>     


          
        
          
        