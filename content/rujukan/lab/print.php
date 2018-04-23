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
<!-- onload="window.print()" -->
<body >
<?php
include '../../../config/fungsi_tanggal.php';
include "../../../config/conn.php";
error_reporting(0);

	//echo $_POST['id_transaksi'];
	$id= $_GET["id"];
	//$id= 14;

	$q="SELECT * from pasien_rujukan  WHERE id='$id' ";
	$a=pg_fetch_array(pg_query($dbconn,$q));
		$waktu_periksa=DateToIndo2($a['tanggal']);

	$perujuk=pg_fetch_array(pg_query($dbconn,"SELECT * from master_unit  WHERE id='$a[id_cabang_rujuk]'"));

	$query="SELECT * from pasien_rujukan_detail  WHERE id_rujukan='$id' ";
	$v=pg_fetch_array(pg_query($dbconn,$query));
	//var_dump($v);



	$query="SELECT * from master_pasien  WHERE id='$id_pasien' ";
	$view_pasien=pg_fetch_array(pg_query($dbconn,$query));
	$nama_pasien= $view_pasien['nama'];
	$umur= hitung_umur($view_pasien['tanggal_lahir']);
	$id_jenkel = $view_pasien['jenkel'];
	$no_rm = $view_pasien['no_rm'];



?>

										
										<div class="body">					
										<div class="title">												
											LABORATORIUM KLINIK	
											<Br>
											KIMIA FARMA <?php echo $perujuk['nama'] ?>
										</div>
										<DIV class="logo"><img src='../../../images/logo_laporan_lab.png'></DIV>	
										<DIV class="garis"><hr></DIV>	
										<div class="alamat"><?php echo $perujuk['alamat']; ?></div>
										<DIV class="garis"><hr></DIV>
									
										</div>
										<table id="head_form">
											<tr>
												<td style="width:100px;">Tanggal</td>
												<td style="width:10px;">:</td>
												<td><?php echo $waktu_periksa;?></td>
											</tr>
											<tr>
												<td >Jenis Permintaan</td>
												<td>:</td>
												<td><?php echo $nama_pasien;?></td>
											</tr>
											
											


											
										</table>
										
										<div class="clear"></div>
										
								<table  id="isi_analisis" border="1">
								<thead border="1">
									<tr>
										
										<td style="text-align:center;" rowspan="2">RM</td>
										<td style="text-align:center;" rowspan="2">Tgl Lahir</td>
										<td style="text-align:center;" rowspan="2">Nama Pasien</td>
										<td style="text-align:center;" rowspan="2">Pemeriksaan</td>
										<td style="text-align:center;" rowspan="2">Volume Sampel</td>
										<td style="text-align:center;" colspan="4">Kondisi Sampel Saat Diterima
										<tr>
										<td style="text-align:center;">Dingin</td>
										<td style="text-align:center;">Suhu Kamar</td>
										<td style="text-align:center;">Keruh/Lisis</td>
										<td style="text-align:center;">Lain2</td>
										</tr>
										</td>
									</tr>
								</thead>
								<tbody>
								<?php
								$no=1;
								
										
									$q=pg_query("select * from pasien_rujukan_detail where id_rujukan=$_GET[id]");	
									while($row=pg_fetch_assoc($q)){
										 $jenru= explode("_",$row['jenis_pemeriksaan']);
										// var_dump($jenru);
                      			if($jenru[1]){                      
                  			    $b=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$jenru[1]' order by d.id_detail "));
                       				 $paket= $b[nama_paket]." - ";
                       				
                       			}

										$id_pasien= $row['id_pasien'];
										$query="SELECT nama, no_rm, tanggal_lahir  from master_pasien  WHERE id='$id_pasien' ";
										$view_pasien=pg_fetch_array(pg_query($dbconn,$query));
									?>
									<tr>
									<td><?php echo $view_pasien['no_rm'];?></td>
									<td><?php echo DateToIndo2($view_pasien['tanggal_lahir']);?></td>
									<td><?php echo $view_pasien['nama'];?></td>
									<?php
									
                                        if($jenru[0]=='S'){
                                        	
										$jenis=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
										
											echo '<td>';
												echo $paket.$jenis[nama];
											echo '</td>';	
											
										}
										elseif($jenru[0]=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo  $paket.$a[nama];
											echo '</td>';
										}
										elseif($jenru[0]=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo $paket.$a[nama];
											echo '</td>';
										}
										
                                          ?>
									<!-- <td><?php echo $row['id_detail'];?></td> -->

									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>

									</tr>
									<?php
										
									}
									
								
								?>
								</tbody>
								</table>
						
									
										

</body>
</html>