<?php


?>

<?php
error_reporting(1);
session_start();

include "../../../../config/conn.php";
include "..././../../config/fungsi_tanggal.php";
include "../../../../config/library.php";

if(isset($_POST['id']))
{
	$no_rm=$_POST['id'];
}
else
{
	$no_rm=$_GET['id'];
}


$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'"));
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


$getIDKunjungan=pg_fetch_assoc(pg_query("SELECT k.*,a.id_dokter from kunjungan k join antrian a on a.id_kunjungan=k.id where k.id_pasien='$d[id]' and k.status_kunjungan='Y'"));
$idKunjungan=$getIDKunjungan['id'];


$a=pg_query($dbconn,"SELECT pd.*,mk.nama as nama_dokter FROM pasien_dokumen pd join master_pasien mp on mp.id=pd.id_pasien 
	join master_karyawan mk on mk.id=pd.id_dokter
	WHERE pd.id_pasien='$d[id]' and pd.id_dokumen='2'");

$jumlahDokumen=pg_num_rows($a);
	
?>
<input type="hidden" name="id" value="<?php echo $d['id'];?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $idKunjungan;?>" id="id_kunjungan">
<div class="card" id="data_fisik">
	<div class="card-header">
		<strong>Surat Keterangan Sehat</strong>
		<span class="pull-right">
			<?php
			if($idKunjungan!=''){
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
				<?php
				if($jumlahDokumen==0)
				{
					echo "Data tidak ada";
				}
				else
				{
					?>
						<table class="table">
					<thead>
						<tr>
							<th width="30px">No.</th>
							<th>No Surat</th>
							<th>Dokter</th>
							<th>Tujuan</th>
							<th>Dibuat Di</th>
							<th>Tanggal Terbit</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no=1;
							while($r=pg_fetch_array($a)){
								$created_at=date('d-F-Y', strtotime($r['created_at']));
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $r['no_surat'] ?></td>
									<td><?php echo $r['nama_dokter'];?></td>
									<td><?php echo $r['tujuan'];?></td>
									<td><?php echo $r['dibuat_di'];?></td>
									<td><?php echo $created_at;?></td>
									<td><a href="content/pasien/dokumen/dokumen_surat/<?php echo $r['nama_file'] ?>"><button class="btn btn-xs btn-primary">Print</button></a></td>
								</tr>
								<?php
								$no++;
							}
						?>
					</tbody>
				</table>

					<?php
				}

				?>
				
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
		var idDokter="<?php echo $getIDKunjungan[id_dokter] ?>";
		var no_rm="<?php echo $no_rm ?>";
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&idDokter='+idDokter+'&no_rm='+no_rm;
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-surat-sehat',
			data: dataString2,
			success: function(msg){
				$("#data_fisik").html(msg);
			}
		});
	});
	
	$(".btnEdit").click(function(){
		var id = this.id;
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'form-edit-pasien-fisik',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_fisik").html(msg);
			}
		});
	});
	
	$(".btnHapus").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus fisik ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-fisik',
				data: { 
					'id': id
				},
				success: function(msg){
					//$("#data_fisik").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'data-pasien-fisik',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#data_fisik").html(msg);
					alert("fisik berhasil dihapus");
				}
			});
		}
		else{
			return false;
		}
	});
	
	$(".btnView").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'view-pasien-fisik',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_fisik").html(msg);
			}
		});
	});
});
</script>