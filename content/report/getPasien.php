<?php
include "../../config/conn.php";
$tgl_awal=$_POST['start_date'];
$tgl_akhir=$_POST['end_date'];
$id=$_POST['id'];


if($tgl_akhir!="" && $tgl_akhir!="")
{
	$getDataPasien=pg_query("SELECT * from master_pasien where tanggal_edit between '$tgl_akhir' and '$tgl_akhir' and id_unit='$id'");	
}
else
{
	$getDataPasien=pg_query("SELECT * from master_pasien where id_unit='$id'");	
}

$getUnit=pg_query("SELECT * from master_unit where id='$id'");
$fetchUnit=pg_fetch_assoc($getUnit);

/*{
	echo"$fetchDataPasien[nama]";
}*/
?>
<span style="text-align:left"><b><?php echo "DAFTAR PASIEN ".$fetchUnit['nama']; ?></b>

<table class="table" >
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Pasien/ RM</th>
			<th>Jenis Kelamin</th>
			<th>Tempat/tanggal lahir </th>
			<th>Alamat</th>
			<th>No Hp</th>
										
		</tr>
	</thead>
	<tbody>
									<?php
									if(isset($_POST["cari"]))
									{

									
									
									$id_kategori_harga=$_POST["id_kategori_harga"];			
									$tampil=pg_query($dbconn,"SELECT * from antrian a
										WHERE a.id_kategori_harga='".$id_kategori_harga."' 
											AND a.id_unit='$_SESSION[id_units]'");
									}else{
										$tampil=pg_query($dbconn,"SELECT pl.* FROM antrian as pl WHERE pl.id_unit='$_SESSION[id_units]'");									
									}


									
									$no=1;
									$amount = 0;
									while($fetchDataPasien=pg_fetch_assoc($getDataPasien)){
										if($fetchDataPasien['jenkel']==1)					
										{
											$jenkel="Laki - laki";
										}
										else
										{
											$jenkel="Perempuan";
										}
										?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $fetchDataPasien["nama"]." / ".$fetchDataPasien["no_rm"]; ?></td>
											<td><?php echo $jenkel?></td>
											<td><?php echo $fetchDataPasien["tempat_lahir"]." / ".$fetchDataPasien["tanggal_lahir"] ;?></td>
											
											<td><?php echo $fetchDataPasien["alamat"];?></td>
											<td><?php echo $fetchDataPasien["no_handphone"];?></td>
									
										</tr>
										<?php
										$no++;
									}
									?>
								</tbody>
								
							</table>