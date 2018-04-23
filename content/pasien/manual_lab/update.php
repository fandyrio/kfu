<?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$id=$_POST['id'];
$rm=$_POST['rm'];
$r=pg_fetch_array(pg_query("SELECT * from pasien_manual_lab where id='$id' "));
?>
<input type="hidden" name="id" value="<?php echo $id;?>" id="id">
<input type="hidden" name="rm" value="<?php echo $rm;?>" id="rm">
<div class="modal-dialog modal-md modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">UPDATE HASIL LAB</h6>
				</div>
				<div class="modal-body" id="form-data">
					
					<div class="form-group">
						<label>Nama Pemeriksaan</label>
						<input value="<?php echo $r['nama_tindakan']; ?>" type="text" name="nama_tindakan" id="nama_tindakan" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Hasil</label>
						<input value="<?php echo $r['hasil']; ?>" type="text" name="hasil" id="hasil" class="form-control md-3 " required>
					</div>
					<div class="form-group">
						<label>Satuan</label>
						<input value="<?php echo $r['satuan']; ?>" type="text" name="satuan" id="satuan" class="form-control" >
					</div>
					<div class="form-group">
						<label>Nilai Normal</label>
						<input value="<?php echo $r['nilai_normal']; ?>" type="text" name="nilai_normal" id="nilai_normal" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Status</label>
						<input value="<?php echo $r['high_marks']; ?>"  type="text" name="status" id="status" class="form-control" placeholder="High">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary btn-sm" id="btnUpdateHasilLab">Simpan</button>
				</div>
			</div>
		</div>

<script>
		
		$('#btnUpdateHasilLab').click(function()
		{
			var rm=$("#rm").val();
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var nama_tindakan=$("#nama_tindakan").val();
			var hasil=$("#hasil").val();
			var satuan=$("#satuan").val();
			var nilai_normal=$("#nilai_normal").val();
			var status=$("#status").val();
			var dataString = 'id_pasien='+id_pasien+'&nama_tindakan='+nama_tindakan+'&hasil='+hasil+'&nilai_normal='+nilai_normal+'&status='+status+'&id_kunjungan='+id_kunjungan+'&satuan='+satuan;
			
			$.ajax({
				type: "POST",
				url: 'content/pasien/manual_lab/vupdate.php',
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnUpdateHasilLab").val('Submitting...');},
				success: function(data){
					$('#form-modal2').modal('toggle');
					alert(data);
					$("#data_pasien").load('content/pasien/manual_lab/manual_lab.php?id='+rm);
				}
			});
			

		});
		</script>