<?php
include "../../config/conn.php";
$start_date=$_POST['tgl_awal'];
$end_date=$_POST['tgl_akhir'];
?>

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
										$getPasien=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]' and tanggal_edit between '$start_date' and '$end_date'");
										$jumlahPasien=pg_num_rows($getPasien);
										$fetchPasien=pg_fetch_assoc($getPasien);

										$getPasienLaki=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]' and jenkel='1' and tanggal_edit between '$start_date' and '$end_date'");
										$jumlahLaki=pg_num_rows($getPasienLaki);
										$fetchPasienLaki=pg_fetch_assoc($getPasienLaki);

										$getPasienPr=pg_query("SELECT * from master_pasien where id_unit='$fetchUnit[id]' and jenkel='2' and tanggal_edit between '$start_date' and '$end_date'");
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

<script type="text/javascript">
$(".detail").click(function()
{
	var id=this.id;
	var start_date=$("#start_date").val();
	var end_date=$("#end_date").val();
			
	$.ajax(
	{
		url:'content/report/getPasien.php',
		data:{id:id,start_date:start_date,end_date:end_date},
		type:'POST',
		success:function(result)
		{
			$("#printData").html(result);
		}
	});
});	
</script>