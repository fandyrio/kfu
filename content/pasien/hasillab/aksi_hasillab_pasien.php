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

	if ($module=='hasillab' AND $act=='edit'){
		
		$id_invoice_detail=$_POST['id'];
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		
		?>
		<form id="edit_pasien_hasillab" class="form-horizontal" method="POST">
		<div class="card">
			<div class="card-header">
				<strong>Edit Hasil</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="no_rm" id="no_rm" value="<?php echo $_POST[no_rm];?>">
						<input type="hidden" name="id_laborder" id="id_laborder" value="<?php echo $id_pasien_order;?>">
						<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
						<input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
						<input type="hidden" name="id_invoice_detail" id="id_kunjungan" value="<?php echo $id_invoice_detail;?>">						
					</div>
					
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Jenis Pemeriksaan</th>
									<th>Hasil</th>
									<th>Satuan</th>
									<th>Catatan</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT t.* from lab_order t 
												WHERE t.id_transaksi_invoice_detail='$id_invoice_detail' and jenis='S' ");
								while($r=pg_fetch_array($tampil)){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT t.* from lab_analysis t 
													WHERE t.id='$r[id_detail]' "));

								$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_transaksi_invoice_detail='$id_invoice_detail' AND id_lab_order='$r[id]' AND id_detail='$a[id]' AND jenis_pemeriksaan='S'"));
									?>
									<tr>
											<td><?php echo $a[nama] ?></td>
										 	<td><input type='text' name='nilai_hasil_s#<?php echo $r[id]?>' value='<?php echo $phd[nilai_hasil] ?>' class='form-control'>
											</td>
											<td><?php echo $a[satuan] ?>
											</td>
											<td><input type='text' name='catatan_s#<?php echo $r[id]?>' value='<?php echo $phd[catatan]?>' class='form-control'></td>
											</tr>

									<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="button" class="btn btn-primary btn-sm" id="btnSimpanLabhasil">Simpan</button>
				<button type="button" class="btn btn-danger btn-sm" id="btnBatalLabhasil">Batal</button>
			</div>
		</div>
		</form>

		<script>
		$(function () {
			$('#btnSimpanLabhasil').click(function()
			{
				var data=$("#edit_pasien_hasillab").serialize();
				var no_rm=$("#no_rm").val();
				$.ajax({
					type: "POST",
					url: "aksi-edit-pasien-hasillab",
					data: data,
					success: function(data){
					alert(data);
					
					$("#data_labhasil").load("content/pasien/hasillab/pasien_hasillab.php?id="+no_rm);;
					}
				});
			});
			});	
		
		$(function () {
			$('#btnBatalLabhasil').click(function()
			{
				var no_rm=$("#no_rm").val();
				$("#data_labhasil").load("content/pasien/hasillab/pasien_hasillab.php?id="+no_rm);;
				
			});
		});	
		</script>

		<?php
	}


	/**/
		elseif ($module=='hasillab' AND $act=='update'){

		$id_invoice_detail=$_POST[id_invoice_detail];
		$data=pg_query($dbconn,"SELECT t.* from lab_order t WHERE t.id_transaksi_invoice_detail='$id_invoice_detail' and jenis='S'");
		
		while($d=pg_fetch_array($data)){
			$jh=pg_num_rows(pg_query($dbconn,"SELECT * FROM pasien_hasillab_detail WHERE id_lab_order='$d[id]' and id_transaksi_invoice_detail='$id_invoice_detail' and id_detail='$d[id_detail]' "));

			
			$id_d= $d[id];
			$nilai_hasil=$_POST["nilai_hasil_s#$id_d"];
			$catatan=$_POST["catatan_s#$id_d"];

			if($jh==0){
			pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_lab_order, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan) VALUES ('$d[id]', '$_POST[id_invoice_detail]', '$d[id_detail]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S')");	

			pg_query($dbconn,"UPDATE lab_order set status ='3' WHERE id_transaksi_invoice_detail= '$id_invoice_detail' and id='$id_d' and id_detail='$d[id_detail]' and jenis='S'");

				}
			else{
			pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE id_transaksi_invoice_detail= '$id_invoice_detail' and id_lab_order='$id_d'
													and id_detail='$d[id_detail]' and jenis_pemeriksaan='S'");

			pg_query($dbconn,"UPDATE lab_order set status ='3' WHERE id_transaksi_invoice_detail= '$id_invoice_detail' and id='$id_d' and id_detail='$d[id_detail]' and jenis='S'");

				}


			}
		
		}
			///////////////////////////////////////////////////
	pg_close($dbconn);
}
?>