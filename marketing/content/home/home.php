<?php
switch($_GET['act']){

default:
$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$users[id_karyawan]'"));
$tanggal_login=DateToIndo2($users['tanggal_login']);
$jam_login=$users['jam_login'];
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item active">Beranda</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info">
					<strong>Hi, <?php echo $d['nama'];?>!</strong> Selamat datang di sistem Marketing <?php echo $setting['nama'];?>. Waktu login Anda <?php echo "$tanggal_login $jam_login";?>
				</div>
			</div>
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<!-- /.conainer-fluid -->
<div id="form-modal" class="modal fade melayang2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script type="text/javascript">
	$("#btnTambah").click(function(){
		$.ajax({
			type: 'POST',
			url: 'tambah-transaksi-target',
			data: { 
				
			},
			success: function(msg){
				
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
	$(".btnEdit").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-transaksi-target',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
</script
<?php
break;
}
?>