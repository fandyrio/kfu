<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_REQUEST[id]'"));
	$id_pasien=$d['id'];
	$c=pg_fetch_array(pg_query($dbconn,"SELECT id, id_kategori_harga FROM kunjungan WHERE id_pasien='$id_pasien' and status_kunjungan='Y'"));
	$id_kunjungan=$c['id'];
	$id_kategori_harga =$c['id_kategori_harga'];
	$_SESSION["id_kategori_harga"] = $id_kategori_harga ;




?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga;?>" id="id_kategori_harga">
<input type="hidden" name="no_rm" value="<?php echo $_REQUEST[id];?>" id="no_rm">
<div id="data_catat_resep">
	<div class="card">
		<div class="card-header">
			<strong>Data Pencatatan Resep</strong>
			<span class="pull-right">
				<?php 
				if($_SESSION["id_level"]==2 || $_SESSION["id_level"]==4 ){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahCatatResep">Tambah</button>
					<?php 
					//var_dump($_SESSION["id_level"]);
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead class="table-secondary">
							<tr>
								<th>Racikan</th>
								<th>Tanggal</th>
								<th>Nama Brand</th>
								<th>Dosis</th>
								<th>Qty</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_resep_order WHERE id_pasien='$id_pasien' AND status_proses='Y' AND id_kunjungan='$id_kunjungan' ORDER BY id DESC");

														
								
								while($r=pg_fetch_assoc($tampil)){
								
									?>
									<tr>
									<td><input type="checkbox"
										<?php
											if($r["status_racik"]=='Y'){
												echo "checked";
											}
										?>
										disabled ></td>	
										<td><?php echo $r['waktu_input']?></td>
										<td><?php echo $r['nama_brand'];?></td>
										<td><?php echo  $r['dosis'];?></td>
										<td><?php echo  $r['qty']?></td>
										<?php
										if($r['id_kunjungan'])
										?>
										<td>
											<button class="btn btn-danger btn-xs btnHapusResep" id="<?php echo $r['id'];?>" onclick="return confirm('Yakin ingin menghapus data')"><i class="icon-trash"></i></button>
										</td>
										<td>
											<button class="btn btn-primary btn-xs btnPrintResep" id="<?php echo $r['id'];?>">Print</button>
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
<div id="resepToPrint" style="display:none;">
<table>
		<center><h3>R E S E P</h3></center>
<?php
$getData=pg_query("select pro.*, ivo.nama as nama_instruksi from pasien_resep_order pro join inv_intruksi_obat ivo on ivo.id=pro.instruksi1 where pro.id_kunjungan='$id_kunjungan'");
while($fetchData=pg_fetch_assoc($getData))
{
	if($fetchData['status_racik']=='Y')
	{
		$getDataRacikan=pg_query("select * from pasien_resep_order_detail prod where prod.id_pasien_resep_order='$fetchData[id]'");
		echo 
		"<tr>
			<td>$fetchData[nama_brand]</td>
			<td>$fetchData[dosis]</td>
			<td>$fetchData[nama_instruksi]
		</tr>
		";
		while($fetchDataRacikan=pg_fetch_assoc($getDataRacikan))
		{
			echo"
			<tr>
			<td class='col-md-5'>
				$fetchDataRacikan[nama_brand]
			</td>
			<td class='col-md-5'>
				
			</td>
			</tr>
			";
		}
		echo"";
	}
	else
	{
		echo "
		<tr>
			<td>$fetchData[nama_brand]</td>
			<td>$fetchData[dosis]</td>
			<td>$fetchData[nama_instruksi]
		</tr>
		
		";
	}	
	?>
	<?php

}


?>
</table>
</div>
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	$('.btnTambahCatatResep').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var id_kategori_harga=$("#id_kategori_harga").val();
		var no_rm=$("#no_rm").val();
		
		var dataString2 = 'no_rm='+no_rm+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_kategori_harga='+id_kategori_harga;
		$.ajax({
			type: 'POST',
			url: 'tambah-catat-obat',
			data: dataString2,
			cache: false,
			success: function(msg){
				
				$("#data_catat_resep").html(msg);
			}
		});
		
	});

	$(".btnPrintResep").click(function()
	{
	    var divToPrint = document.getElementById('resepToPrint');
       var popupWin = window.open('', '_blank', 'width=500,height=500');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
	});

	$('.btnHapusResep').click(function()
	{
		var id=this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var no_rm=$("#no_rm").val();
		var dataString2 = 'no_rm='+no_rm+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+"&id="+id;
		//alert(dataString2);
			$.ajax({
				type: "POST",
				url: "content/pasien/catatresep/clear_resep.php",
				data: dataString2,
				success: function(data){
			
					
					$("#data_pasien").load("catat-resep1-"+no_rm+"-"+id_kunjungan);
				}
			});
		
	});
	
});
</script>