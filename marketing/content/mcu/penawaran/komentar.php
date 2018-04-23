<div class="modal-dialog modal-md modal-success">
				<div class="modal-content">
				<form id="form_add_komentar">
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Tambah Komentar</h6>
					</div>
					<div class="modal-body" id="form-data">
						<input type="hidden" name="id_paket" id="id_paket" value="<?php echo $_POST['id']?>">
						
									
					
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" id="catatan" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanKomentar">Simpan</button>
				</div>
				</form>
			</div>
		</div>

		<script type="text/javascript">

	
	
	$('#btnSimpanKomentar').click(function()
	{
		
		var id=$('#id_paket').val();
		var catatan=$('#catatan').val();
		//alert(id);
		$.ajax({
			type: 'POST',
			url: 'media.php?content=mcu&modul=simpan&act=kirim',
			data : {id:id,catatan:catatan},
			success: function(msg){
				$("#form-modal2").modal('hide'); 	
				document.location.href = "mcu-penawaran";
			}
		});
		
	});
</script>