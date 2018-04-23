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
					<h6 class="modal-title" id="title-form">Tambah Keluhan</h6>
				</div>
				<div class="modal-body" id="form-data">
					<div class="form-group">
						<label>Body</label>

						<select name="id_body" class="form-control" id="id_body" autofocus required>
							<option value=''>Pilih</option>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_body ORDER BY id");
							while($r=pg_fetch_array($tampil)){
								echo"<option value='$r[id]'>$r[nama_body]</option>";
							}
							?>
						</select>
					</div>
					
					
					
					<div class="form-group" id="lokasi">
						<label>Lokasi </label>
						<select name="id_lokasi" class="form-control loc" id="id_lokasi"  >
						</select>
					</div>
					<div class="form-group" id="simptom"></div>
					<div class="form-group">
						<label>Merokok</label>
						<select name="rokok" class="form-control " id="rokok"  >
						<option value='NOT ASK'>PILIH</option>
						<option value='N'>Tidak</option>
						<option value='Y'>Ya</option>


						</select>
					</div>
					<div class="form-group">
						<label>Lama Keluhan</label>
						<input name="hari" id="hari" class="form-control col-md-3"> hari</input>
					</div>
					
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" id="catatan" class="form-control"></textarea>
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
		$("#id_body").change(function(){
        var id=$(this).val();
        //alert(id);
        $.ajax({
            type    : 'POST',
            url     : 'data/keluhan_lokasi.php',
            data    : 'id='+id,
            success : function(response){
            	//alert(response);
                $('.loc').html(response);

            }
        });
    });

		$("#id_lokasi").change(function(){
        var id=$(this).val();
        var id_body=$("#id_body").val();
       
        $.ajax({
            type    : 'POST',
            url     : 'data/keluhan_simtom.php',
            data    : 'id='+id+'&id_body='+id_body,
            success : function(response){
            	
                $('#simptom').html(response);

            }
        });
    });

	$('#btnSimpanKeluhan').click(function()
		{
			
			var form = $('#keluhan').serialize();
			var rm = $('#rm').val();
			//alert(form);
			$.ajax({
				type: "POST",
				url: "content/pasien/keluhan/simpan.php",
				data: form,
				cache: false,
				beforeSend: function(){ $("#btnSimpanKeluhan").val('Submitting...');},
				success: function(data){
					$('#form-modal2').modal('toggle');
					$("#data_pasien").load('content/pasien/keluhan/pasien_keluhan.php?id='+rm);
				}
			});

			/*var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var id_kategori_perhatian=$("#id_kategori_perhatian").val();
			var judul=$("#judul").val();
			var id_kode_atc=$("#id_kode_atc").val();
			var catatan=$("#catatan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kategori_perhatian='+id_kategori_perhatian+'&judul='+judul+'&id_kode_atc='+id_kode_atc+'&catatan='+catatan+'&id_kunjungan='+id_kunjungan;
			var dataString2 = 'id_pasien='+id_pasien;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pasien-perhatian",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanPerhatian").val('Submitting...');},
				success: function(data){
					$('#form-modal2').modal('toggle');
					//alert('simpan');
				}
			});
			$.ajax({
				type: "POST",
				url: "data-pasien-perhatian",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_perhatian").html(data);
					alert('Data berhasil disimpan');
				}
			});*/

		});

	$(document).ready(function(){
			
			
			 $('.js-example-basic-single').select2();
		});
		</script>
<?php
} 
?>