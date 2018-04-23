<?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
	$foto="images/pasien/upload_$d[foto]";
}
else{
	$foto="images/default.png";
}

$id_pasien=$d['id'];

$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<div class="card">
	<div class="card-header">
		<strong>Pengukuran</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<fieldset>
					<legend>Data</legend>
					<button type="button" class="btn btn-success btn-xs" id="btnTampilkanPengukuran">TAMPILKAN GRAFIK</button>
					<br><br>
					<div id="data_pengukuran">
						<table class="table">
							<thead>
								<tr>
									<th width="30px">No.</th>
									<th width="80px">Tanggal</th>
									<th width="600px">Nama</th>
									<th>Catatan</th>
									<th width="80px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_pengukuran WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
									$no=1;
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										?>
										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $r['nama_pengukuran'];?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-info btn-xs btnEditPengukuran" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
												<button class="btn btn-danger btn-xs btnHapusPengukuran" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
											</td>
										</tr>
										<tr>
											<td colspan="5">
											<table class="table">
												<thead>
													<tr>
														<th width="108px"></th>
														<th width="200px">Pengukuran</th>
														<th width="100px">Nilai</th>
														<th width="100px">Satuan</th>
														<th width="100px">Tanggal</th>
														<th width="100px">Jam</th>
														<th>Catatan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$pengukuran_detail=pg_query($dbconn,"SELECT * FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$r[id]'");
													while($pd=pg_fetch_array($pengukuran_detail)){
														$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, satuan FROM master_pengukuran WHERE id='$pd[id_pengukuran]'"));
														$nama_pengukuran=$a['nama'];
														$nama_satuan=$a['satuan'];
														$tanggal=DateToIndo2($pd['tanggal']);
														?>
														<tr>
															<th></th>
															<td><?php echo $nama_pengukuran;?></td>
															<td><?php echo $pd['nilai'];?></td>
															<td><?php echo $nama_satuan;?></td>
															<td><?php echo $tanggal;?></td>
															<td><?php echo $pd['jam'];?></td>
															<td><?php echo $pd['catatan'];?></td>
														</tr>
														<?php
													}
													?>
												</tbody>
											</table>
											</td>
										</tr>
										<tr>
											<td colspan="5"></td>
										</tr>
										<?php
										$no++;
									}
								?>
							</tbody>
						</table>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-12" id="form_pengukuran">
				<fieldset>
					<legend>Tambah</legend>
					<form id="tambah_pasien_pengukuran" class="form-horizontal" action="aksi-tambah-pasien-pengukuran" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
						<div class="form-group row">
							<label class="col-sm-1">Kategori</label>
							<div class="col-sm-2">
								<select class="form-control" name="id_group" id="id_group"required>
									<option value="">Pilih</option>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_pengukuran_group ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
							
							<label class="col-sm-1">Nama</label>
							<div class="col-sm-3">
								<input type="text" name="nama_pengukuran" id="nama_pengukuran" class="form-control" required>
							</div>
							
							<label class="col-sm-1">Catatan</label>
							<div class="col-sm-4">
								<input type="text" name="catatan_pengukuran" id="catatan_pengukuran" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label><strong>Detail</strong></label>
							<div id="detail_form_pengukuran"></div>
						</div>
						<hr>
						<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanPengukuran">Simpan</button>
					</form>
				</fieldset>
			</div>
		</div>
	</div>
</div>
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(document).ready(function (e) {
    $('#tambah_pasien_pengukuran').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
		var id_pasien=$("#id_pasien").val();
		
		var dataString2 = 'id_pasien='+id_pasien;
		var checked = [];
        $("input[name='checked[]']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });
		
		if(checked==''){
			alert("Tolong pilih salah satu pengukuran");
		}
		else{
			$.ajax({
				type:'POST',
				url: $(this).attr('action'),
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					//console.log("success");
					//console.log(data);
					$("#data_pengukuran").html(data);
				},
				error: function(data){
					//console.log("error");
					//console.log(data);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-gambar',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#form_gambar").html(msg);
				}
			});
		}
    }));
});

$(function () {
	
	$("#id_group").change(function(){
		var id_group=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-master-pengukuran',
			data	: 'id_group='+id_group,
			success	: function(response){
				$('#detail_form_pengukuran').html(response);
			}
		});
		
		$.ajax({
			type 	: 'POST',
			url 	: 'nama-pengukuran',
			data	: 'id_group='+id_group,
			success	: function(response){
				$('#nama_pengukuran').val(response);
			}
		});
	});
	
	$("#btnTampilkanPengukuran").click(function(){
		
		$.ajax({
			type: 'POST',
			url: 'aksi-tampilkan-pengukuran',
			data: { 
				'checked': checked
			},
			success: function(msg){
				$("#tampilan_pengukuran").html(msg);
			}
		});
	});
	
	$(".btnEditPengukuran").click(function(){
		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-pengukuran',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form_pengukuran").html(msg);
				alert(url);
			}
		});
		
	});
	
	$(".btnHapusPengukuran").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus pengukuran ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-pengukuran',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_pengukuran").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-pengukuran',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#form_pengukuran").html(msg);
				}
			});
			
		}
		else{
			return false;
		}
	});
});


$(document).ready(function(){
	$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});
</script>