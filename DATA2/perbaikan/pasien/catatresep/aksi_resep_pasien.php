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
	if ($module=='resep' AND $act=='input'){	
		
		
		$result=pg_query($dbconn,"INSERT INTO pasien_resep_order (id_pasien, tgl_input, status_hapus, id_brand, qty, id_unit) 
			VALUES ('$_POST[id_pasien]', '$tgl_sekarang', 'N', '$_POST[id_brand]', '$_POST[qty]', $_SESSION['id_units']) ) RETURNING id");
		
		
		
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Nama</th>
									<th width="150px">Jumlah</th>
									<th width="70px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query="SELECT p.* FROM pasien_resep p 									
										WHERE p.id_pasien='$id_pasien' AND p.status_hapus='N' AND p.id_unit='$_SESSION[id_units]' ORDER BY p.id DESC";
							//	var_dump($query);	


									$tampil=pg_query($dbconn,$query);

									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['tgl_input']);
										$tanggal=DateToIndo2($a[0]);

										$query_obat="SELECT nama FROM inv_nama_brand WHERE id='".$r[id_brand]."' ";
										//var_dump($query_obat);
										$nama_obat=pg_fetch_array(pg_query($dbconn,$query_obat));

										
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_obat['nama'];?></td>
											<td><?php echo $r['qty'];?></td>
											<td>
												<button class="btn btn-info btn-xs btnEditResep" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<button class="btn btn-info btn-xs btnHapusResep" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											</td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>

		<script type="text/javascript">
$(document).ready(function (e) {
    $('#tambah_pasien_resep').on('submit',(function(e) {
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
				$("#data_resep").html(data);
            },
            error: function(data){
                //console.log("error");
                //console.log(data);
            }
        });
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-resep',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_resep").html(msg);
			}
		});
    }));
});


$(function () {
	
	$(".btnHapusResep").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus resep ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-resep',
				data: dataString2,
				success: function(msg){
					$("#data_resep").html(msg);
				}
			});
			
		}
		else{
			return false;
		}
	});

	//action update resep
	$(".btnEditResep").click(function(){
		
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'form-update-pasien-resep',
				data: dataString2,
				success: function(msg){
					$("#form_resep").html(msg);
				}
			});
			
		
	});
});
$(document).ready(function(){
	$('.js-example-basic-single').select2();
});
</script>
		
	<?php
	}
	
	elseif ($module=='resep' AND $act=='inputform'){
		$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<fieldset>
					<legend>Tambah</legend>
					<form id="tambah_pasien_resep" class="form-horizontal" action="aksi-tambah-pasien-resep" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
						<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
						
						<div class="form-group">
							<label>Daftar Obat</label>
							<select class="js-example-basic-single form-control" name="id_brand" id="id_brand">
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM inv_nama_brand ORDER BY nama");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Qty</label>
							<input name="qty" class="form-control">
						</div>
						<hr>
						<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanResep" <?php if($id_kunjungan==''){echo "disabled";}?>>Simpan</button>
					</form>
				</fieldset>
		
		<script type="text/javascript">
$(document).ready(function (e) {
    $('#tambah_pasien_resep').on('submit',(function(e) {
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
				$("#data_resep").html(data);
            },
            error: function(data){
                //console.log("error");
                //console.log(data);
            }
        });
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-resep',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_resep").html(msg);
			}
		});
    }));
});


$(function () {
	
	$(".btnHapusResep").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-resep',
				data: dataString2,
				success: function(msg){
					$("#data_resep").html(msg);
				}
			});
			
		}
		else{
			return false;
		}
	});

	//action update resep
	$(".btnEditResep").click(function(){
		
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'form-update-pasien-resep',
				data: dataString2,
				success: function(msg){
					$("#form_resep").html(msg);
				}
			});
			
		
	});
});
$(document).ready(function(){
	$('.js-example-basic-single').select2();
});
</script>
	<?php
	}
	
	
	elseif ($module=='resep' AND $act=='delete'){
		
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		pg_query($dbconn,"UPDATE pasien_resep SET status_hapus='Y' WHERE id='$_POST[id]'");
		?>

		<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Nama</th>
									<th width="100px">Jumlah</th>
									<th width="70px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query="SELECT p.* FROM pasien_resep p 									
										WHERE p.id_pasien='$id_pasien' AND p.status_hapus='N'and p.id_unit='$_SESSION[id_units]'  ORDER BY p.id DESC";


									$tampil=pg_query($dbconn,$query);

									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['tgl_input']);
										$tanggal=DateToIndo2($a[0]);

										$query_obat="SELECT nama FROM inv_nama_brand WHERE id='".$r[id_brand]."' ";
										//var_dump($query_obat);
										$nama_obat=pg_fetch_array(pg_query($dbconn,$query_obat));

										
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_obat['nama'];?></td>
											<td><?php echo $r['qty'];?></td>
											<td>
												<button class="btn btn-info btn-xs btnEditResep" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<button class="btn btn-info btn-xs btnHapusResep" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											</td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					
		<script>
			
			
	$(".btnHapusResep").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus resep ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-resep',
				data: dataString2,
				success: function(msg){
					$("#data_resep").html(msg);
				}
			});
			
		}
		else{
			return false;
		}
	});

		</script>
		<?php
	}
	elseif ($module=='tindakan' AND $act=='data_group_tindakan'){
		$tampil=pg_query($dbconn,"SELECT * FROM billing_tindakan WHERE id_billing_group='$_POST[id_group]'");
		while($r=pg_fetch_array($tampil)){
			echo"<option value='$r[id]'>$r[kode] - $r[nama]</td>";
		}
	}
	elseif ($module=='resep' AND $act=='editform'){
		$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$id=$_POST['id'];
		$query="SELECT p.* FROM pasien_resep_order p 									
										WHERE p.id='$id' ";
		$row=pg_fetch_array(pg_query($dbconn,$query));
		//var_dump($_POST);
		?>
		<fieldset>
					<legend>Update</legend>
					<form id="update_pasien_resep" class="form-horizontal" action="aksi-update-pasien-resep" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
						<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
						<input type="hidden" name="id" value="<?php echo $id;?>" id="id">
						
						<div class="form-group">
							<label>Daftar Obat</label>
							<select class="js-example-basic-single form-control" name="id_brand" id="id_brand">
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM inv_nama_brand ORDER BY nama");
								while($r=pg_fetch_array($tampil)){
									if($row['id_brand']==$r['id']){
										echo"<option value='$r[id]' selected>$r[nama]</option>";
									}else 	echo"<option value='$r[id]'>$r[nama]</option>";
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Qty</label>
							<input name="qty" value="<?php echo $row[qty]; ?>" class="form-control">
						</div>
						<hr>
						<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanResep" <?php if($id_kunjungan==''){echo "disabled";}?>>Simpan</button>
						<button  class="btn btn-warning btn-sm" id="btnCancelResep">Batal</button>
					</form>
				</fieldset>
		
		<script>
		$(document).ready(function (e) {
		$('#update_pasien_resep').on('submit',(function(e) {
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
                
				$("#data_resep").html(data);
            },
            error: function(data){
                //console.log("error");
                //console.log(data);
            }
        });
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-resep',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_resep").html(msg);
			}
		});
    }));
		});
		
		$(function () {
			//action update resep
	$(".btnCancelResep").click(function(){
		
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
		
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'id='+id;
			
			$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-resep',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_resep").html(msg);
			}
			});
			
		
	});
		});
		</script>
	<?php
	}
	else if ($module=='resep' AND $act=='update'){	
		
		//var_dump($_POST);
		$result=pg_query($dbconn,"UPDATE pasien_resep_order SET
			id_brand = '$_POST[id_brand]', 
			qty = '$_POST[qty]' where id='".$_POST['id']."'");	
		
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<table class="table">
							<thead>
								<tr>
									<th width="100px">Tanggal</th>
									<th>Nama</th>
									<th width="150px">Jumlah</th>
									<th width="70px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query="SELECT p.* FROM pasien_resep p 									
										WHERE p.id_pasien='$id_pasien' AND p.status_hapus='N' ORDER BY p.id DESC";	


									$tampil=pg_query($dbconn,$query);

									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['tgl_input']);
										$tanggal=DateToIndo2($a[0]);

										$query_obat="SELECT nama FROM inv_nama_brand WHERE id='".$r[id_brand]."' ";
										//var_dump($query_obat);
										$nama_obat=pg_fetch_array(pg_query($dbconn,$query_obat));

										
										?>
										<tr>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $nama_obat['nama'];?></td>
											<td><?php echo $r['qty'];?></td>
											
											<td>
												<button class="btn btn-info btn-xs btnEditResep" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
												<button class="btn btn-info btn-xs btnHapusResep" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											</td>
											
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>

		<script type="text/javascript">
		$(document).ready(function (e) {
		    $('#tambah_pasien_resep').on('submit',(function(e) {
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
						$("#data_resep").html(data);
		            },
		            error: function(data){
		                //console.log("error");
		                //console.log(data);
		            }
		        });
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-resep',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_resep").html(msg);
					}
				});
		    }));
		});


		$(function () {
			
			$(".btnHapusResep").click(function(){
				if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
				
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
					
					$.ajax({
						type: 'POST',
						url: 'aksi-hapus-pasien-resep',
						data: dataString2,
						success: function(msg){
							$("#data_resep").html(msg);
						}
					});
					
				}
				else{
					return false;
				}
			});

			//action update resep
			$(".btnEditResep").click(function(){
				
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var id_kunjungan=$("#id_kunjungan").val();
				
					var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
					
					$.ajax({
						type: 'POST',
						url: 'form-update-pasien-resep',
						data: dataString2,
						success: function(msg){
							$("#form_resep").html(msg);
						}
					});
					
				
			});
		});
		$(document).ready(function(){
			$('.js-example-basic-single').select2();
		});
		</script>
		
	<?php
	}
	
	pg_close($dbconn);
}
?>