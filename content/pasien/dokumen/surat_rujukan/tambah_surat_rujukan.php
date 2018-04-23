<?php
session_start();
include "../../../../config/conn.php";

$getDataDokter=pg_query("SELECT * from master_karyawan where id='$_POST[idDokter]'");
$fetchDocter=pg_fetch_assoc($getDataDokter);
$namaDokter=$fetchDocter['nama'];

$getDataFisik=pg_query("SELECT * from pasien_fisik_detail pfd join fisik f on f.id=pfd.id_fisik join pasien_fisik pf on pf.id=pfd.id_pasien_fisik
join kunjungan k on k.id=pf.id_kunjungan
where pf.id_pasien='$_POST[id_pasien]' and k.status_kunjungan='Y'");
$jumlahDataFisik=pg_num_rows($getDataFisik);

$getDataKeluhan=pg_query("select * from pasien_keluhan pk join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
where id_kunjungan=(select max(id) from kunjungan where id_pasien='$_POST[id_pasien]' and status_kunjungan='Y')");
$jumlahKeluhan=pg_num_rows($getDataKeluhan);

$getDataDiagnosa=pg_query("SELECT * from pasien_diagnosa_detail pdd join master_icd10 micd 
	on micd.id=pdd.id_diagnosa
	join kunjungan k on k.id=pdd.id_kunjungan
	where pdd.id_pasien='$_POST[id_pasien]' and k.status_kunjungan='Y'");
$jumlahDiagnosa=pg_num_rows($getDataDiagnosa);

?>
<div class="card-header">
		<strong>Tambah Surat Rujukan</strong>
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
				<label class="col-md-4 form-control-label" for="id_lainnya">Dirujuk ke Spesialis</label>
					<div class="col-md-8">
							<input type="text" id="ts" name="ts" class="form-control" placeholder="Spesialis" required autofocus>
							<div id="dataSpesialis"></div>
					</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Poly</label>
					<div class="col-md-8">
						<select name="poly" class="form-control">
							<option value="0">Pilih</option>
							<?php
								$getPoly=pg_query("SELECT * from master_poly");
								while($fetchPoly=pg_fetch_assoc($getPoly))
								{
									echo"<option value='$fetchPoly[id]'>$fetchPoly[name]</option>";
								}


							?>
						</select>
					</div>
			</div>

			<div class="form-group row">
				<label class="col-md-4 form-control-label" for="id_lainnya">Rumah Sakit</label>
				<div class="col-md-8">
					<?php
					$data=pg_query("select * from pasien_tindak_lanjut ptl join master_cabang_rujukan mcr on mcr.id=ptl.id_rs 
					where ptl.id_kunjungan=(select max(id) from kunjungan where id_pasien='$_POST[id_pasien]' and status_kunjungan='Y')");
					$fetchData=pg_fetch_assoc($data);
					$jumlahRujukan=pg_num_rows($data);
					$idRS=$fetchData['id_rs'];
					if($jumlahRujukan==0)
					{
						$rs="Silahkan Rujuk di ke Rumah sakit di menu Tindak Lanjut";
						$value=0;
					}
					else
					{
						$rs=$fetchData['nama'];
						$value=$fetchData['id_rs'];
					}
					?>
					<input type="hidden" name="id_rs" value="<?php echo $value ?>">
					<input type="text" id="rs" name="rs" class="form-control" placeholder="Rumah Sakit" value="<?php echo $rs; ?>" required readonly>
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

		var fisik="<?php echo $jumlahDataFisik; ?>";
		var keluhan="<?php echo $jumlahKeluhan; ?>";
		var idRS="<?php echo $jumlahRujukan; ?>";
		var jumlahDiagnosa="<?php echo $jumlahDiagnosa ?>";
		if(fisik=="0")
		{
			$("#notif").show();
			$("#item").append("<li>Pemeriksaan Fisik Belum Dilakukan</li>");
		}
		if(keluhan=="0")
		{
			$("#notif").show();
			$("#item").append("<li>Pemeriksaan Keluhan Belum Dilakukan</li>");	
		}
		if(idRS=="0")
		{
			$("#notif").show();
			$("#item").append("<li>Rumah Sakit belum di assign</li>");		
		}
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
				url:'content/pasien/dokumen/surat_rujukan/suratRujukan.php',
				data:data+'&goTo=suratsehat&idPasien='+idPasien,
				type:'POST',
				success:function(result)
				{

					$("#data_pasien").load('content/pasien/dokumen/surat_rujukan/daftar_surat_rujukan.php?id='+no_rm);
				}
			});
		});
		$("#batal").click(function(e)
		{
			e.preventDefault();
			var no_rm="<?php echo $_POST[no_rm]?>";
			$("#data_pasien").load('content/pasien/dokumen/surat_rujukan/daftar_surat_rujukan.php?id='+no_rm);
		});

		$("#ts").keyup(function()
		{
			var nama_spesialis=$("#ts").val();

			$.ajax(
			{
				url:'content/pasien/dokumen/surat_rujukan/daftarSpesialis.php',
				data:{nama_spesialis:nama_spesialis},
				type:"POST",
				success:function(result)
				{
					$("#dataSpesialis").html(result).show();
				}
			});
		});
	});
</script>