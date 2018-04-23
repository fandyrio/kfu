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

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='laborder' AND $act=='input'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		$tgl_request=DateToEng($_POST['tgl_request']);
		$tgl_awal=DateToEng($_POST['tgl_awal']);
		$tgl_akhir=DateToEng($_POST['tgl_akhir']);
		
		$result=pg_query($dbconn,"INSERT INTO pasien_laborder (id_refered_by, id_reply_to, no_referensi, id_priority, catatan, waktu_input, id_user, id_pasien, tgl_request, jam_request, ket_rujukan, anamesa, medicine, dosis, tgl_awal, tgl_akhir, id_kunjungan, id_unit_lab, status_hapus, status_jawab, status_track, status_billing, id_status_laborder, id_unit) VALUES ('$_POST[id_refered_by]', '$_POST[id_reply_to]', '$_POST[no_referensi]', '$_POST[id_priority]', '$_POST[catatan]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_pasien]', '$tgl_request', '$_POST[jam_request]', '$_POST[ket_rujukan]', '$_POST[anamesa]', '$_POST[medicine]', '$_POST[dosis]', '$tgl_awal', '$tgl_akhir', '$_POST[id_kunjungan]', '$_POST[id_unit_lab]', 'N', 'N', 'Y', 'N', '1', '$_SESSION[id_units]') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
			
		$data=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_pasien='$_POST[id_pasien]' AND id_kunjungan='$_POST[id_kunjungan]' AND status_temp='Y'");
		
		$tot_harga=0;
		while($r=pg_fetch_array($data)){
			if($r['id_lab_analysis_group']==NULL){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT id_tindakan FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
				$id_tindakan=$a['id_tindakan'];
			}
			else{
				$a=pg_fetch_array(pg_query($dbconn,"SELECT id_tindakan FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
				$id_tindakan=$a['id_tindakan'];
			}
			
			$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM tindakan_kategori_harga WHERE id_tindakan='$id_tindakan' AND id_kategori_harga='$id_kategori_harga'"));
			$harga=$bt['harga'];
		
			pg_query($dbconn,"UPDATE pasien_laborder_detail SET id_lab_order='$insert_id', status_temp='N' WHERE id='$r[id]'");
			
			$tot_harga+=$harga;
			
			pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_master_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'LO', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$r[id]', '1', 'N', '$_SESSION[id_units]')");
		}
		
		pg_query($dbconn,"UPDATE pasien_laborder SET harga='$tot_harga' WHERE id='$insert_id'");
		
		
		
		?>
		
		<?php
		
	}
	
	elseif($module=='laborder' AND $act=='data'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<div class="card">
			<div class="card-header">
				<strong>Data Lab Order</strong>
				<span class="pull-right">
					<?php
					if($id_kunjungan!=''){
						?>
						<button type="button" class="btn btn-primary btn-xs btnTambahLaborder">Tambah</button>
						<?php
					}
					else{
					?>
						<button type="button" class="btn btn-primary btn-xs btnTambahLaborder" disabled>Tambah</button>
					<?php
					}
					?>
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<table class="table" id="myTable3">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">No. Referensi</th>
									<th>Dirujuk Oleh</th>
									<th>Dibalas Ke</th>
									<th>Prioritas</th>
									<th>Catatan</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
										$nama_prioritas=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
										$dirujuk_oleh=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));

										$dibalas_oleh=$a['nama'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $r['no_referensi'];?></td>
											<td><?php echo $dirujuk_oleh;?></td>
											<td><?php echo $dibalas_oleh;?></td>
											<td><?php echo $nama_prioritas;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-primary btn-xs btnViewLaborder" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
												<button class="btn btn-info btn-xs btnEditLaborder" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLaborder" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
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
				</div>
			</div>
		</div>
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		
		<script type="text/javascript" src="assets/js/datatable_code_ajax.js"></script>
		<script type="text/javascript">
			$(function () {
				$('.btnTambahLaborder').click(function()
				{
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-laborder',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				$(".btnViewLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'view-pasien-laborder',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				
				$(".btnHapusLaborder").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus laborder ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-laborder',
							data: dataString2,
							success: function(msg){
								$("#data_laborder").html(msg);
							}
						});
					}
					else{
						return false;
					}
				});
				
				$(".btnEditLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
					$.ajax({
						type: 'POST',
						url: 'edit-pasien-laborder',
						data: dataString2,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
			});
			</script>
		<?php
	}
	elseif ($module=='order' AND $act=='inputform'){
		

	}
	
	elseif ($module=='laborder' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_laborder SET status_hapus='Y' WHERE id='$_POST[id]'");
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM pasien_laborder WHERE id='$_POST[id]'"));
		
		pg_query($dbconn,"DELETE FROM transaksi_invoice_detail WHERE id_pasien='$_POST[id_pasien]' AND id_kunjungan='$_POST[id_kunjungan]' AND jenis='LO' AND id_unit='$_SESSION[id_units]' ");
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<div class="card">
			<div class="card-header">
				<strong>Data Lab Order</strong>
				<span class="pull-right">
					<?php
					if($id_kunjungan!=''){
						?>
						<button type="button" class="btn btn-primary btn-xs btnTambahLaborder">Tambah</button>
						<?php
					}
					else{
					?>
						<button type="button" class="btn btn-primary btn-xs btnTambahLaborder" disabled>Tambah</button>
					<?php
					}
					?>
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<table class="table" id="myTable3">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">No. Referensi</th>
									<th>Dirujuk Oleh</th>
									<th>Dibalas Ke</th>
									<th>Prioritas</th>
									<th>Catatan</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' and id_unit='$_SESSION[id_units]' ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
										$nama_prioritas=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
										$dirujuk_oleh=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));;

										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $r['no_referensi'];?></td>
											<td><?php echo $dirujuk_oleh;?></td>
											<td><?php echo $dibalas_oleh;?></td>
											<td><?php echo $nama_prioritas;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-primary btn-xs btnViewLaborder" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
												<button class="btn btn-info btn-xs btnEditLaborder" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLaborder" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
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
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="assets/js/datatable_code_ajax.js"></script>
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script type="text/javascript">
			$(function () {
				$('.btnTambahLaborder').click(function()
				{
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-laborder',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				$(".btnViewLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'view-pasien-laborder',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				
				$(".btnHapusLaborder").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus laborder ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-laborder',
							data: dataString2,
							success: function(msg){
								$("#data_laborder").html(msg);
							}
						});
					}
					else{
						return false;
					}
				});
				
				$(".btnEditLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
					$.ajax({
						type: 'POST',
						url: 'edit-pasien-laborder',
						data: dataString2,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
			});
			</script>
		<?php
	}
	
	elseif ($module=='laborder' AND $act=='data_lab'){
		$id_specimen=$_POST['id_specimen'];
		$id_kategori=$_POST['id_kategori'];
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		echo"
		<input type='hidden' id='id_pasien' value='$id_pasien'>
		<input type='hidden' id='id_kunjungan' value='$id_kunjungan'>
		";
		if($id_specimen>0){
			if($id_kategori>0){
				$tampil=pg_query($dbconn,"SELECT a.id, a.kode, a.nama FROM lab_analysis a, lab_analysis_kategori b, lab_kategori c WHERE a.id=b.id_lab_analysis AND b.id_lab_kategori=c.id AND c.id='$id_kategori' AND a.id_lab_specimen='$id_specimen' ORDER BY a.kode");
			}
			else{
				$tampil=pg_query($dbconn,"SELECT id, kode, nama FROM lab_analysis WHERE id_lab_specimen='$id_specimen' ORDER BY kode");
			}
		}
		else{
			if($id_kategori>0){
				$tampil=pg_query($dbconn,"SELECT a.id, a.kode, a.nama FROM lab_analysis a, lab_analysis_kategori b, lab_kategori c WHERE a.id=b.id_lab_analysis AND b.id_lab_kategori=c.id AND c.id='$id_kategori' ORDER BY a.kode");
			}
			else{
				$tampil=pg_query($dbconn,"SELECT id, kode, nama FROM lab_analysis ORDER BY kode");
			}
		}
		?>
		<table class="table">
			<thead>
				<th>Kode</th>
				<th>Analisis</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
				<?php
				
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $r['kode'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td>
							<button class="btn btn-default btn-xs btnTambahPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-plus"></i></button>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		
		<script>
			$(function () {
				$('.btnTambahPesanAnalysis').click(function(){
					var id_analysis=this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_analysis='+id_analysis;
					$.ajax({
						type: "POST",
						url: "aksi-tambah-pesan-analysis",
						data: dataString,
						cache: false,
						success: function(data){
							$("#data_laborder_kanan").html(data);
						}
					});
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='laborder' AND $act=='inputanalysis'){
		$id_pasien=$_POST['id_pasien'];
		$id_analysis=$_POST['id_analysis'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_laborder_detail WHERE id_lab_analysis='$_POST[id_analysis]' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
		
		if($c['tot']==0){
			$data=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_pasien='$id_pasien' AND status_temp='Y' AND id_kunjungan='$id_kunjungan' AND id_lab_analysis_group!=NULL");
			$ada=0;
			
			$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]' AND id_unit='$_SESSION[id_units]'"));
			$id_kategori_harga=$d['id_kategori_harga'];
			
			$l=pg_fetch_array(pg_query($dbconn,"SELECT id_tindakan FROM lab_analysis WHERE id='$id_analysis'"));

			$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM tindakan_kategori_harga_unit WHERE id_tindakan='$l[id_tindakan]' AND id_kategori_harga='$id_kategori_harga' AND id_unit='$_SESSION[id_units]' "));
			$harga=$bt['harga'];

			
			
			pg_query($dbconn,"INSERT INTO pasien_laborder_detail (id_lab_analysis, harga, id_pasien, id_kunjungan, status_temp, id_unit) VALUES ('$_POST[id_analysis]', '$harga', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]')");

			
		}
		if($ada==1){
			echo"sudah_ada";
		}
		else{
		?>
		<table class="table">
			<thead>
				<th>Group</th>
				<th>Analisis</th>
				<th>Specimen</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
				while($r=pg_fetch_array($tampil)){
					if($r['id_lab_analysis_group']!=NULL){
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
						?>
						<tr>
							<td colspan="3"><?php echo $a['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
						$lab_analysis=pg_query($dbconn,"SELECT a.nama, a.id_lab_specimen FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$r[id_lab_analysis_group]'");
						while($l=pg_fetch_array($lab_analysis)){
							$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$l[id_lab_specimen]'"));
							echo"
							<tr>
								<td></td>
								<td>$l[nama]</td>
								<td>$s[nama]</td>
								<td></td>
							</tr>
							";
						}
						?>
						<?php
					}
					else{
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, id_lab_specimen FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
						$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$a[id_lab_specimen]'"));
						?>
						<tr>
							<td></td>
							<td><?php echo $a['nama'];?></td>
							<td><?php echo $s['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
			$(function () {
				$('.btnHapusPesanAnalysis').click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
						var id=this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						$.ajax({
							type: "POST",
							url: "aksi-hapus-pesan-analysis",
							data: dataString,
							cache: false,
							success: function(data){
								$("#data_laborder_kanan").html(data);
							}
						});
					}
					else{
						return false;
					}
				});
			});
		</script>
		<?php
		}
	}
	
	elseif ($module=='laborder' AND $act=='inputanalysisgroup'){
		$id_pasien=$_POST['id_pasien'];
		$id_analysis_group=$_POST['id_analysis_group'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		/*
		$data=pg_query($dbconn,"SELECT * FROM lab_analysis_group_detail WHERE id_lab_analysis_group='$id_analysis_group'");
		$ada=0;
		while($r=pg_fetch_array($data)){
			$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_laborder_detail WHERE id_lab_analysis='$r[id_lab_analysis]' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
			if($c['tot']>0){
				$ada=1;
				break;
			}
		}
		*/
		
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
		
		$tot_harga=0;
		$tampil=pg_query($dbconn,"SELECT * FROM lab_analysis_group_detail WHERE id_lab_analysis_group='$id_analysis_group'");
		while($r=pg_fetch_array($tampil)){
			$l=pg_fetch_array(pg_query($dbconn,"SELECT id_tindakan FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
			$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM tindakan_kategori_harga_unit WHERE id_tindakan='$l[id_tindakan]' AND id_kategori_harga='$id_kategori_harga' AND id_unit='$_SESSION[id_units]'"));
			
			
			$tot_harga+=$bt['harga'];
		}
		
		pg_query($dbconn,"INSERT INTO pasien_laborder_detail (id_lab_analysis_group, harga, id_pasien, id_kunjungan, status_temp, id_unit) VALUES ('$id_analysis_group', '$tot_harga', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]')");
			
		
		?>
		<table class="table">
			<thead>
				<th>Group</th>
				<th>Analisis</th>
				<th>Specimen</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
				while($r=pg_fetch_array($tampil)){
					if($r['id_lab_analysis_group']!=NULL){
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
						?>
						<tr>
							<td colspan="3"><?php echo $a['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
						$lab_analysis=pg_query($dbconn,"SELECT a.nama, a.id_lab_specimen FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$r[id_lab_analysis_group]'");
						while($l=pg_fetch_array($lab_analysis)){
							$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$l[id_lab_specimen]'"));
							echo"
							<tr>
								<td></td>
								<td>$l[nama]</td>
								<td>$s[nama]</td>
								<td></td>
							</tr>
							";
						}
						?>
						<?php
					}
					else{
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, id_lab_specimen FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
						$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$a[id_lab_specimen]'"));
						?>
						<tr>
							<td></td>
							<td><?php echo $a['nama'];?></td>
							<td><?php echo $s['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
		
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
			$(function () {
				$('.btnHapusPesanAnalysis').click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
						var id=this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						$.ajax({
							type: "POST",
							url: "aksi-hapus-pesan-analysis",
							data: dataString,
							cache: false,
							success: function(data){
								$("#data_laborder_kanan").html(data);
							}
						});
					}
					else{
						return false;
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='laborder' AND $act=='hapusanalysis'){
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		pg_query($dbconn,"DELETE FROM pasien_laborder_detail WHERE id='$_POST[id]'");
		?>
		<table class="table">
			<thead>
				<th>Group</th>
				<th>Analisis</th>
				<th>Specimen</th>
				<th width="50px">#</th>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y' AND id_unit='$_SESSION[id_units]'");
				while($r=pg_fetch_array($tampil)){
					if($r['id_lab_analysis_group']!=NULL){
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
						?>
						<tr>
							<td colspan="3"><?php echo $a['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
						$lab_analysis=pg_query($dbconn,"SELECT a.nama, a.id_lab_specimen FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$r[id_lab_analysis_group]'");
						while($l=pg_fetch_array($lab_analysis)){
							$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$l[id_lab_specimen]'"));
							echo"
							<tr>
								<td></td>
								<td>$l[nama]</td>
								<td>$s[nama]</td>
								<td></td>
							</tr>
							";
						}
						?>
						<?php
					}
					else{
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, id_lab_specimen FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
						$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$a[id_lab_specimen]'"));
						?>
						<tr>
							<td></td>
							<td><?php echo $a['nama'];?></td>
							<td><?php echo $s['nama'];?></td>
							<td>
								<button class="btn btn-danger btn-xs btnHapusPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
			$(function () {
				$('.btnHapusPesanAnalysis').click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
						var id=this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						$.ajax({
							type: "POST",
							url: "aksi-hapus-pesan-analysis",
							data: dataString,
							cache: false,
							success: function(data){
								$("#data_laborder_kanan").html(data);
							}
						});
					}
					else{
						return false;
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='laborder' AND $act=='view'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id='$_POST[id]'"));
		$id_pasien=$d['id_pasien'];
		$id_kunjungan=$d['id_kunjungan'];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$d[id_priority]'"));
		$nama_prioritas=$a['nama'];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$d[id_refered_by]'"));
		$nama_perujuk=$a['nama'];
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$d[id_reply_to]'"));
		$nama_penjawab=$a['nama'];
		
		$tgl_request=DateToIndo2($d['tgl_request']);
		$tgl_awal=DateToIndo2($d['tgl_awal']);
		$tgl_akhir=DateToIndo2($d['tgl_akhir']);
		
		$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_unit_lab WHERE id='$d[id_unit_lab]'"));
		$nama_laboratium=$a['nama'];
		
		
		
		?>
		<div class="card">
			<div class="card-header">
				<strong>Detail Lab Order</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td width="150px">Ke</td><td width="10px">:</td><td><?php echo $nama_laboratium;?></td>
							</tr>
							<tr>
								<td>Prioritas</td><td>:</td><td><?php echo $nama_prioritas;?></td>
							</tr>
							<tr>
								<td>Analisis</td><td>:</td>
								<td>
									<table class="table">
									<thead>
										<tr>
											<th>No.</th>
											<th>Group</th>
											<th>Analisis</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$no=1;
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder_detail WHERE id_lab_order='$d[id]' AND id_unit='$_SESSION[id_units]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id_lab_analysis_group']!=NULL){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$r[id_lab_analysis_group]'"));
											?>
											<tr>
												<td width="20px"><?php echo $no;?></td>
												<td colspan="2"><?php echo $a['nama'];?></td>
											</tr>
											<?php
											$lab_analysis=pg_query($dbconn,"SELECT a.nama, a.id_lab_specimen FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$r[id_lab_analysis_group]'");
											while($l=pg_fetch_array($lab_analysis)){
												$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$l[id_lab_specimen]'"));
												echo"
												<tr>
													<td></td>
													<td></td>
													<td>$l[nama]</td>
												</tr>
												";
											}
											?>
											<?php
										}
										else{
											$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, id_lab_specimen FROM lab_analysis WHERE id='$r[id_lab_analysis]'"));
											$s=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen WHERE id='$a[id_lab_specimen]'"));
											?>
											<tr>
												<td width="20px"><?php echo $no;?></td>
												<td></td>
												<td><?php echo $a['nama'];?></td>
											</tr>
											<?php
										}
										$no++;
									}
									?>
									</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>Dirujuk Oleh</td><td>:</td><td><?php echo $nama_perujuk;?></td>
							</tr>
							<tr>
								<td>Dijawab Oleh</td><td>:</td><td><?php echo $nama_penjawab;?></td>
							</tr>
							<tr>
								<td>Tgl/Jam Request</td><td>:</td><td><?php echo "$tgl_request $d[jam_request]";?></td>
							</tr>
							<tr>
								<td>Keterangan Rujukan</td><td>:</td><td><?php echo $d['ket_rujukan'];?></td>
							</tr>
							<tr>
								<td>Anamesa</td><td>:</td><td><?php echo $d['anamesa'];?></td>
							</tr>
							<tr>
								<td>Medicine</td><td>:</td><td><?php echo $d['medicine'];?></td>
							</tr>
							<tr>
								<td>Dosis</td><td>:</td><td><?php echo $d['dosis'];?></td>
							</tr>
							<tr>
								<td>Tgl Awal</td><td>:</td><td><?php echo $tgl_awal;?></td>
							</tr>
							<tr>
								<td>Tgl Akhir</td><td>:</td><td><?php echo $tgl_akhir;?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="button" class="btn btn-default btn-sm" id="btnBatalLaborder">Kembali</button>
			</div>
		</div>
		
		
		<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
		<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
		<script>
		$('#btnBatalLaborder').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			$.ajax({
				type: "POST",
				url: "data-pasien-laborder",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_laborder").html(data);
				}
			});
		});
		</script>
		<?php
	}
	elseif($module=='laborder' AND $act=='edit'){
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id='$_POST[id]'"));
		?>
		<div class="card">
			<div class="card-header">
				<strong>Edit</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Referensi</legend>
							<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
							<input type="hidden" name="id_pasien" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
							<input type="hidden" name="id_laborder" id="id_laborder" value="<?php echo $d['id'];?>">
							
							<div class="form-group row">
								<label class="col-md-1">Lab. </label>
								<div class="col-md-3">
									<select name="id_unit_lab" id="id_unit_lab" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_unit_lab");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
								
								<label class="col-md-1">Dirujuk Oleh</label>
								<div class="col-md-3">
									<select name="id_refered_by" id="id_refered_by" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT id, nama FROM master_karyawan WHERE id_jabatan='1' ORDER BY nama");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
								
								<label class="col-md-1">Dibalas Ke-</label>
								<div class="col-md-3">
									<select name="id_reply_to" id="id_reply_to" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT id, nama FROM master_karyawan WHERE id_jabatan='1' ORDER BY nama");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-1">No. Ref</label>
								<div class="col-md-3">
									<input type="text" name="no_referensi" id="no_referensi" class="form-control" placeholder="No. Referensi">
								</div>

								<label class="col-md-1">Prioritas</label>
								<div class="col-md-3">
									<select name="id_priority" class="form-control" id="id_priority">
										<?php
										$tampil=pg_query($dbconn,"SELECT id, nama FROM master_laborder_priority");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
								
								<label class="col-md-1">Catatan</label>
								<div class="col-md-3">
									<textarea name="catatan" id="catatan" class="form-control"></textarea>
								</div>
							</div>
						</fieldset>
					</div>
					
					
					<div class="col-md-6">
						<fieldset>
							<legend>Anamesa</legend>
							<div class="form-group row">
								<label class="col-md-5">Tanggal/Jam Permohonan</label>
								<div class="col-md-3">
									<input type="text" name="tgl_request" id="tgl_request" class="form-control date">
								</div>
								<div class="col-md-4">
									<input type="time" name="jam_request" id="jam_request" class="form-control">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-md-6">
									<label>Catatan Rujukan</label>
									<textarea name="ket_rujukan" class="form-control" id="ket_rujukan"></textarea>
								</div>
								<div class="col-md-6">
									<label>Anamesa</label>
									<textarea name="anamesa" class="form-control" id="anamesa"></textarea>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-md-6">

						<div class="form-group">
							<fieldset>
								<legend>Medicine</legend>
								<div class="form-group row">
									<label class="col-md-2">Medicine</label>
									<div class="col-md-4">
										<input type="text" name="medicine" id="medicine" class="form-control">
									</div>
									
									<label class="col-md-2">Dosis</label>
									<div class="col-md-4">
										<input type="text" name="dosis" id="dosis" class="form-control">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-md-2">Tgl Awal</label>
									<div class="col-md-4">
										<input type="text" name="tgl_awal" id="tgl_awal" class="form-control date">
									</div>
									
									<label class="col-md-2">Tgl Akhir</label>
									<div class="col-md-4">
										<input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control date">
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanLaborder">Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" id="btnBatalLaborder">Batal</button>
					</div>
				</div>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});
		
		$('#btnSimpanLaborder').click(function()
		{
			var id_laborder=$("#id_laborder").val();
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			
			var id_refered_by=$("#id_refered_by").val();
			var id_reply_to=$("#id_reply_to").val();
			var id_unit_lab=$("#id_unit_lab").val();
			var no_referensi=$("#no_referensi").val();
			var id_priority=$("#id_priority").val();
			var catatan=$("#catatan").val();
			var tgl_request=$("#tgl_request").val();
			var jam_request=$("#jam_request").val();
			var ket_rujukan=$("#ket_rujukan").val();
			var anamesa=$("#anamesa").val();
			var medicine=$("#medicine").val();
			var dosis=$("#dosis").val();
			var tgl_awal=$("#tgl_awal").val();
			var tgl_akhir=$("#tgl_akhir").val();
			
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_refered_by='+id_refered_by+'&id_reply_to='+id_reply_to+'&no_referensi='+no_referensi+'&id_priority='+id_priority+'&catatan='+catatan+'&tgl_request='+tgl_request+'&jam_request='+jam_request+'&ket_rujukan='+ket_rujukan+'&anamesa='+anamesa+'&dosis='+dosis+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir+'&medicine='+medicine+'&id_unit_lab='+id_unit_lab+'&id_laborder='+id_laborder;
			
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			$.ajax({
				type: "POST",
				url: "aksi-edit-pasien-laborder",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanLaborder").val('Submitting...');},
				success: function(data){
					$("#data_laborder").html(data);
				}
			});
		});
		
		$('#btnBatalLaborder').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			$.ajax({
				type: "POST",
				url: "data-pasien-laborder",
				data: dataString2,
				cache: false,
				success: function(data){
					$("#data_laborder").html(data);
				}
			});
		});
		
		
		</script>
		<?php
	}
	
	elseif($module=='laborder' AND $act=='update'){
		pg_query($dbconn,"UPDATE pasien_laborder SET id_refered_by='$_POST[id_refered_by]', id_reply_to='$_POST[id_reply_to]', no_referensi='$_POST[no_referensi]', id_priority='$_POST[id_priority]', id_user='$_SESSION[login_user]', ket_rujukan='$_POST[ket_rujukan]', anamesa='$_POST[anamesa]', medicine='$_POST[medicine]', dosis='$_POST[dosis]', id_unit_lab='$_POST[id_unit_lab]', catatan='$_POST[catatan]', tgl_request='$_POST[tgl_request]', jam_request='$_POST[jam_request]', tgl_awal='$_POST[tgl_awal]', tgl_akhir='$_POST[tgl_akhir]' WHERE id='$_POST[id_laborder]'");
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<div class="card">
			<div class="card-header">
				<strong>Data Lab Order</strong>
				<span class="pull-right">
					<?php
					if($id_kunjungan!=''){
						?>
						<button type="button" class="btn btn-primary btn-sm btnTambahLaborder">Tambah</button>
						<?php
					}
					else{
					?>
						<button type="button" class="btn btn-primary btn-sm btnTambahLaborder" disabled>Tambah</button>
					<?php
					}
					?>
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<table class="table" id="myTable3">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="100px">No. Referensi</th>
									<th>Dirujuk Oleh</th>
									<th>Dibalas Ke</th>
									<th>Prioritas</th>
									<th>Catatan</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
										$nama_prioritas=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
										$dirujuk_oleh=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));
										$dibalas_oleh=$a['nama'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $r['no_referensi'];?></td>
											<td><?php echo $dirujuk_oleh;?></td>
											<td><?php echo $dibalas_oleh;?></td>
											<td><?php echo $nama_prioritas;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-primary btn-xs btnViewLaborder" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
												<button class="btn btn-info btn-xs btnEditLaborder" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLaborder" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
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
				</div>
			</div>
		</div>
		
		
		<script type="text/javascript" src="assets/js/datatable_code_ajax.js"></script>
		<script type="text/javascript">
			$(function () {
				$('.btnTambahLaborder').click(function()
				{
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-laborder',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				$(".btnViewLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
					$.ajax({
						type: 'POST',
						url: 'view-pasien-laborder',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
				
				
				$(".btnHapusLaborder").click(function(){
					if(window.confirm("Apakah Anda yakin ingin menghapus laborder ini?")){
						var id = this.id;
						var id_pasien=$("#id_pasien").val();
						var id_kunjungan=$("#id_kunjungan").val();
						var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
						
						$.ajax({
							type: 'POST',
							url: 'aksi-hapus-pasien-laborder',
							data: dataString2,
							success: function(msg){
								$("#data_laborder").html(msg);
							}
						});
					}
					else{
						return false;
					}
				});
				
				$(".btnEditLaborder").click(function(){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
					$.ajax({
						type: 'POST',
						url: 'edit-pasien-laborder',
						data: dataString2,
						success: function(msg){
							$("#data_laborder").html(msg);
						}
					});
					
				});
			});
			</script>
		<?php
		
	}
	pg_close($dbconn);
}
?>