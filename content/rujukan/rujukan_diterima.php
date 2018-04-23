<?php

switch($_GET['act']){
	
default:

if(isset($_POST['tanggal_awal'])){
	$tanggal_awal=$_POST['tanggal_awal'];
	$tanggal_akhir=$_POST['tanggal_akhir'];
}
else{
	$tanggal_awal="01-$bln_sekarang-$thn_sekarang";
	$tanggal_akhir="$tgl_skrg-$bln_sekarang-$thn_sekarang";
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Rujukan Laboratorium</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Rujukan Diterima
							
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
							<div class="form-group row">
									<label class="col-md-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">
									<input type="text" class="form-control" id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>">
									</div>
									
									<label class="col-md-2 form-control-label">Sampai Tanggal</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								</div>
							</form>

							<table class="table" id="myTable">
								<thead>
									
										<th>Kode</th>
										<th>Cabang</th>
										<th>Tanggal</th>
										<th>Status</th>										
										<th width="70px">#</th>
									
								</thead>
								<tbody>
									 <?php
									 $que="Select * from pasien_rujukan pr
									 where pr.id_cabang_dirujuk='$_SESSION[id_units]' ";
									 if(isset($_POST['cari'])){
									 	$que.=" AND pr.tanggal BETWEEN '$tanggal_awal2' AND '$tanggal_akhir2'";
									 }
									 else{
									 	$que.=" order by pr.id ";
									 }
					                 $res=pg_query($dbconn,$que);
					                 while ($row=pg_fetch_assoc($res)) {
					                 	$q="Select nama, kode from master_unit where id='$row[id_cabang_rujuk]'";
					                 $hasil=pg_fetch_array(pg_query($dbconn,$q));
					                     ?>
					                       <tr>
					                       <td style="vertical-align:middle;"><?php echo $hasil["kode"] ?></td>
					                        <td style="vertical-align:middle;"><?php echo $hasil["nama"] ?></td>
					                         <td style="vertical-align:middle;"><?php echo DateToIndo2($row["tanggal"]); ?></td>
                        					<td>
                        					<?php
	                        					if($row['status_diterima']==2){
												echo $status="<button class='btn btn-xs btn-success' title='diterima'>
																diterima</button>";
											
											}elseif($row['status_diterima']==3){
												echo $status="<button class='btn btn-xs btn-danger' title='ditolak'>
													 ditolak</button>";
													 $disabled="disabled";

											}
											elseif($row['status_diterima']==4){
												echo $status="<button class='btn btn-xs btn-success' title='success'>
													 Hasil</button>";
													 $disabled="disabled";

											}
											else{
												echo $status="<button class='btn btn-xs btn-warning' title='belum proses'>proses</button>";
											}?>
                        					</td>

					                         <td class="text-center" style="vertical-align:middle;">
				                       		<a class="btn btn-warning btn-xs btn-flat btnRujukan" id="<?php echo $row[id] ?>"><i class="fa fa-comment"></i></a>
				                       		<a href="content/rujukan/lab/print.php?id=<?php echo $row[id];?>" target="_blank" class="btn btn-info btn-xs <?php echo  $disabled;?>"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
				                       		<a title="update hasil" class="btn btn-success btn-xs btn-flat btnHasil <?php echo  $a;?> " id="<?php echo $row[id] ?>"><i class="fa fa-sticky-note-o"></i></a>
				                           
                        					</td>
					                        </tr>              
					                 <?php }
					                  ?>
								</tbody>
							</table>
							<!--<h6>TOTAL : <b><?php echo $total; ?></b></h6>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
break;



}
?>
<script>
	
	$(".btnRujukan").click(function(){
			var id=$(this).attr('id');
				$.ajax({
						type: 'POST',
						url: 'content/rujukan/load_rujukan.php?act=view',
						data : {id:id},
						success: function(msg){
							$("#form-modal2").html(msg);
							$("#form-modal2").modal('show'); 
						}
					});
	});
	$(".btnHasil").click(function(){
			var id=$(this).attr('id');
				$.ajax({
						type: 'POST',
						url: 'content/rujukan/rujukan_update_hasil.php',
						data : {id:id},
						success: function(msg){
							$("#form-modal2").html(msg);
							$("#form-modal2").modal('show'); 
						}
					});
				});

</script>