<?php
error_reporting(0);
session_start();
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
$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC LIMIT 1"));
$id_kunjungan=$c['id'];
?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div class="card">
	<div class="card-header">
		<strong>Order Paket</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-8">
				<fieldset>
					<legend>Data</legend>
					<div id="data_paket">
						<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Nama Paket</th>
									<th width="150px">Catatan</th>
									<th width="80px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_billing_paket WHERE id_pasien='$id_pasien' AND status_hapus='N' AND id_unit='$_SESSION[id_units]'  ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$r[id_billing_paket]'"));
										$nama_paket=$a['nama_paket'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
										$status_kunjungan=$a['status_kunjungan'];
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_paket;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<?php
												if($status_kunjungan=='Y'){
												?>
												<button class="btn btn-danger btn-xs btnHapusPaket" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
												<?php
												}
												?>
											</td>
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-4" id="form_paket">
				<fieldset>
					<legend>Tambah</legend>
					<form id="tambah_pasien_paket" class="form-horizontal" action="aksi-tambah-pasien-paket" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
						<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
						
						<div class="form-group">
							<label>Daftar Paket</label>
							<select class="js-example-basic-single form-control" name="id_billing_paket" id="id_billing_paket">
								<?php
							$unit = $_SESSION['id_units'];
							$tampil=pg_query($dbconn,"Select distinct id_billing_paket from billing_paket_kategori_harga_unit where id_unit='$unit' order by id_billing_paket asc");

							while ($r=pg_fetch_assoc($tampil)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket where id='".$r["id_billing_paket"]."' "));
								
									echo"<option value='$r[id_billing_paket]'>$data[nama_paket]</option>";
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Catatan</label>
							<textarea name="catatan" class="form-control"></textarea>
						</div>
						<hr>
						<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanpaket" <?php if($id_kunjungan==''){echo "disabled";}?>>Simpan</button>
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
    $('#tambah_pasien_paket').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		
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
				$("#data_paket").html(data);
            },
            error: function(data){
                //console.log("error");
                //console.log(data);
            }
        });
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-paket',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_paket").html(msg);
			}
		});
    }));
});


$(function () {
	
	$(".btnHapusPaket").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus paket ini?")){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-paket',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_paket").html(msg);
				}
			});
			
		}
		else{
			return false;
		}
	});
});
$(document).ready(function(){
	$('.js-example-basic-single').select2();
});
</script>