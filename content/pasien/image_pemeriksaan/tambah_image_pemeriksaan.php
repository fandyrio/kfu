<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../../../config/conn.php";

$getDataDokter=pg_query("SELECT * from master_karyawan where id='$_POST[idDokter]'");
$fetchDocter=pg_fetch_assoc($getDataDokter);
$namaDokter=$fetchDocter['nama'];


?>
<div class="card-header">
		<strong>Tambah Image Pemeriksaan</strong>
</div>
<div class="card-block">
	<div class="row">
		<div class="col-md-12">
			<div class='btn btn-xs btn-danger' id='alert'></div>
			<form id="tambahDataDokumen" enctype="multipart/form-data">
				<input type="hidden" name="id_pasien" value="<?php echo $_POST['id_pasien'] ?>">
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Dokter</label>
					<div class="col-md-8">
							<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $namaDokter; ?>" required autofocus readonly>
							<input type="hidden" id="id_dokter" name="id_dokter" class="form-control" value="<?php echo $_POST['idDokter'] ?>" required autofocus readonly>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Nama Pemeriksaan</label>
					<div class="col-md-8">
							<input type="text" id="nama_pemeriksaan" name="nama_pemeriksaan" class="form-control" placeholder="Nama Pemeriksaan" required autofocus>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Tanggal</label>
					<div class="col-md-8">
							<input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Prov / Kota / Kab / Kec" value="<?php echo date('d-m-Y') ?>"; required autofocus>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">File</label>
					<div class="col-md-8">
							<input type="file" id="file_image" name="file" >
					</div>
			</div>

			<div class="form-group row">
				<div class="col-md-1">
					<button class='btn btn-sm btn-success' type="submit" id='save'>Simpan</button>
				</div>
				<div class="col-md-1">
					<button class='btn btn-sm btn-danger' id='batal'>Batal</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function()
	{
		$("#alert").hide();
		
		 $("#tambahDataDokumen").on('submit', function(e)
		{
			e.preventDefault();
			var image=$("#file_image").val();
			var data=$("#tambahDataDokumen").serialize();
			var idPasien=<?php echo $_POST['id_pasien'] ?>;
			var no_rm="<?php echo $_POST[no_rm]?>";
			if($("#tujuan_surat").val()=="" || $("#dibuat_di").val()=="")
			{
				$("#alert").html("Pastikan Semua Field Disi").show();
				setTimeout(function(){ $("#alert").hide(); }, 3000);
				return false;
			}

		/*	var file_data = $('#file_image').prop('files')[0];
			//var nama_pemeriksaan=$('#nama_pemeriksaan').prop('files')[0];   
   			var form_data = new FormData();                  
    		form_data.append('file', file_data);*/
                        
    		$.ajax({
                url:'content/pasien/image_pemeriksaan/save_pemeriksaan_image.php',
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),                         
                type: 'post',
                success: function(php_script_response){
                    alert(php_script_response); // display response from the PHP script, if any
                    $("#data_pasien").load('content/pasien/image_pemeriksaan/daftar_image_pemeriksaan.php?id='+no_rm);
                }
     		});
			
		
		});

		$("#batal").click(function(e)
		{
			e.preventDefault();
			var no_rm="<?php echo $_POST[no_rm]?>";
			$("#data_pasien").load('content/pasien/image_pemeriksaan/daftar_image_pemeriksaan.php?id='+no_rm);
		})
	});
</script>