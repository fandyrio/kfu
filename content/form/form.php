<?php 
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}

include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_GET[id]'"));
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


$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Form Pemeriksaan</li>
	
</ol>
<div class="container-fluid">
<div class="card" id="data_form">
<div class="card-header">
			<strong>Tambah Form</strong>
		</div>
<div class="card-block" >
	<div class="row" >
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $d['nama'];?></b></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $d['no_rm'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-3">
								<img src="<?php echo $gambar;?>" class="img-fluid img-thumbnail pull-right" width="70px">
							</div>
						</div>
	
	<form id="tambah_pasien" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<input type="hidden" name="no_rm" value="<?php echo $_GET[id];?>" id="no_rm">
		
		<div class="card-block">
			<div class="row" id="formpasien" style="border: 1px solid #FF7F50;" >
				
				<div class="col-md-8" style="background: #2f2f5f; color:#FF7F50;"><h5>HEMATOLOGI</h5></div>
				<div class="col-md-4" style="background: #2f2f5f;color:#FF7F50;"><h5>HEMOSTASIS</h5></div>
				<div class="col-md-2">							
					<table>
					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='1'  order by kode OFFSET 0 LIMIT 15");						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">					
							<table>
							
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='1'  order by kode OFFSET 15 LIMIT 14");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">					
					
					<table>
						
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='1'  order by kode OFFSET 29 LIMIT 15");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>
						
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='1'  order by kode OFFSET 43 ");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">
					
					<table>
					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='3' AND id between '156' AND '168' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]"  class="done" value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">
					
					<table>
					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='3' AND id between '151' AND '155' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]"  class="done" value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-12" style="background: #2f2f5f; color:#FF7F50;"><h5>KIMIA</h5></div>
					<div class="col-md-2">
					
					<table>
					
					<tr><td colspan="3"><b>Fungsi Hati</b></td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '433' AND '448' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">
					
					<table>
					
					<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '431' AND '432' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
					<tr><td colspan="3">Fungsi Ginjal</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '422' AND '429' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						<tr><td colspan="3">Diabetes</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '414' AND '419' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">
					
					<table>
				
					<tr><td colspan="3">PROFIL LEMAK</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '399' AND '409' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">
					
					<table>
					
					<tr><td colspan="3">FUNGSI JANTUNG</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '387' AND '397' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						<tr><td colspan="3">PANKREAS</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '385' AND '386' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>

					<div class="col-md-2">
					
					<table>
					
					<tr><td colspan="3">PROSTAT</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '383' AND '384' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
					<tr><td colspan="3">ELEKTROLIT</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='10'
						 AND id between '376' AND '378' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
				
					
					<div class="col-md-6" style="background: #2f2f5f; color:#FF7F50;"><h5>URIN</h5></div>
					<div class="col-md-2" style="background: #2f2f5f; color:#FF7F50;"><h5>TINJA</h5></div>
					<div class="col-md-4" style="background: #2f2f5f; color:#FF7F50;"><h5>CAIRAN TUBUH</h5></div>
					
					
					<div class="col-md-2">				
					
					<table>
					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='19' AND id BETWEEN '733' AND '738' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>
					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='19' AND id BETWEEN '728' AND '732' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>
					<tr><td colspan="3">Narkoba</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='13' AND id BETWEEN '568' AND '573' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='20' AND id BETWEEN '754' AND '756' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='14' AND id BETWEEN '607' AND '611' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='14' AND id BETWEEN '604' AND '606' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-12" style="background: #2f2f5f; color:#FF7F50;"><h5>IMUNOLOGI</h5></div>
					<div class="col-md-2">				
					
					<table>	
					<tr><td colspan="3">HEPATITIS</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='11' AND id BETWEEN '504' AND '510' AND id<>'511' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
									
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='11' AND id BETWEEN '511' AND '514' AND id<>'511' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
					<tr><td colspan="3">TORCH</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM public.lab_analysis where id_lab_specimen='16'  order by kode OFFSET 1 LIMIT 7 ");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
				
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM public.lab_analysis where id_lab_specimen='16'  order by kode OFFSET 8 ");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
					<tr><td colspan="3">LAIN-LAIN</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM public.lab_analysis where id_lab_specimen='11' and kode like '%73%' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-12" style="background: #2f2f5f; color:#FF7F50;"><h5>SEROLOGI</h5></div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='15' AND id BETWEEN '636' AND '645' AND id<>'511' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
									
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where id_lab_specimen='15' AND id BETWEEN '632' AND '635' AND id<>'511' order by kode");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						<tr><td colspan="3">LAIN-LAIN</td>	</tr>
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%820%' order by kode offset 0 LIMIT 7");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
				
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%820%' order by kode offset 8 LIMIT 2");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
					<tr><td colspan="3">TIROID</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%910%' order by kode offset 0 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
				
					<tr><td colspan="3">FERTILITAS</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%920%' order by kode offset 0 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						<tr><td colspan="3">LAIN-LAIN</td>	</tr>	
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%930%' order by kode offset 0 LIMIT 3");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-2">				
					
					<table>	
				
					<tr><td colspan="3">PETANDA TUMOR</td>	</tr>				
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%940%' order by kode offset 0 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-9" style="background: #2f2f5f; color:#FF7F50;"><h5>ALERGI</h5></div>
					<div class="col-md-3" style="background: #2f2f5f; color:#FF7F50;"><h5>KADAR OBAT</h5></div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1010%' order by kode offset 0 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>	
				
								
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1010%' order by kode offset 9 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>	
				
								
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1010%' order by kode offset 18 LIMIT 9");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>	
				
								
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '111%' order by kode offset 0 LIMIT 7");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-12" style="background: #2f2f5f; color:#FF7F50;"><h5>BAKTERIOLOGI DAN KULTUR RESISTENSI</h5></div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1210%' order by kode offset 0 LIMIT 6");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1210%' order by kode offset 6 LIMIT 7");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1310%' order by kode offset 0 LIMIT 5");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1310%' order by kode offset 6 LIMIT 6");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-6" style="background: #2f2f5f; color:#FF7F50;"><h5>PCR</h5></div>
					<div class="col-md-6" style="background: #2f2f5f; color:#FF7F50;"><h5>PATOLOGI ATONOMI</h5></div>
					<div class="col-md-2">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1510%' order by kode offset 0 LIMIT 3");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1510%' order by kode offset 3 LIMIT 3");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1710%' order by kode offset 0 LIMIT 3");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					<div class="col-md-3">				
					
					<table>					
						<?php
						$tampil=pg_query($dbconn,"SELECT kode, nama FROM lab_analysis where  kode like '%1710%' order by kode offset 0 LIMIT 3");
						
						while($r=pg_fetch_array($tampil)){
							?>
							
									<tr>
									<td><?php echo $r[kode];?></td>									
									<td><input type="checkbox" name="checked_a[]" class="done"  value="<?php echo $r['id'];?>" > </td>
									<td><?php echo $r[nama];?></td>
									</tr>
							<?php
							
						}
						?>
						
						</table>
					
					</div>
					

					
					
		</div>
		
		<div class="card-footer">
			<button type="button" class="btn btn-primary btn-sm btnSimpan">Simpan</button>
			<button type="button" class="btn btn-danger btn-sm btnBatal">Batal</button>
		</div>
	</form>
</div>
</div>
</div>

		<script type="text/javascript">
		
	$('.btnSimpan').click(function(){
		var no_rm=$("#no_rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var keterangan=$("#keterangan").val();
		var file =$("#formpasien").html();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm+'&file='+file;
		
		$.ajax({
					type: 'POST',
					url: 'content/pasien/form/simpan.php',
					data: {file:file, id_pasien:id_pasien, id_kunjungan:id_kunjungan, keterangan:keterangan

						},
					success: function(msg){
						
						document.location.href = "antrian";


					}
				});
		
	});
		
		$(function () {
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			$(".btnBatal").click(function(){
				$.ajax({
					type: 'POST',
					url: 'form-pemeriksaan',
					data: dataString2,
					success: function(msg){
						document.location.href = "antrian";
					}
				});
			});
		});

		$(".done").click (function(){
			
				if ($(this).is(':checked')) {
				
					$( this ).attr( 'checked', true )
				}else{
					$(this).removeAttr('checked');
				}
				});
		</script>