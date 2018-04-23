<?php
session_start();

switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Lab Order</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Lab Order
							
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-1 form-control-label" >Dirujuk Oleh</label>
									<div class="col-sm-2">
										<?php 
										$result =pg_query($dbconn, "SELECT * FROM master_karyawan");
										?>
										<select name='id_dirujuk' class='form-control' required>
											<option value=''>Pilih</option>
											<?php 
											while ($row =pg_fetch_assoc($result)){
											if(isset($_POST["cari"]))
											{
												 
										   		 $id_rujuk=$_POST["id_dirujuk"];
												 if($id_rujuk== $row['id']){
							                          echo "<option value='".$id_rujuk."' selected>".$row['nama']."</option>";
							                        }
							                        else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }									

											}

											 else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }

											}
										?>
										</select>
									</div>
									
									<label class="col-md-1 form-control-label">Dirujuk Kepada</label>
									<div class="col-sm-2">
										<?php 
										$result =pg_query($dbconn, "SELECT * FROM master_karyawan");
										?>
										<select name='id_dirujuk_ke' class='form-control' required>
											<option value=''>Pilih</option>
											<?php 
											while ($row =pg_fetch_assoc($result)){

											if(isset($_POST["cari"]))
											{
												 
										   		$id_rujuk_ke=$_POST["id_dirujuk_ke"];
												 if($id_rujuk_ke== $row['id']){
							                          echo "<option value='".$id_rujuk_ke."' selected>".$row['nama']."</option>";
							                        }
							                        else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }									

											}

											 else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }
												
												
											}
										?>
										</select>
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									<button type="reset" class="btn btn-sm btn-danger" id="resetlaborder"><i class="fa fa-ban"></i> Reset</button></div>
								
							</form>

							<table class="table" id="myTable">
								<thead>
									<tr>
										<th>Tanggal/Jam</th>
										<th>Hari</th>
										<th>laboratorium</th>
										<th>Patien</th>
										<th>Dirujuk Oleh</th>
										<th>Dirujuk Kepada</th>
										<th width="60px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($_POST["cari"]))
									{


																	   
								     if (isset($_POST['id_dirujuk']) && isset($_POST['id_dirujuk_ke'])) {

									    $id_rujuk_ke=$_POST["id_dirujuk_ke"];
									    $id_rujuk=$_POST["id_dirujuk"];
										$tampil=pg_query($dbconn,"SELECT pl.*, mu.nama as \"nama_unit\" FROM pasien_laborder as pl
										Left outer Join master_unit_lab as mu on mu.id=pl.id_unit_lab  
										 WHERE pl.id_unit='$_SESSION[id_units]' AND pl.status_hapus='N' and pl.status_track='Y' and pl.id_refered_by='".$id_rujuk."' and pl.id_reply_to='".$id_rujuk_ke."'  ORDER BY pl.waktu_input ");
											  
									} 
									else{

										$id_rujuk=$_POST["id_dirujuk"];
										$tampil=pg_query($dbconn,"SELECT pl.*, mu.nama as \"nama_unit\" FROM pasien_laborder as pl
									Left outer Join master_unit_lab as mu on mu.id=pl.id_unit_lab  
									 WHERE pl.id_unit='$_SESSION[id_units]' AND pl.status_hapus='N' and pl.status_track='Y' and pl.id_refered_by='".$id_rujuk."' and pl.id_reply_to='".$id_rujuk_ke."'  ORDER BY pl.waktu_input ");		


									}		
									}else{
										$tampil=pg_query($dbconn,"SELECT pl.*, mu.nama as \"nama_unit\" FROM pasien_laborder as pl
									Left outer Join master_unit_lab as mu on mu.id=pl.id_unit_lab  
									 WHERE pl.id_unit='$_SESSION[id_units]' AND pl.status_hapus='N' and pl.status_track='Y'    ORDER BY pl.waktu_input ");
										
									}


									
									$no=1;
									while($r=pg_fetch_array($tampil)){
										$tanggal=DateToIndo2($r['waktu_input']);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$r[id_pasien]'"));
										$nama_pasien=$a['nama'];									

										$h=pg_fetch_array(pg_query($dbconn,"select '".date('Y-m-d')."'::date - '".$r["waktu_input"]."'::date as days "));							
										
										?>
										<tr>
											<td><?php echo "$tanggal $r[jam]";?></td>
											<td><?php echo $h["days"]; ?></td>
											<td><?php echo $r["nama_unit"];?></td>
											<td><?php echo $nama_pasien;?></td>

										<?php 
										$ds=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$r["id_refered_by"]."'"));

										$dk=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$r["id_reply_to"]."'"));  

								
								 			?>
										<td><?php echo $ds["nama"];?></td>
										<td><?php echo $dk["nama"];?></td>

																					<td>
												<a href="view-lab-order-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="View" data-toggle="tooltip" data-placement="top"><i class="icon-eye"></i></a>
												<a href="hapus-track-lab-order-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
												
											</td>
								
										</tr>
										<?php
										$no++;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;

case "hapus":
	$p=pg_query($dbconn,"Update pasien_laborder set status_hapus='Y' WHERE id='$_GET[id]'");



?>
	<script >
		//alert("berhasil dihapus");
		document.location.href = "lab-order";
	</script>



<?php

break;



case "view":

 $v=pg_fetch_array(pg_query($dbconn,"Select * from pasien_laborder WHERE id='$_GET[id]'"));
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"<a href="lab-order">Lab Order</a></li>
	<li class="breadcrumb-item active">Detail</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div id="data_jadwal">

			<div class="card">
				<div class="card-header">
					<div class="col-md-12">
						<strong>View Lab Order</strong>
						<span class="pull-right">
						<?php echo $v["waktu_input"] ?>
						</span>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
							<table class="table">
								<tr>

									<td width="150px">Ke</td>
									<td width="10px">:</td>
									<?php $ul=pg_fetch_array(pg_query($dbconn,"Select * from master_unit_lab WHERE id='".$v["id_unit_lab"]."'")); ?>
									<td><?php echo $ul["nama"];?></td>
								</tr>
								<tr>
									<td>Order Id</td><td>:</td><td><?php echo $v["id"];?></td>
								</tr>
								<tr>
								<?php $lp=pg_fetch_array(pg_query($dbconn,"Select * from master_laborder_priority WHERE id='".$v["id_priority"]."'")); 
									?>
									<td>Priority</td><td>:</td>
									<td>
										<?php echo $lp["nama"];?>
									</td>
								</tr>
								<tr>
									<td>Analisa</td><td>:</td><td>
									<table class="table">
									<thead>
										<tr>
											<th width="100" >Nama</th>
											<th></th>
										</tr>
									</thead>
									<tbody><?php ?>
									<?php 
										
										$q=pg_query("select * from pasien_laborder_detail where id_lab_order=$_GET[id]");


										while($pld = pg_fetch_assoc($q)){
											if($pld['id_lab_analysis']!=NULL){

											$la=pg_fetch_array(pg_query("select * from lab_analysis where id='".$pld["id_lab_analysis"]."'"));									

									?>
							
											<tr>
												
												<td  ><?php echo $la['nama'];?></td>
												<td></td>
												
											</tr>
											<?php
											}
										}
										?>

									<?php 
										$q=pg_query("select * from pasien_laborder_detail where id_lab_order=$_GET[id]");

										while($pld = pg_fetch_assoc($q)){
											if($pld['id_lab_analysis_group']!=NULL){
												

												
											$la=pg_query("select * from lab_analysis_group_detail where  	id_lab_analysis_group='".$pld["id_lab_analysis_group"]."'");

											$lg =pg_fetch_array(pg_query("select * from lab_analysis_group where  	id='".$pld["id_lab_analysis_group"]."'"));

											?>
												<tr>
												<td ><b><?php echo $lg['nama'];?></b></td>
												<td></td>
												
												</tr>
												<?php

											while($lag=pg_fetch_assoc($la)){

												$lagd=pg_fetch_array(pg_query("select * from lab_analysis where id='".$lag["id_lab_analysis"]."'"));

												?>
							
											<tr>
												<td></td>
												<td ><?php echo $lagd['nama'];?></td>
											</tr>
											<?php


											}
										}

										}
										?>
									</tbody>
									</table>	

									</td>
								</tr>
								<tr>
								<?php $ds=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$v["id_refered_by"]."'")); 

								
								 ?>
									<td>Dirujuk Oleh</td><td>:</td><td><?php echo $ds["nama"];?></td>
								</tr>
								<tr>
								<?php $dk=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$v["id_reply_to"]."'")); 


								 ?>
									<td>Dirujuk Kepada</td><td>:</td><td><?php echo $dk["nama"];?></td>
								</tr>
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewLab">Kembali</button>
				</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

<?php
break;

case "cari":

	$id_rujuk=$_POST["id_rujuk"];
	$id_rujuk_ke=$_POST["id_rujuk_ke"];

?>




<?php
break;

}
?>



	<script>
		$('#btnbatalviewLab').click(function()
		{
			document.location.href = "lab-order";

		});

		/*$('#btnCariLab').click(function()
		{
			var data = $('#dirujuk_o').serialize();

			alert(data);
			//document.location.href = "lab-order";

					$.ajax({
						type: 'POST',
						url: 'cari-lab-order',
						data: data,
						cache: false,
						success: function(msg){
							$("#form_tindakan").html(msg);
						}
					});			

		});*/
		$('#resetlaborder').click(function()
		{
			document.location.href = "lab-order";

		});

		</script>
