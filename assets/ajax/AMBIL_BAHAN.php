<div class="modal-dialog modal-sm modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">Tambah</h6>
				</div>
				<div class="modal-body" id="form-data">
					<table id="myTable13" class="table table-sm">
										<thead class="table-secondary">
											<tr>
												<th></th>
												<th>Nama</th>
			                 					<th>Harga</th>
												
											</tr>
										</thead>
										<tbody>
										<?php var_dump($_POST) ?>
										</tbody>
										</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm btnClose" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanPerhatian">Simpan</button>
				</div>
			</div>
		</div>

