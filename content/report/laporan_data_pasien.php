<?php

switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Laporan</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Laporan Data Pasien
							
						</div>
						<div class="card-block">
						<div class="form-horizontal">
						  <form method="post">
							<div class="form-group row" style="display:none;">
								<label class="col-md-2 form-control-label" >Perusahaan</label>
								<div class="col-sm-3">
				                     <?php 
				                      $result =pg_query($dbconn, "SELECT h.* FROM master_kategori_harga h 
				                                INNER JOIN master_unit_perusahaan p ON p.id_perusahaan = h.id 
				                                WHERE p.id_unit='$_SESSION[id_units]'");

				                     ?>

				                      <select name='id_kategori_harga' class='form-control' required>
				                      
				                       <option value=''>Pilih</option>
				                      <?php 
				                      while ($row =pg_fetch_assoc($result)){
				                      	if(isset($_POST["cari"]))
										{
												$id_kategori_harga=$_POST["id_kategori_harga"];
											 if($id_kategori_harga== $row['id']){
						                          echo "<option value='".$data['id_kategori_harga']."' selected>".$row['nama']."</option>";
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

				          
									<!-- <button type="submit" class="btn btn-sm btn-primary" style="margin-right:10px; " name="cari" ><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									
									<button type="reset" class="btn btn-sm btn-danger" id="Lapdatapasien"><i class="fa fa-ban"></i> Reset</button></div> -->
								
				            

							</div>
							<div class="form-group row">
								<label class="col-md-2 form-control-label" >Tanggal Awal</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" id="start_date">
								</div>
								<label class="col-md-2 form-control-label" >Tanggal Akhir</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" id="end_date">
								</div>

							</div>

							</form>
							<hr />
							<div id="printData">
							<table class="table" >
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Outlet</th>
										<th>Laki - Laki</th>
										<th>Perempuan</th>
										<th>Total</th>
										
										
									</tr>
								</thead>
								<tbody>
									
									<?php			
									$no=1;
									$getAllUnit=pg_query("SELECT * from master_unit");
									while($fetchUnit=pg_fetch_array($getAllUnit)){
										$getPasien=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]'");
										$jumlahPasien=pg_num_rows($getPasien);
										$fetchPasien=pg_fetch_assoc($getPasien);

										$getPasienLaki=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]' and jenkel='1'");
										$jumlahLaki=pg_num_rows($getPasienLaki);
										$fetchPasienLaki=pg_fetch_assoc($getPasienLaki);

										$getPasienPr=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]' and jenkel='2'");
										$jumlahPr=pg_num_rows($getPasienPr);
										$fetchPasienPr=pg_fetch_assoc($getPasienPr);

										?>
										<tr>
											<td><?php echo $no ?></td>
											<td id='<?php echo $fetchUnit['id'] ?>' class='detail' style="cursor:pointer;color:blue;"><u><?php echo $fetchUnit["nama"];?></u></td>
											<td><?php echo $jumlahLaki;?></td>
											<td><?php echo $jumlahPr;?></td>
											
											<td><?php echo $jumlahPasien;?></td>
											
									
										</tr>
										<?php
										$no++;
									}
									?>
								</tbody>
								
							</table>
							</div>
							<div class="pull-right">
								<button class="btn btn-sm btn-success" onclick='printDiv();' >
												PRINT
											</button>
							</div>
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
		alert("berhasil dihapus");
		document.location.href = "lab-order";
	</script>



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

		$('#Lapdatapasien').click(function()
		{
			document.location.href = "data-pasien";

		});

		$(".detail").click(function()
		{
			var id=this.id;
			var start_date=$("#start_date").val();
			var end_date=$("#end_date").val();
			
			$.ajax(
			{
				beforeSend:function() { 
						$("#printData").html("<img src='images/load.gif' id='loading-excel' width='100px'/>");
					},
				url:'content/report/getPasien.php',
				data:{id:id,start_date:start_date,end_date:end_date},
				type:'POST',
				success:function(result)
				{
					$("#printData").html(result);
				}

			});
		});	

		$("#start_date").change(function()
		{
			var tgl_awal=$("#start_date").val();
			var tgl_akhir=$("#end_date").val();
			
			if(tgl_awal!="" && tgl_akhir!="")
			{
				
				$.ajax(
				{
					url:'content/report/getDataPasien.php',
					data:{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
					type:'POST',
					success:function(result)
					{
						$("#printData").html(result);
					}
				});
			}
			else
			{
				
			}
		});


		$("#end_date").change(function()
		{
			var tgl_awal=$("#start_date").val();
			var tgl_akhir=$("#end_date").val();
			$("#printData").html();
			if(tgl_awal!="" && tgl_akhir!="")
			{
				
				$.ajax(
				{
					url:'content/report/getDataPasien.php',
					data:{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
					type:'POST',
					success:function(result)
					{
						$("#printData").html(result);
					}
				});
			}
			else
			{
				
			}
		});


	function myFunction() {
		    window.print();
		}

	function printDiv() 
		{

		  var divToPrint=document.getElementById('printData');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write(
		  	'<html><link href="assets/css/style.css" rel="stylesheet"><body onload="window.print()"><div style="font-size:28px; text-align: center;font-weight:bold;">Kimia Farma</div><div style="font-size:18px;margin-bottom:12px; text-align: center;font-weight:bold;">Daftar Pasien</div>'+
		  	'<div class="table-responsive">'+printData.innerHTML+'</div></body></html>');

		  newWin.document.close();
		  
		  var res = window.location;
		  //alert(res);     
		}
		</script>
