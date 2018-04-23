<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";
	
?>
	<div class="modal-dialog modal-md modal-success">
		<form id="keluhan">
		<input type="hidden" name="id_pasien" value="<?php echo $_POST['id_pasien'];?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $_POST['id_kunjungan'];?>" id="id_kunjungan">
		<input type="hidden" name="rm" value="<?php echo $_POST['rm'];?>" id="rm">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">Tambah Tindak Lanjut</h6>
				</div>
				<div class="modal-body" id="form-data">
				<div class="card-body">
					<div class="form-group">
						<input type="checkbox" name="terkontrol" >
   							 Terkontrol
					</div>

					<div class="form-group">
						<input type="checkbox" name="dirujuk" id='dirujuk'>
   							 Dirujuk
					</div>

					<div class="form-group" id="rs" style="display:none;">
						<label>Rumah Sakit Rujukan</label>
						<input type='hidden' name='rujukan_id' class="form-control" id="rujukan_id" value='0'>
						<input type='text' class="form-control" id="rujukan_nama">
						<div id="rs_rujukan" style='border:1px;'>
							
						</div>
						
					</div>

					<div class="form-group">
						<label>Penanganan Tingkat Lanjut</label>
						<select name="id_tindak_lanjut" class="form-control" id="id_body" autofocus required>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_tindak_lanjut ORDER BY id");
								echo "<option value=0>Pilih</option>";
							while($r=pg_fetch_array($tampil)){
								echo"<option value='$r[id]'>$r[nama]</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<input type="checkbox" name="meninggal" >
   							 Meninggal Dunia
					</div>					
				</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanKeluhan">Simpan</button>
				</div>
			</div>
			</form>
		</div>
		<!--select2-->
	<script src="assets/js/select2.full.js"></script>
		<script type="text/javascript">


	$('#btnSimpanKeluhan').click(function()
		{
			
			var form = $('#keluhan').serialize();
			var rm = $('#rm').val();
			$.ajax({
				type: "POST",
				url: "content/pasien/tindak_lanjut/simpan.php",
				data: form,
				cache: false,
				beforeSend: function(){ $("#btnSimpanKeluhan").val('Submitting...');},
				success: function(data){
					//alert(data);
					$('#form-modal2').modal('toggle');
					$("#data_pasien").load('content/pasien/tindak_lanjut/pasien_tindak_lanjut.php?id='+rm);
				}
			});
		});

	$(document).ready(function(){
		$('.js-example-basic-single').select2();

    $('#dirujuk').on('click',function () {
        if ($("#dirujuk").is(':checked')) 
        {
            $("#rs").show();
        }
        else 
        {
    	    $("#rs").hide();
 	    }
    	});
		$("#rujukan_nama").keyup(function()
		{
			var data=$("#rujukan_nama").val();
			$.ajax(
			{
				url:'content/pasien//tindak_lanjut/getRs.php',
				type:'POST',
				data:{rs:data},
				success:function(result)
				{
					$("#rs_rujukan").html(result).show();
				},
				error:function()
				{
					alert("error");
				}
			});
		});
	});
		</script>
<?php
} 
?>