<?php
	include "../../config/conn.php";
	?>
	
 <form id="tambahpartai" action="aksi-tambah-partai" method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="title-form">Tambah</h4>
				</div>
				<div class="modal-body" id="form-data">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">Nama Partai</label>
								<input type="text" class="form-control" autofocus required name="nama">
								<span class="material-input"></span>
							</div>
						</div>
						
						<!---<div class="col-sm-4">
							<div class="form-group label-floating is-empty">
								<label class="control-label">Urutan</label>
								<input type="number" class="form-control" required name="urutan">
								<span class="material-input"></span>
							</div>
						</div>
						-->
					</div>
				</div>
				<div class="modal-footer">
					<hr>
					<input type="submit" class="btn btn-success btn-sm" value="Simpan" id="btnSimpan"/>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</form>
	<?php
	pg_close($dbconn);
?>