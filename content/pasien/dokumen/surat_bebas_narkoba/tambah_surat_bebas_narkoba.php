<?php
session_start();
include "../../../../config/conn.php";

$getDataDokter=pg_query("SELECT * from master_karyawan where id='$_POST[idDokter]'");
$fetchDocter=pg_fetch_assoc($getDataDokter);
$namaDokter=$fetchDocter['nama'];


?>
<div class="card-header">
		<strong>Tambah Surat Keterangan Bebas Narkoba</strong>
</div>
<div class="card-block">
	<div class="row">
		<div class="col-md-12">
			<div class='btn btn-xs btn-danger' id='alert'></div>
			<form id="tambahDataDokumen">
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Dokter</label>
					<div class="col-md-8">
							<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $namaDokter; ?>" required autofocus readonly>
							<input type="hidden" id="id_dokter" name="id_dokter" class="form-control" value="<?php echo $_POST['idDokter'] ?>" required autofocus readonly>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Tujuan Pembuatan</label>
					<div class="col-md-8">
							<input type="text" id="tujuan_surat" name="tujuan_surat" class="form-control" placeholder="Tujuan Pembuatan Surat" required autofocus>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Surat ini dibuat di</label>
					<div class="col-md-8">
							<input type="text" id="dibuat_di" name="dibuat_di" class="form-control" placeholder="Prov / Kota / Kab / Kec" required autofocus>
					</div>
			</div>
			<div class="form-group row">
				<div class="col-md-1">
					<button class='btn btn-sm btn-success' id='save'>Simpan</button>
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
		$("#save").click(function(e)
		{
			e.preventDefault();
			var data=$("#tambahDataDokumen").serialize();
			var idPasien=<?php echo $_POST['id_pasien'] ?>;
			var no_rm="<?php echo $_POST[no_rm]?>";
			if($("#tujuan_surat").val()=="" || $("#dibuat_di").val()=="")
			{
				$("#alert").html("Pastikan Semua Field Disi").show();
				setTimeout(function(){ $("#alert").hide(); }, 3000);
				return false;
			}
			$.ajax(
			{
				url:'content/pasien/dokumen/surat_bebas_narkoba/surat_bebas_narkoba.php',
				data:data+'&idPasien='+idPasien,
				type:'POST',
				success:function(result)
				{

					$("#data_pasien").load('content/pasien/dokumen/surat_bebas_narkoba/daftarSuratBebasNarkoba.php?id='+no_rm);
				},
				error:function()
				{
					alert('ERROR');
				}
			});
		});
		$("#batal").click(function(e)
		{
			e.preventDefault();
			var no_rm="<?php echo $_POST[no_rm]?>";
			$("#data_pasien").load('content/pasien/dokumen/surat_bebas_narkoba/daftarSuratBebasNarkoba.php?id='+no_rm);
		})
	});
</script>