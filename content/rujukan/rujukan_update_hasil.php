<?php
 include "../../config/conn.php";
 error_reporting(0);
 switch ($_GET['act']) 
 {
 	default:
 	$id = $_POST["id"];
 	//$row = pg_fetch_array(pg_query($dbconn, "SELECT * FROM pasien_rujukan Where id='$id'"));
 	//var_dump($id);


 	
	?>
	<div class="modal-dialog modal-sm modal-info">
				<div class="modal-content">
				<form id="edit_pasien_hasillab" class="form-horizontal" method="POST">
		<div class="card">
			<div class="card-header">
				<strong>Edit Hasil</strong>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-md-12">
						
					<input type="hidden" class="form-control" name="id_rujukan" value="<?php echo $id;?>">
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
								//var_dump($row);
								$tampil=pg_query($dbconn,"SELECT dr.* from pasien_rujukan_detail dr 
												WHERE dr.id_rujukan='$_POST[id]' and jenis_pemeriksaan='S' ");
								
								while($r=pg_fetch_array($tampil)){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT t.* from lab_analysis t 
													WHERE t.id='$r[id_detail]' "));

								$phd=pg_fetch_array(pg_query($dbconn,"SELECT nilai_hasil, catatan FROM pasien_hasillab_detail WHERE id_lab_order='$r[id_lab_order]' AND id_detail='$r[id_detail]' AND jenis_pemeriksaan='S'"));
									?>
									<tr>
											<td><?php echo $a[nama] ?></td>
										 	<td><input type='text' name='nilai_hasil_s#<?php echo $r[id_lab_order]?>' value='<?php echo $phd[nilai_hasil] ?>' class='form-control'>
											</td>
											<td><?php echo $a[satuan] ?>
											</td>
											<td><input type='text' name='catatan_s#<?php echo $r[id_lab_order]?>' value='<?php echo $phd[catatan]?>' class='form-control'></td>
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
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
			</div>
		</div>
		</form>
			</div>
		</div>


 		<?php
 		break;
 	
 	case 'edit':
 		$id = $_POST["id_rujukan"];
		$data=pg_query($dbconn,"SELECT dr.* from pasien_rujukan_detail dr WHERE dr.id_rujukan='$id' and jenis='S'");
		
		while($d=pg_fetch_array($data)){
			$jh=pg_num_rows(pg_query($dbconn,"SELECT * FROM pasien_hasillab_detail WHERE id_lab_order='$d[id_lab_order]'  and id_detail='$d[id_detail]' "));

			
			$id_d= $d[id_lab_order];
			$nilai_hasil=$_POST["nilai_hasil_s#$id_d"];
			$catatan=$_POST["catatan_s#$id_d"];

			if($jh==0){
			pg_query($dbconn,"INSERT INTO pasien_hasillab_detail (id_lab_order, id_transaksi_invoice_detail, id_detail, id_pasien, id_kunjungan, nilai_hasil, catatan, id_unit, jenis_pemeriksaan) VALUES ('$d[id]', '$_POST[id_invoice_detail]', '$d[id_detail]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', '$nilai_hasil', '$catatan', '$_SESSION[id_units]','S')");	

			pg_query($dbconn,"UPDATE lab_order set status ='3' WHERE id='$id_d' and id_detail='$d[id_detail]' and jenis='S'");
			pg_query($dbconn,"UPDATE pasien_rujukan set status ='4' WHERE  id='$id'");

				}
			else{
			pg_query($dbconn,"UPDATE pasien_hasillab_detail set nilai_hasil ='$nilai_hasil', catatan='$catatan' WHERE  id_lab_order='$id_d' and id_detail='$d[id_detail]' and jenis_pemeriksaan='S'");

			pg_query($dbconn,"UPDATE lab_order set status ='3' WHERE  id='$id_d' and id_detail='$d[id_detail]' and jenis='S'");

				}


			}
 		break;
 }
 
?>

<script>
	$(function () {
			$('#btnSimpanLabhasil').click(function()
			{
				var data=$("#edit_pasien_hasillab").serialize();
				alert(data);
				
				$.ajax({
					type: "POST",
					url: "content/rujukan/rujukan_update_hasil.php?act=edit",
					data: data,
					success: function(data){
					document.location.href = "rujukan-diterima";
					}
				});
			});
	});			
</script>