<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
/*var_dump($_SESSION);*/

if(isset($_SESSION["id_pasien"])){	
	$id_pasien=$_SESSION["id_pasien"];
	$id_kunjungan=$_SESSION["id_kunjungan"];
	$id_kategori_harga=$_SESSION["id_kategori_harga"];
}
elseif($_GET["id_pasien"]){
	$id_pasien=$_POST["id_pasien"];
	$id_kunjungan=$_POST["id_kunjungan"];
	$id_kategori_harga=$_POST["id_kategori_harga"];

}else{
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
	$id_pasien=$d['id'];
	$c=pg_fetch_array(pg_query($dbconn,"SELECT id, id_kategori_harga FROM kunjungan WHERE id_pasien='$id_pasien' "));
	$id_kunjungan=$c['id'];
	$id_kategori_harga =$c['id_kategori_harga'];
	$_SESSION["id_kategori_harga"] = $id_kategori_harga ;

}


?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga;?>" id="id_kategori_harga">
<div id="data_laborder">
	<div class="card">
		<div class="card-header">
			<strong>Data Resep</strong>
			<span class="pull-right">
				
					<button type="button" class="btn btn-primary btn-xs btnTambahLaborder">Tambah</button>
			
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead class="table-secondary">
							<tr>
								<th >Tanggal</th>
								<th>Nama Brand</th>
								<th>Dosis</th>
								<th>Qty</th>
								<th>Tagihan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_resep WHERE id_pasien='$id_pasien' AND status_proses='Y' AND id_kunjungan='$id_kunjungan' ORDER BY id DESC");

														
								
								while($r=pg_fetch_assoc($tampil)){
								
									?>
									<tr>
										<td><?php echo $r['waktu_input']?></td>
										<td><?php echo $r['nama_brand'];?></td>
										<td><?php echo  $r['dosis'];?></td>
										<td><?php echo  $r['qty']?></td>
										<td><?php echo number_format($r['total_cost'],0,'','.')?></td>
										<td>
											<button class="btn btn-danger btn-xs btnHapusResep" id="<?php echo $r['id'];?>" onclick="return confirm('Yakin ingin menghapus data')"><i class="icon-trash"></i></button>
										</td>
									
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	$('.btnTambahLaborder').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var id_kategori_harga=$("#id_kategori_harga").val();
		
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_kategori_harga='+id_kategori_harga;
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-resep',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#data_laborder").html(msg);
			}
		});
		
	});
	$('.btnHapusResep').click(function()
	{
		var id=this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+"&id="+id;
		//alert(dataString2);
			$.ajax({
				type: "POST",
				url: "content/pasien/resep/clear_resep.php",
				data: dataString2,
				success: function(data){
					alert(data);
			
					
					$("#data_pasien").load("resep-pasien1-"+id_pasien+"-"+id_kunjungan);
				}
			});
		
	});
	
});
</script>