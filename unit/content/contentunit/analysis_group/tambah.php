<form method="post" enctype="multipart/form-data" action="media.php?content=analysis_group&modul=simpan&act=baru">
	<div class="card-header d-flex align-items-center">
		<h3 class="h4">Tambah</h3>
	</div>
	<div class="card-body">
		<div class="form-group row">
			<label class="col-sm-12 control-label">Analysis Group</label>
			<div class="col-sm-12">
				<?php 
				$id_unit= $_SESSION['id_unit']; 
				 $result =pg_query($dbconn, "SELECT  *
					FROM    lab_analysis_group m
					WHERE   NOT EXISTS
					        (
					        SELECT  null 
					        FROM    lab_analysis_group_unit d 
					        WHERE   d.id_lab_analysis_group= m.id and d.id_unit='$id_unit'
					        )");
				?>
				<select name='id_lab[]' class='form-control select2' multiple="multiple" >
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
		<button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
	</div>
</form>		   


          
        
          
        