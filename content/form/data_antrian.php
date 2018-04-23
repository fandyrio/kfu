<?php
session_start();
include "../../config/conn.php";
include "../../config/library.php";
include "../../config/fungsi_tanggal.php";
?>
<div class="card-header">
	<i class="icon-grid"></i> Data
</div>
<div class="card-block">
	<table class="table" id="myTable">
		<thead>
			<tr>
			<th width="50px"></th>
			<th width="160px">Jam Masuk</th>
			<th>No. Antrian</th>
			<th>Nama Pasien / No. RM</th>
			<th>Nama Dokter</th>
			<th>Penjamin</th>
			<th>Detail Segmen</th>
			<th width="100px">#</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
			$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' ORDER BY id_prioritas DESC");
			//$no=1;
			while($r=pg_fetch_array($tampil)){
				$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_dokter]'"));
				$p=pg_fetch_array(pg_query($dbconn,"SELECT nama, no_rm, id FROM master_pasien WHERE id='$r[id_pasien]'"));
				
				$a=explode(" ",$r['waktu_masuk']);
				$tanggal_masuk=DateToIndo2($a[0]);
				
				
				$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
				$nama_kategori_harga=$kh['nama'];
				
				$pr=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_prioritas_pasien WHERE id='$r[id_prioritas]'"));
				
				$prioritas="<button class='btn btn-$pr[warna] btn-xs' title='$pr[nama]'><i class=' fa fa-square'></i></button>";
				
				$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM segmen WHERE id='$r[id_segmen]'"));
									$nama_segmen="<button class='btn btn-$s[warna] btn-xs' title='$s[nama]'><i class='icon-user'></i></button>";
				?>
				<tr>
					<td><?php echo "$prioritas $nama_segmen";?></td>
					<td><?php echo "$tanggal_masuk $a[1]";?></td>
					<td><?php echo $r['no_antrian'];?></td>
					<td><a href="pasien-detail-<?php echo $p['no_rm'];?>"><?php echo "$p[nama] / $p[no_rm]";?></a></td>
					<td><?php echo $k['nama'];?></td>
					<td><?php echo $nama_kategori_harga;?></td>
					<td><?php echo $s['nama'];?></td>
					<td>
						
						<!--<button type="button" rel="tooltip" class="btnLamaAntri btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Lama Antrian" id="<?php echo $r['id'];?>">
							<i class="icon-magnifier"></i>
						</button>-->
						
						<!-- <a href="edit-antrian-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Edit Antrian" data-toggle="tooltip" data-placement="top" title="Edit Antrian"><i class="icon-note"></i></a> -->
						
						<a href="hapus-antrian-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
						
						<a href="keuangan-customer-billing-<?php echo "$p[no_rm]";?>" class="btn btn-success btn-xs"  title="Billing" data-toggle="tooltip" data-placement="top"><i class="icon-calculator"></i></a>
						
						<a href="cetak-kartu-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-secondary btn-xs" title="Cetak Kartu Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>
						
						<!--<a href="cetak-gelang-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-warning btn-xs" title="Cetak Gelang Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>-->
						
						<a href="cetak-label-lab-pasien-<?php echo "$p[no_rm]-$r[no_antrian]";?>" class="btn btn-info btn-xs" title="Cetak Label Lab Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>
					</td>
				</tr>
				<?php
				//$no++;
			}
			?>
		</tbody>
	</table>
</div>
<script src="assets/js/datatable_code.js"></script>

<script type="text/javascript">
$(document).ready(function(){ 
	$(".btnLamaAntri").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'lama-antrian',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
});
</script>