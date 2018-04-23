<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	$module=$_GET['module'];
	$act=$_GET['act'];

	$id_pasien = $_POST[id_pasien];
	$id_kunjungan = $_POST[id_kunjungan];
	$no_rm = $_POST[no_rm];
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

$id_pasien=$d['id'];


$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];
	if ($module=='hasillab' AND $act=='view'){

		$anamnesa= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_anamnesa where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));

		$fisik= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_fisik where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));


	?>
	<div class="card">

		<div class="card-header">
			<strong>Detail Hasil Pemeriksaan Fisik</strong>
		</div>
		<input type="hidden" id="no_rm" value="<?php echo $no_rm ?>">
		<div class="card-block">
			<div class="row">
				<div class="col-md-12" style="overflow-y: scroll; max-height: 800px;">
					<div class="card-block" id="hasilfisik">
					<div class="row" >
							<div class="col-md-12">
								<table>
				
									
									<tbody>
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
									</tbody>
								</table>
							</div>
						
						</div>
						<br>
					<table class="table">
						<thead>
						
							<th >ITEM PEMERIKSAAN</th>
							<th  class=" text-center">HASIL</th>
					
						</thead>
						
						<tbody>

						<tr id="riwayat1">
							<td><b>Riwayat Kesehatan</b></td>

							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; Keluhan Sekaarang</td>
							<?php
							$rk= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_anamnesa_ksi where id_anamnesa='$anamnesa[id]' and id_anamnesa_ksi='1'"));

							?>
							<td class=" text-center"><?php echo $rk[hasil] ?></td>
						</tr>
						<tr>
							<td><b>Riwayat kesehatan Dahulu</b></td>
							<td class=" text-center"></td>
							
						</tr>
						<?php
							$rkd=pg_query($dbconn, "SELECT * FROM  pasien_anamnesa f
												INNER JOIN pasien_anamnesa_rpd d on d.id_anamnesa=f.id
												INNER JOin anamnesa_rpd fk on fk.id = d.id_anamnesa_rpd
												where d.id_anamnesa='$anamnesa[id]' and f.id='$anamnesa[id]' ");
	
							while($rkd1= pg_fetch_assoc($rkd)){?>
								<tr>
									<td> &nbsp; <?php echo $rkd1[nama] ?></td>
									<td class=" text-center"><?php if($rkd1[hasil]=='N'){echo "TIDAK ADA";}else{ echo "ADA";} ?></td>
								</tr>
							<?php
							}?>
	

						<tr>
							<td><b>Riwayat kesehatan Keluarga</b></td>
							<td class=" text-center">
							</td>
						</tr>
							<?php
							$rpk=pg_query($dbconn, "SELECT * FROM  pasien_anamnesa f
												INNER JOIN pasien_anamnesa_rpk d on d.id_anamnesa=f.id
												INNER JOin anamnesa_rpk fk on fk.id = d.id_anamnesa_rpk
												where d.id_anamnesa='$anamnesa[id]' and f.id='$anamnesa[id]' ");
	
							while($rpk1= pg_fetch_assoc($rpk)){?>
								<tr>
									<td> &nbsp; <?php echo $rpk1[nama] ?></td>
									<td class=" text-center"><?php if($rpk1[hasil]=='N'){echo "TIDAK ADA";}else{ echo "ADA";} ?></td>
								</tr>
							<?php
							}?>


						<tr>
							<td> &nbsp; Penyakit Lain-Lain</td>
							<td class=" text-center">TIDAK ADA</td>
						</tr>

						<tr>
							<td><b>Riwayat Hazard Lingkungan Kerja</b></td>
							<td class=" text-center"></td>
						</tr>
							<?php
							$rhlk=pg_query($dbconn, "SELECT * FROM  pasien_anamnesa f
												INNER JOIN pasien_anamnesa_rhlk d on d.id_anamnesa=f.id
												INNER JOin anamnesa_rhlk fk on fk.id = d.id_anamnesa_rhlk
												where d.id_anamnesa='$anamnesa[id]' and f.id='$anamnesa[id]' ");
	
							while($rhlk1= pg_fetch_assoc($rhlk)){?>
							<tr>
								<td> &nbsp; <?php echo $rhlk1[nama] ?></td>								
								<td class=" text-center"><b><?php if($rhlk1[hasil]=='N'){echo "TIDAK ADA";}else{ echo $rhlk1[hasil1]." Jam/hari Selama ". $rhlk1[hasil2]." Tahun";} ?></b></td>
							</tr>

							<?php
						}
							?>
						
						<tr>
							<td><b>Riwayat Kecelakaan Kerja</b></td>
							<?php
							$kk= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_anamnesa_kk where id_anamnesa='$anamnesa[id]'"));
							?>
							<td class=" text-center"><?php echo $kk[riwayat1]." / ".$kk[riwayat2]." / ".$kk[riwayat3] ?></td>
						</tr>
						<tr>
							<td><b>Kebiasaan</b></td>
							<td class=" text-center"></td>
						</tr>
							<?php
							$keb=pg_query($dbconn, "SELECT * FROM  pasien_anamnesa f
												INNER JOIN pasien_anamnesa_kebiasaan d on d.id_anamnesa=f.id
												INNER JOin anamnesa_kebiasaan fk on fk.id = d.id_anamnesa_kebiasaan
												where d.id_anamnesa='$anamnesa[id]' ");

			

							while($keb1= pg_fetch_assoc($keb)){?>
							<tr>
								<td> &nbsp; <?php echo $keb1[nama] ?></td>								
								<td class=" text-center"><?php if($keb1[hasil]=='N'){echo "TIDAK ADA";}else{ echo $keb1[hasil2]." Kali/minggu ";} ?></td>
							</tr>

							<?php

							}

							?>
						
						<tr>
							<td><b>Pemeriksaan Fisik</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$pf=pg_query($dbconn, "SELECT * FROM pasien_fisik f
												INNER JOIN pasien_fisik_detail d on d.id_pasien_fisik=f.id
												INNER JOin fisik fk on fk.id = d.id_fisik
												where id_pasien_fisik='$fisik[id]' ")	;
							while ($pf3= pg_fetch_assoc($pf)) {?>
								<tr>
									<td> &nbsp; <?php echo $pf3[nama] ?></td>
									<td class=" text-center"><?php echo $pf3[nilai]." ".$pf3[satuan] ?></td>
								</tr>
							<?php
							}

							?>
						<tr>
							<td><b>Mata</b></td>
							<td class=" text-center"></td>
						</tr>
							<?php
							$mata= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_mata where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Buta Warna</td>
							<td class=" text-center">							
								<?php if($mata[butawarna]=='3'){echo "TOTAL";}
									  elseif($mata[butawarna]=='2'){echo "Parsial";}	
									  else{ echo " Tidak ";} ?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Kacamata</td>
							<td class=" text-center">
								<?php if($mata[kacamata]=='Y'){echo "ADA";}
									 	
									  else{ echo " Tidak Ada";} ?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Ketajaman Penglihatan</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Tanpa kacamata</td>
							<td class=" text-center"> <?php echo "OD:".$mata[visus_a_1]." OS: ".$mata[visus_a_2]." OS: ".$mata[visus_a_3] ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Dengan kacamata</td>
							<td class=" text-center"><?php echo "OD:".$mata[visus_b_1]." OS: ".$mata[visus_b_2]." OS: ".$mata[visus_b_3] ?></td>
						</tr>
						<tr>
							<td> &nbsp; Kelainan Mata lain</td>
							<td class=" text-center"><?php echo $mata[kelainan] ?></td>
						</tr>

						<!-- THT -->
						<tr>
							<td><b>THT</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$tht= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_tht where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Telinga</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Bentuk</td>
							<td class=" text-center"><?php 
								if($tht[telinga1_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Lubang Telinga</td>
							<td class=" text-center"><?php 
								if($tht[telinga2_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Membran Tympani</td>
							<td class=" text-center"><?php 
								if($tht[telinga3_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td>&nbsp; Hidung</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Bentuk</td>
							<td class=" text-center"><?php 
								if($tht[hidung1_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Septum</td>
							<td class=" text-center"><?php 
								if($tht[hidung2_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Concha</td>
							<td class=" text-center"><?php 
								if($tht[hidung3_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>

						<tr>
							<td>&nbsp; Tenggorokan</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Faring</td>
							<td class=" text-center"><?php 
								if($tht[tenggorokan1_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Tonsil</td>
							<td class=" text-center"><?php 
								if($tht[tenggorokan2_hasil]=='2'){echo "TIDAK NORMAL";}
								else{ echo " NORMAL ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Lain-lain</td>
							<td class=" text-center"><?php echo $tht[lain-lain] ?></td>
						</tr>


						<tr>
							<td><b>Mulut</b></td>
							<td class=" text-center"></td>
							<?php
							$mulut= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_mulut where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						</tr>
						<tr>
							<td> &nbsp; Orat Hygiene</td>
							<td class=" text-center"><?php 
									 if($mulut[oral_hasil]=='3'){echo "Kurang";}
									  elseif($mulut[oral_hasil]=='2'){echo "Cukup";}	
									  else{ echo " Baik ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Lidah</td>
							<td class=" text-center">
								<?php if($mulut[lidah_hasil]=='2'){echo "Tidak Normal";}
									  else{ echo " Normal ";} ?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Gusi</td>
							<td class=" text-center"><?php 
								if($mulut[gusi_hasil]=='2'){echo "Tidak Normal";}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Gigi</td>
							<td class=" text-center"><?php echo $mulut[gigi_keterangan] ?></td>
						</tr>

						<!-- LEHER -->
						<tr>
							<td><b>Leher</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$leher= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_leher where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Bentuk </td>
							<td class=" text-center"><?php 
								if($leher[leher1_hasil]=='2'){echo "Tidak Normal ".$leher[leher1_keterangan];}
									  else{ echo " Normal ".$leher[leher1_keterangan];} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Tyroid</td>
							<td class=" text-center"><?php 
								if($leher[leher2_hasil]=='2'){echo "Tidak Normal ".$leher[leher2_keterangan];}
									  else{ echo " Normal ".$leher[leher2_keterangan];} ?></td>
						</tr>

	
						<!-- THORAX -->
						<tr>
							<td><b>Thorax</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$thorax= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_thorax where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Bentuk </td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; Jantung</td>
							<td class=" text-center">
									<?php
									if( ($thorax[cor1_hasil]>1) || ($thorax[cor2_hasil]>1) || ($thorax[cor3_hasil]>1)|| ($thorax[cor4_hasil]>1)){
										echo "TIDAK NORMAL";

									}else{
										echo "NORMAL";

									}

									?>
							</td>
						</tr>
						
						<tr>
							<td> &nbsp; Pulmo </td>
							<td class=" text-center">
									<?php
									if( ($thorax[pulmo1_hasil]>1) || ($thorax[pulmo2_hasil]>1) || ($thorax[pulmo3_hasil]>1)|| ($thorax[pulmo4_hasil]>1)){
										echo "TIDAK NORMAL";

									}else{
										echo "NORMAL";

									}

									?>
							</td>
						</tr>
						


						<tr>
							<td><b>Abdomen</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$abdomen= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_abdomen where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' "));
							?>
						<tr>
							<td> &nbsp; Bentuk </td>
							<td class=" text-center">
							<?php 
								if($abdomen[abdomen1_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen1_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen1_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Palpasi/Perkusi</td>
							<td class=" text-center">
								<?php 
								if($abdomen[abdomen2_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen2_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen2_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Auskultasi </td>
							<td class=" text-center"><?php 
								if($abdomen[abdomen3_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen3_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen3_keterangan];} 
							?></td>
						</tr>
						<tr>
							<td> &nbsp; Hati</td>
							<td class=" text-center">
								<?php 
								if($abdomen[abdomen4_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen4_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen4_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Limpa</td>
							<td class=" text-center">
								<?php 
								if($abdomen[abdomen5_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen5_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen5_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Ginjal</td>
							<td class=" text-center">
								<?php 
								if($abdomen[abdomen6_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen6_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen6_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Test Ketok</td>
							<td class=" text-center">
								<?php 
								if($abdomen[abdomen7_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen7_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen7_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; &nbsp; Ballotemen</td>
							<td class=" text-center"><?php 
								if($abdomen[abdomen8_hasil]=='2'){echo "Tidak Normal ".$abdomen[abdomen8_keterangan];}
									  else{ echo " Normal ".$abdomen[abdomen8_keterangan];} 
							?></td>
						</tr>
						<tr>
							<td> &nbsp; Lain-Lain</td>
							<td class=" text-center"></td>
						</tr>

						<!-- REKTAL -->
						<tr>
							<td><b>Pemeriksaan Rektal</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$rektal= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_rektal where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Haemorrhoid </td>
							<td class=" text-center"><?php
							if($rektal[rektal1_hasil]=='2'){echo "Tidak Normal";}
									  else{ echo " Normal ";} 
							?></td>
						</tr>
						<tr>
							<td> &nbsp; Anus/Rectum/Perianal</td>
							<td class=" text-center"><?php
							if($rektal[rektal2_hasil]=='2'){echo "Tidak Normal";}
									  else{ echo " Normal ";}
							?></td>
						</tr>
						<!--  -->


						<tr>
							<td><b>Extremitas</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$extremitas= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_extremitas where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' "));
							?>
						<tr>
							<td> &nbsp; Tulang/Sendi </td>
							<td class=" text-center">
								<?php 
								if($extremitas[extremitas1_hasil]=='2'){echo "Tidak Normal ".$extremitas[extremitas1_keterangan];}
									  else{ echo " Normal ".$extremitas[extremitas1_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Otot-otot/Tonus</td>
							<td class=" text-center"><?php 
								if($extremitas[extremitas2_hasil]=='2'){echo "Tidak Normal ".$extremitas[extremitas2_keterangan];}
									  else{ echo " Normal ".$extremitas[extremitas2_keterangan];} 
							?></td>
						</tr>
						<tr>
							<td> &nbsp; Jari-jari/kuku </td>
							<td class=" text-center">
								<?php 
								if($extremitas[extremitas3_hasil]=='2'){echo "Tidak Normal ".$extremitas[extremitas3_keterangan];}
									  else{ echo " Normal ".$extremitas[extremitas3_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Tangan</td>
							<td class=" text-center">
								<?php 
								if($extremitas[extremitas4_hasil]=='2'){echo "Tidak Normal ".$extremitas[extremitas4_keterangan];}
									  else{ echo " Normal ".$extremitas[extremitas4_keterangan];} 
							?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; Kaki</td>
							<td class=" text-center">
								<?php 
								if($extremitas[extremitas5_hasil]=='2'){echo "Tidak Normal ".$extremitas[extremitas5_keterangan];}
									  else{ echo " Normal ".$extremitas[extremitas5_keterangan];} 
							?>
							</td>
						</tr>


						<tr>
							<td><b>Neurologis</b></td>
							<td class=" text-center"></td>
						</tr>
						<?php
							$neuro= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_neurologis where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
						<tr>
							<td> &nbsp; Reflex Fisiologis </td>
							<td class=" text-center"><?php 
								if($neuro[neurologis1_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Reflex Patologis </td>
							<td class=" text-center"><?php 
								if($neuro[neurologis2_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Aktifitas Reflex</td>
							<td class=" text-center"><?php 
								if($neuro[neurologis3_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Kekuatan Motorik </td>
							<td class=" text-center"><?php 
								if($neuro[neurologis4_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Kelainan Syaraf/Pusat</td>
							<td class=" text-center"><?php 
								if($neuro[neurologis5_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?></td>
						</tr>
						<tr>
							<td> &nbsp; Kelainan Syaraf/Tepi</td>
							<td class=" text-center">
								<?php 
								if($neuro[neurologis6_hasil]=='2'){echo "Tidak Normal " ;}
									  else{ echo " Normal ";} ?>
							</td>
						</tr>

						<tr>
							<td><b>Pemeriksaan Kulit</b></td>
							<?php
							$kulit= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_kulit where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));
							?>
							<td class=" text-center">
							<?php 	echo $kulit['warna'] ; ?>
									
							</td>
						</tr>
						<tr>
							<td><b>HPHT</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Lingkar Perut</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Lingkar Lengan Atas</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Pemeriksaan Payudara</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; Saran</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Riwayat Epilepsi</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Riwayat Schizophernia termasuk Demensia</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td> &nbsp; Neurologis</td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Starbismus</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Amputasi satu/dua lengan atau satu/dua</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>tungkai dibawah lutut</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Paralisis Atau Deformitas ekstremitas</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Paraplegia atau Kuadriplegia</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Hemiplegi</b></td>
							<td class=" text-center"></td>
						</tr>
						<tr>
							<td><b>Adnexitis</b></td>
							<td class=" text-center"></td>
						</tr>
						</tbody>
						
					</table>
				</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="button" class="btn btn-default btn-sm" id="btnBatalfisik">Kembali</button>
			<div class="pull-right">
				<button class="btn btn-sm btn-success" onclick='printDiv();' >PRINT</button>
			</div>
		</div>
	</div>	
	<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
	<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
	<script>
		$('#btnBatalfisik').click(function()
		{
			var id=$("#no_rm").val();	
	
			$("#data_labhasil").load("content/pasien/hasilfisik/pasien_hasilfisik.php?id="+id);
		
		});



	function printDiv() 
		{

		  var divToPrint=document.getElementById('hasilfisik');
		  


		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Laporan Hasil Pemeriksaan</title>');
		  newWin.document.write(' <link href="assets/css/style.css" rel="stylesheet"></head><body style="background-image: none !important;"  onload="window.print()">');
		  newWin.document.write('<DIV class="logo"><img src="images/logo_laporan_lab.png" style="position: auto;left: 15px;top: 0px;margin-bottom:-10px;"></DIV>	<div style="text-align:center"><h3>Laporan Pemeriksaan</h3></div><div class="table-border table-stripped">');
		  newWin.document.write(divToPrint.innerHTML);

		  newWin.document.write('</div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		}
		</script>
	<?php
	}
	pg_close($dbconn);
}
?>