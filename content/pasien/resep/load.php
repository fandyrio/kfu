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
?>
<div class="modal-dialog modal-md modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="title-form">Load Resep</h6>
				</div>
				<div class="modal-body" id="form-data">
					<table id="example2" class="table">
							<thead>
								<th>Nama</th>
								<th style="text-align: right;">Dosis</th>
								<th>Jumlah</th>
								<th></th>
							</thead>
								<tbody>
								<?php
								$tampil=pg_query($dbconn,"select i.* from pasien_resep_order i where i.id_pasien='".$_POST['id_pasien']."' AND i.id_kunjungan='".$_POST['id_kunjungan']."' AND i.status_proses='Y' ");


								while($r=pg_fetch_array($tampil)){
													?>
									<tr id="<?php echo $r['id'];?>">
										<td><?php echo $r['nama_brand'];?></td>
										<td style="text-align: right;"><?php echo $r['dosis']; ?></td>	
											<td style="text-align: right;"><?php echo $r['qty']; ?></td>	
										<td style="text-align: right;">
										<button class="btn btn-default btn-xs btnInsert" id="<?php echo $r['id'];?>"><i class="fa fa-save"></i></button>
										</td>						
									</tr>
										<?php
											}
										?>
								</tbody>
						</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">close</button>
					
				</div>
			</div>
		</div>
		<script type="text/javascript">	
		$(".btnInsert").click(function(){
		var id=this.id;
		//alert("bri");
		$.ajax({
			type: 'POST',
			url: 'content/pasien/resep/save_load.php',
			data: {id:id},
			success: function(msg){
				$('#form-modal2').modal('toggle');
				$("#data_pasien").load("form-tambah-pasien-resep");			 
			}
		});
	});
	</script>
<?php }
?>