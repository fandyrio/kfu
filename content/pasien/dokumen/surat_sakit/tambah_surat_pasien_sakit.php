<?php
session_start();
include "../../../../config/conn.php";

$getDataDokter=pg_query("SELECT * from master_karyawan where id='$_POST[idDokter]'");
$fetchDocter=pg_fetch_assoc($getDataDokter);
$namaDokter=$fetchDocter['nama'];
$getDataDiagnosa=pg_query("SELECT * from pasien_diagnosa_detail pdd join master_icd10 micd 
	on micd.id=pdd.id_diagnosa
	join kunjungan k on k.id=pdd.id_kunjungan
	where pdd.id_pasien='$_POST[id_pasien]' and k.status_kunjungan='Y'");
$jumlahDiagnosa=pg_num_rows($getDataDiagnosa);

?>
<div class="card-header">
		<strong>Surat Keterangan Sakit</strong>
</div>
<div class="card-block">
	<div class="row">
		<div class="col-md-12">
			<div class='btn btn-xs btn-danger' id='alert'></div>
			<div class="btn btn-xs btn-warning" id="notif" style="display:none;margin-bottom:10px; text-align: left;">
				Warning
				<span id="item">

				</span>
			</div>
			<form id="tambahDataDokumen">
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Dokter</label>
					<div class="col-md-8">
							<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $namaDokter; ?>" required autofocus readonly>
							<input type="hidden" id="id_dokter" name="id_dokter" class="form-control" value="<?php echo $_POST['idDokter'] ?>" required autofocus readonly>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Tanggal Istirahat</label>
					<div class="col-md-4">
							<input type="date" id="mulai_istirahat" name="mulai_istirahat" class="form-control" placeholder="tgl istrahat" required autofocus>
					</div>
					<div class="col-md-4">
							<input type="date" id="selesai_istirahat" name="selesai_istirahat" class="form-control" placeholder="tgl istrahat" required autofocus>
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
		$("#notif").hide();

		var jumlahDiagnosa="<?php echo $jumlahDiagnosa ?>";
		if(jumlahDiagnosa=="0")
		{
			$("#notif").show();
			$("#item").append("<li>Diagnosa Belum diberikan</li>");			
		}
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
				url:'content/pasien/dokumen/surat_sakit/surat_sakit.php',
				data:data+'&goTo=suratsehat&idPasien='+idPasien,
				type:'POST',
				success:function(result)
				{

					$("#data_pasien").load('content/pasien/dokumen/surat_sakit/daftarSuratSakit.php?id='+no_rm);
				}
			});
		});
		$("#batal").click(function(e)
		{
			e.preventDefault();
			var no_rm="<?php echo $_POST[no_rm]?>";
			$("#data_pasien").load('content/pasien/dokumen/surat_sakit/daftarSuratSakit.php?id='+no_rm);
		})
	});
</script>