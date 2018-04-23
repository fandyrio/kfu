<?php
error_reporting(0);
session_start();

include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_REQUEST[id]'"));
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


$a=pg_fetch_array(pg_query($dbconn,"SELECT max(id) as id_kunjungan FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y'"));
$id_kunjungan=$a['id_kunjungan'];

$getDataOrderLab=pg_query("SELECT * from data_reservasi_lab where id_kunjungan='$id_kunjungan'");
$jumlahDataOrderLab=pg_num_rows($getDataOrderLab);

?>

<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="no_rm" value="<?php echo $_REQUEST[id];?>" id="no_rm">
<div class="card" id="data_form">
	<div class="card-header">
		<strong>Form Pemeriksaan</strong>
		<span class="pull-right">
			<?php
			if($id_kunjungan!='' && $jumlahDataOrderLab==0){
			?>
			<button type="button" class="btn btn-primary btn-xs btnTambah" title="Tambah">Tambah</button>
			<?php
			}
			?>
		</span>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<p class="title-dark">Data</p>
				<table class="table">
					<thead>
						<tr>
							<th width="30px">No.</th>
							<th width="140px">Tanggal/Jam</th>
							<th width="140px">Lab Rujukan</th>
							<th width="80px">#</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tampil=pg_query($dbconn,"SELECT * FROM data_reservasi_lab WHERE public_id='$d[public_id]' ORDER BY id_kunjungan DESC");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$a=explode(" ",$r['tanggal_input']);
								$tanggal=DateToIndo2($a[0]);
								$jam=$a[1];
								
								
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><a href="#" id="<?php echo $r['id'];?>" class="btnView"><?php echo $r['tanggal'] ;?></a></td>
									<td><a href="#" id="<?php echo $r['id'];?>" class="btnView"><?php echo $r['lab'] ;?></a></td>
									<td>
										<button type="button" class="btn btn-info btn-xs btnView" id="<?php echo $r['id_kunjungan'];?>" title="View"><i class="icon-eye"></i></button>
										<button type="button" class="btn btn-danger btn-xs btnHapus" id="<?php echo $r['id_kunjungan'];?>"><i class="icon-trash" title="Hapus"></i></button>
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
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	$(".btnTambah").click(function(){
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'form-pemeriksaan-add',
			data: dataString2,
			success: function(msg){
				$("#data_form").html(msg);
			}
		});
	});
	
	$(".btnEdit").click(function(){
		var id = this.id;
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'form-edit-pasien-anamnesa',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_anamnesa").html(msg);
			}
		});
	});
	
	
	$('.btnView').click(function()
	{
		var id = this.id;
		var no_rm=$("#no_rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 ='id='+id+'&id_pasien='+id_pasien+'&id_kunjungan='+id;
		//alert(dataString2);
		$.ajax({
			type: 'POST',
			url: 'content/pasien/form/editForm.php',
			data : dataString2,
			success: function(msg){
				$("#data_form").html(msg);
				
			}
		});
		
	});

	$(".btnHapus").click(function()
	{
		var no_rm=$("#no_rm").val();
		var idKunjungan=this.id;
		var ask=confirm("Apakah anda yakin akan menghapus data ini?");
		if(ask==true)
		{
			$.ajax(
			{
				url:'content/pasien/form/deleteRujukan.php',
				data:{idKunjungan:idKunjungan},
				type:'POST',
				success:function()
				{
					alert('Data Berhasil Dihapus');
					$("#data_pasien").load('content/pasien/form/form.php?id='+no_rm);
				},
				error:function()
				{
					alert('Error');
				}
			});
		}
	});


});
</script>