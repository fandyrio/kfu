<html>
<head>
<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

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

switch($_POST['act']){

case "laborder":
$id_pasien=$_POST['id_pasien'];
?>
	<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Lab Order</b>
				<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="100px">No. Referensi</th>
								<th>Dirujuk Oleh</th>
								<th>Dibalas Ke</th>
								<th>Prioritas</th>
								<th>Catatan</th>
								
							</tr>
						</thead>
						<tbody>
							<?php

								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ 
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' ORDER BY id DESC");
								}
								
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
									$nama_prioritas=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
									$dirujuk_oleh=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));;
									$dibalas_oleh=$a['nama'];
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $r['no_referensi'];?></td>
										<td><?php echo $dirujuk_oleh;?></td>
										<td><?php echo $dibalas_oleh;?></td>
										<td><?php echo $nama_prioritas;?></td>
										<td><?php echo $r['catatan'];?></td>
										
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<!--end -->
				</div>
			</div>

<?php 
break;

case "all":
$id_pasien=$_POST['id_pasien'];
?>

<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Lab Order</b>
				<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="100px">No. Referensi</th>
								<th>Dirujuk Oleh</th>
								<th>Dibalas Ke</th>
								<th>Prioritas</th>
								<th>Catatan</th>
								
							</tr>
						</thead>
						<tbody>
							<?php

								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ 
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' ORDER BY id DESC");
								}
								
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
									$nama_prioritas=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
									$dirujuk_oleh=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));;
									$dibalas_oleh=$a['nama'];
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $r['no_referensi'];?></td>
										<td><?php echo $dirujuk_oleh;?></td>
										<td><?php echo $dibalas_oleh;?></td>
										<td><?php echo $nama_prioritas;?></td>
										<td><?php echo $r['catatan'];?></td>
										
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<!--end -->
				</div>
			</div>
			
			<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Perhatian</b>
				<table class="table">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">Kategori</th>
									<th width="150px">Teks</th>
									<th width="80px">ATC Code</th>
									<th>Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
									
								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
								}
									if(pg_num_rows($tampil)>0){
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perhatian_kategori WHERE id='$r[id_kategori_perhatian]'"));
										$nama_kategori_perhatian=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
										$nama_kode=$a['code'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $nama_kategori_perhatian;?></td>
											<td><?php echo $r['judul'];?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								}
								else{
									?>
									<tr>
											<td align="center" colspan="5"><?php echo "No Record"; ?></td>
											
									</tr>

								<?php 
								}
								?>
							</tbody>
						</table>
					<!--end -->
				</div>
			</div>
			<div class="row">
			<div class="col-md-12">
					<!-- tindakan -->
					<b>Tindakan</b>
					<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Kode</th>
									<th>Nama</th>
									<th width="150px">Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
									if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
								}
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_tindakan]'"));
										$nama_tindakan=$a['nama'];
										$nama_kode=$a['kode'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
										$status_kunjungan=$a['status_kunjungan'];
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $nama_tindakan;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					<!-- end-->
					<!-- PERHATIAN-->
				</div>
			</div>
<?php 
break;

case "perhatian":
$id_pasien=$_POST['id_pasien'];
?>
<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Perhatian</b>
				<table class="table">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">Kategori</th>
									<th width="150px">Teks</th>
									<th width="80px">ATC Code</th>
									<th>Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
								}
									
									if(pg_num_rows($tampil)>0){
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perhatian_kategori WHERE id='$r[id_kategori_perhatian]'"));
										$nama_kategori_perhatian=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
										$nama_kode=$a['code'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $nama_kategori_perhatian;?></td>
											<td><?php echo $r['judul'];?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								}
								else{
									?>
									<tr>
											<td align="center" colspan="5"><?php echo "No Record"; ?></td>
											
									</tr>

								<?php 
								}
								?>
							</tbody>
						</table>
					<!--end -->
				</div>
			</div>
<?php 
break;
	
	case "tindakan":
	$id_pasien=$_POST['id_pasien'];
?>
	<div class="row">
			<div class="col-md-12">
					<!-- tindakan -->
					<b>Tindakan</b>
					<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Kode</th>
									<th>Nama</th>
									<th width="150px">Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
								}
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_tindakan]'"));
										$nama_tindakan=$a['nama'];
										$nama_kode=$a['kode'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
										$status_kunjungan=$a['status_kunjungan'];
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $nama_tindakan;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					<!-- end-->
					<!-- PERHATIAN-->
				</div>
			</div>
	<?php
	break;	
	default:
?>
<div class="card">
	<div class="card-header">
		<strong>Kronologis</strong>
	</div>
	<div class="card-block">
		<div class="row col-md-12">
		<div class="col-md-6">
						  <form method="post">
						  	<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $id_pasien; ?>">
							<div class="form-group row">
								<label class="col-md-6 form-control-label" >Module Filter</label>
								<div class="col-sm-6">				                     
				                      <select name='filter_module' class='form-control' id="filter_module" required>
				                       <option value='all'>--ALL--</option>		                      
				                       <option value='perhatian'>Perhatian</option>
				                       <option value='tindakan'>Tindakan</option>	
				                       <option value='laborder'>Lab Order</option>		                      
				                      </select>
				                  </div>
				              </div>
							
				            </form>

			</div>
			
			<div class=" col-md-6 text-right">
						  <form method="post">
						  	<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $id_pasien; ?>">
						
							<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Tgl</label>
									<div class="col-sm-3">										
										<input name='tgl_awal' id='tgl_awal' class='form-control datedatabase' value="<?php echo date('d-m-Y'); ?>" required>		
									</div>									
									<label class="col-sm-1 form-control-label" >s/d</label>
									<div class="col-sm-3">
										<input name='tgl_akhir'  id='tgl_akhir' class='form-control datedatabase' required value="<?php echo date('d-m-Y'); ?>">
									</div>
									<button id="find" type="button" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									
								</div>


				            </form>

			</div>
			
		</div>
			<div class="changeme">
			<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Lab Order</b>
				<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="100px">No. Referensi</th>
								<th>Dirujuk Oleh</th>
								<th>Dibalas Ke</th>
								<th>Prioritas</th>
								<th>Catatan</th>
								
							</tr>
						</thead>
						<tbody>
							<?php

								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ 
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' ORDER BY id DESC");
								}
								
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
									$nama_prioritas=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
									$dirujuk_oleh=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));;
									$dibalas_oleh=$a['nama'];
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $r['no_referensi'];?></td>
										<td><?php echo $dirujuk_oleh;?></td>
										<td><?php echo $dibalas_oleh;?></td>
										<td><?php echo $nama_prioritas;?></td>
										<td><?php echo $r['catatan'];?></td>
										
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<!--end -->
				</div>
			</div>
			
			<div class="row">
			<div class="col-md-12">
					<!--RESEP-->
					<b>Perhatian</b>
				<table class="table">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">Kategori</th>
									<th width="150px">Teks</th>
									<th width="80px">ATC Code</th>
									<th>Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
									
								if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
								}
									if(pg_num_rows($tampil)>0){
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perhatian_kategori WHERE id='$r[id_kategori_perhatian]'"));
										$nama_kategori_perhatian=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
										$nama_kode=$a['code'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $nama_kategori_perhatian;?></td>
											<td><?php echo $r['judul'];?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								}
								else{
									?>
									<tr>
											<td align="center" colspan="5"><?php echo "No Record"; ?></td>
											
									</tr>

								<?php 
								}
								?>
							</tbody>
						</table>
					<!--end -->
				</div>
			</div>
			<div class="row">
			<div class="col-md-12">
					<!-- tindakan -->
					<b>Tindakan</b>
					<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Kode</th>
									<th>Nama</th>
									<th width="150px">Catatan</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
									if($_POST['tgl_awal'] AND $_POST['tgl_akhir']){
									$tgl_awal = DateToEng($_POST['tgl_awal']);
									$tgl_akhir = DateToEng($_POST['tgl_akhir']);
									
									 $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N'  AND waktu_input::date BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
								}
								else{ $tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
								}
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_tindakan]'"));
										$nama_tindakan=$a['nama'];
										$nama_kode=$a['kode'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
										$status_kunjungan=$a['status_kunjungan'];
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $nama_tindakan;?></td>
											<td><?php echo $r['catatan'];?></td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					<!-- end-->
					<!-- PERHATIAN-->
				</div>
			</div>
				
		</div><!-- end filter-->
		</div>
	</div>
					
<?php

	
break;
	}
	pg_close($dbconn);
?>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/datatable_code_ajax.js"></script>
<script type="text/javascript">

		$(document).ready(function(){
			$(".datedatabase").mask("99/99/9999",{placeholder:"dd-mm-yyyy"});
			
			 $('.js-example-basic-single').select2();
		});
$(function () {
	
		$("#filter_module").change(function(){
			var id=$(this).val();
			
				var id_pasien=$("#id_pasien").val();
				
				$.ajax({
					type 	: 'POST',
					url 	: 'content/pasien/kronologis/pasien_kronologis.php',
					data	: {act:id, id_pasien:id_pasien},
					success	: function(response){
						$('.changeme').html(response);
					}
				});
			});
		$("#find").click(function(){
				var id=$('#filter_module').val();
				//alert("masuk");
							
				var id_pasien=$("#id_pasien").val();
				var tgl_awal=$("#tgl_awal").val();
				var tgl_akhir=$("#tgl_akhir").val();
				
				
				$.ajax({
					type 	: 'POST',
					url 	: 'content/pasien/kronologis/pasien_kronologis.php',
					data	: {act:id, id_pasien:id_pasien, tgl_akhir:tgl_akhir, tgl_awal:tgl_awal },
					success	: function(response){
						$('.changeme').html(response);
					}
				});
			});

	
	
	
	
});
</script>
</body>
</html>