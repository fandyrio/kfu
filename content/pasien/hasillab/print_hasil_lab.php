<!DOCTYPE html>
<html>
<head>
<style>
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}

body{
	width:90%; 
	margin: 0 auto;
	color: #000;
    font-family: calibri;   
   
    
}
.title{
	width: 100%;
	font-size: 20px;
	font-family: calibri;
	text-align: center;
	line-height: 0.1 em;
	text-align: center;
	font-weight: 700;
	padding-top:  20px;
	padding-bottom:  20px;		
}
.alamat{
	width: 100%;
	font-size: 14px;
	font-family: calibri;
	text-align: center;
	line-height: 0.1 em;
	text-align: center;
	font-weight: 700;		
}
.content_card{
	width: 100%;
	font-size: 10px;
	 font-family: calibri;
	 font-weight: bold;
	 height:10px; 
	 text-align: center;
	 margin-bottom: 0px;
	 
}
.garis{
	width: 100%;	
}
#nama_pasien{
	width: 100%;
	font-size: 12px;
	font-family: calibri; 
	font-weight: 100;	
	text-align: left;
	line-height: 0.1 em; 
	margin-bottom: -10px;
	
	
}
#tanggal_lahir{
	width: 100%;
	font-size: 12px;
	font-family: calibri; 
	font-weight: 100;	
	text-align: left;
	line-height: 0.1 em; 

}
#barcode{
	width: 100%;
	font-size: 6px;
	font-family: calibri; 
	font-weight: 100;
	text-align: center;
	margin-bottom: 0;
	
	
}
.logo img{
	 position: fixed;
	left: 55px;
	top: 5px;
	
}
#head_form{
	width: 50%;
	font-size: 12px;
	font-family: calibri; 
	font-weight: 100;	
	text-align: left;
	line-height: 0.1 em; 
	color:#888;
	float:left;

}
#side_form{
	width: 50%;
	font-size: 12px;
	font-family: calibri; 
	font-weight: 600;	
	text-align: right;
	line-height: 0.1 em; 
	color:#888;
	float:right;
	padding-right: 20px;

}
.clear {
    clear: both;
}
#isi_analisis{
	width: 100%;
	font-size: 12px;
	font-family: calibri; 
	font-weight: 100;	
	text-align: left;
	line-height: 0.1 em; 
	color:#000;
	

}
th{
	border-top: 1px solid black;
	border-bottom: 1px solid black;
}
</style>
</head>
<body>
<?php
include '../../../config/fungsi_tanggal.php';
include "../../../config/conn.php";
error_reporting(0);

	//echo $_POST['id_transaksi'];
	$id= $_GET["id"];
	//$id= 14;

	$q="SELECT * from pasien_hasillab  WHERE id='$id' ";
	$a=pg_fetch_array(pg_query($dbconn,$q));
	$waktu_periksa=explode(" ",$a['waktu_input']);
	$id_lab_order =$a['id_laborder'];
	//var_dump($a);

	
	$waktu_periksa=DateToIndo2($waktu_periksa[0]);

	$query="SELECT * from pasien_hasillab_detail  WHERE id_transaksi_invoice_detail='$id' ";
	$v=pg_fetch_array(pg_query($dbconn,$query));
	//var_dump($v);

	$id_lab_analysis=$v['id_lab_analysis'];
	$id_lab_analysis_group=$v['id_lab_analysis_group'];
	$id_pasien=$v['id_pasien'];
	$id_kunjungan=$v['id_kunjungan'];

	$query="SELECT * from master_pasien  WHERE id='$id_pasien' ";
	$view_pasien=pg_fetch_array(pg_query($dbconn,$query));
	$nama_pasien= $view_pasien['nama'];
	$umur= hitung_umur($view_pasien['tanggal_lahir']);
	$id_jenkel = $view_pasien['jenkel'];
	$no_rm = $view_pasien['no_rm'];


	$query="SELECT id_dokter from antrian  WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan'";
	$view_pasien_order=pg_fetch_array(pg_query($dbconn,$query));
	$dokter_pengirim = $view_pasien_order['id_dokter'];

	$query="SELECT nama from master_karyawan  WHERE id='$dokter_pengirim' ";
	$view_dokter=pg_fetch_array(pg_query($dbconn,$query));
	$dokter_pengirim = $view_dokter['nama'];
	
	$query="SELECT nama from master_jenkel  WHERE id='$id_jenkel' ";
	$view_kelamin=pg_fetch_array(pg_query($dbconn,$query));
	$jenis_kelamin = $view_kelamin['nama'];


?>

										
										<div class="body">					
										<div class="title">												
											LABORATORIUM KLINIK	
											<Br>
											KIMIA FARMA
										</div>
										<DIV class="logo"><img src='../../../images/logo_laporan_lab.png'></DIV>	
										<DIV class="garis"><hr></DIV>	
										<div class="alamat">Jl Kebayoran Baru 2 Jakarta</div>
										<DIV class="garis"><hr></DIV>
									
										</div>
										<table id="head_form">
											
											<tr>
												<td style="width:100px;" >Nama Pasien</td>
												<td style="width:10px;">:</td>
												<td><?php echo $nama_pasien;?></td>
											</tr>
											<tr>
												<td>Umur</td>
												<td>:</td>
												<td><?php echo $umur;?></td>
											</tr>
											<tr>
												<td>Jenis Kelamin</td>
												<td>:</td>
												<td><?php echo $jenis_kelamin; ?></td>
											</tr>
											


											
										</table>
										<table id="side_form" >
											<tr>
												<td style="width:100px;"><b>No RM:<?php echo $no_rm; ?></b></td>
												
											</tr>
											<tr>
												<td style="width:150px;"><b>Dr. Pengirim : <?php echo $dokter_pengirim; ?></b></td>
											</tr>
											


											
										</table>
										<div class="clear"></div>
										
								<table class="table" id="isi_analisis">
								<thead>
									<tr>
										
										<th>Group</th>
										<th>Analisis</th>
										<th>Hasil</th>
										<th>Satuan</th>
										<th>Angka Normal</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$no=1;
								$q=pg_query("select * from pasien_hasillab_detail where id_transaksi_invoice_detail='$_GET[id]'");
								//$pld=pg_fetch_assoc($q);
										
									$qp=pg_query("select distinct id_lab_group from pasien_hasillab_detail where id_transaksi_invoice_detail=$_GET[id]");	
									while($pld=pg_fetch_assoc($qp)){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$pld[id_lab_group]'"));
										
										?>
										<tr>
										
											<td colspan="4"><b><?php echo $a['nama'];?></b></td>
										</tr>
										<?php
										$lab_analysis=pg_query($dbconn,"SELECT a.nama, a.satuan, a.id FROM lab_analysis a, lab_analysis_group_detail b WHERE a.id=b.id_lab_analysis AND b.id_lab_analysis_group='$pld[id_lab_group]'");
										while($l=pg_fetch_array($lab_analysis)){
											$refer_r= pg_fetch_array(pg_query($dbconn,"SELECT a.nilai_rendah, a.nilai_tinggi, a.id FROM lab_analisis_referal_range a 
															WHERE a.id_lab_analisis='$l[id]'   AND a.id_jenkel='$id_jenkel' And a.usia_awal <='$umur' or a.usia_akhir >='$umur' "));
															
											$hasil= pg_fetch_array(pg_query($dbconn,"select * from pasien_hasillab_detail where id_detail=$l[id]"));
											
											
											
															
											echo"
											<tr>
												
												<td></td>
												<td>$l[nama]</td>
												<td>$hasil[nilai_hasil] </td>
												<td>$l[satuan]</td>
												<td>$refer_r[nilai_rendah]- $refer_r[nilai_tinggi] </td>";
												?> 
												<td>
											<?php 
											
											if($refer_r[nilai_tinggi]!=NULL AND $refer_r[nilai_rendah]!=NULL ){
												$nilai_tinggi = (int) str_replace(",",".",$refer_r[nilai_tinggi]);
												$nilai_rendah = (int) str_replace(",",".",$refer_r[nilai_rendah]);
												$hasil = (int ) str_replace(",",".",$hasil[nilai_hasil]);
											if( $hasil > $nilai_tinggi){
												echo '<span style="color:red;">High</span>';
											}
											elseif ($hasil <$nilai_rendah){
												
												echo '<span style="green:yellow;">Low</span>';
											}
											else {
											echo '<span style="color:green;">Normal</span>';
											}
											}
											else {
											echo '<span style="color:green;">-</span>';
											}
											
											
											?>
											</td>
											</tr>
										<?php
										}
										?>
										<tr></tr>
										<?php
										
									
								
								}
								$q=pg_query("select * from pasien_hasillab_detail where id_transaksi_invoice_detail=$_GET[id]");
								
									while($pld=pg_fetch_assoc ($q)){
									if($pld['id_lab_group']==NULL){
										
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT id, nama, satuan FROM lab_analysis WHERE id='$pld[id_detail]'"));
										$referal_range= pg_fetch_array(pg_query($dbconn,"SELECT a.nilai_rendah, a.nilai_tinggi, a.id FROM lab_analisis_referal_range a 
															WHERE a.id_lab_analisis='$a[id]'   AND a.id_jenkel='$id_jenkel' And a.usia_awal <='$umur' or a.usia_akhir >='$umur' "));
										
										
										?>
										<tr>
										
											<td colspan="4"></td>
										</tr>
										<tr>
											
											<td><b>-</b></td>
											<td><?php echo $a['nama'];?></td>
											<td><?php echo "$pld[nilai_hasil]";?></td>
											<td><?php echo $a['satuan'];?></td>
											<td><?php echo $referal_range[nilai_rendah] ."-". $referal_range[nilai_tinggi]; ?></td>
											<td>
											<?php 
											if($referal_range[nilai_tinggi]!=NULL AND $referal_range[nilai_rendah]!=NULL ){
												$nilai_tinggi = (int) str_replace(",",".",$referal_range[nilai_tinggi]);
												$nilai_rendah = (int) str_replace(",",".",$referal_range[nilai_rendah]);
												$hasil = (int ) str_replace(",",".",$pld[nilai_hasil]);
											if( $hasil > $nilai_tinggi){
												echo '<span style="color:red;">High</span>';
											}
											elseif ($hasil <$nilai_rendah){
												echo '<span style="green:yellow;">Low</span>';
											}
											else {
											echo '<span style="color:green;">Normal</span>';
											}
											}
											else {
											echo '<span style="color:green;">-</span>';
											}
											
											
											?>
											</td>
											
										</tr>
										<?php
										$no++;
									
									}
								}
									
								
								?>
								</tbody>
								</table>
						
									
										

</body>
</html>