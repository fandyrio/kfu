<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header("location:keluar");
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	
	$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
	$id_kategori_harga=$_GET['id_kategori_harga'];
	$id_unit=$_SESSION[id_units];
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
	
	$tanggal_awal2=DateToIndo2($tanggal_awal);
	$tanggal_akhir2=DateToIndo2($tanggal_akhir);
	echo"<html>
		<head>
			<style type='text/css'>
				@page { size:A4; margin: 1cm }
									  
				body{
					font-family:Times;
					font-size:14px;
				}
			
				div.box-header{
					text-align:center;
					padding-bottom:20px;
				}
				
				div.box-body{
					font-size:12px;
					clear:both;
					margin-top:30px;
				}
				
				span.title{
					margin:0;
					font-size:14px;
					font-weight:bold;
					display:block;
				}
				
				span.alamat{
					margin:0;
					font-size:12px;
					display:block;
				}
				
				span.telepon{
					font-size:12px;
					display:block;
				}
				
				.alignleft {
					float: left;
					width:33.33333%;
					text-align:left;
				}
				.aligncenter {
					float: left;
					width:33.33333%;
					text-align:center;
				}
				.alignright {
					float: left;
					width:33.33333%;
					text-align:right;
				}​
				
				
				table{
					font-size:14px;
				}
			</style>
			
			<script>
			function myFunction() {
				setTimeout(function () { window.print(); }, 500);
				window.onfocus = function () { setTimeout(function () { window.close(); }, 200); }
			}
			</script>
		</head>
		<body onload='window.print()' onfocus='window.close()'>
			<div class='box-header'>
				<div class='alignleft'>
					<img src='../../images/$setting[logo]' width='60px'>
				</div>
				<div class='aligncenter'>
					<span class='title'>$setting[nama]</span>
					
					<span class='telepon'>Telp. $setting[telepon] Email. $setting[email]</span>
				</div>
				
				<div class='alignright'>
				
				</div>
			</div>
			<div class='box-body'>
				<hr>
					<center>DATA Pasien<br>$tanggal_awal2 s/d $tanggal_akhir2</center>
				<br>
				<table style='width:100%;border-collapse:collapse;'>
					<thead>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:20px;'>No.</th>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center; width:20px;'>Tgl Daftar</th>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Nama Pasien / No. RM</th>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Tempat / Tanggal Lahir</th>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Jenis Kelamin</th>
					<th style='border:1px solid #CCC; padding:4px 8px; text-align:center;'>Kategori Pasien</th>
									
					</thead>
					<tbody>";
						
								
								if($id_kategori_harga==0){
										$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE status_hapus!='Y' AND id_unit='$_SESSION[id_units]'  AND  tanggal_edit BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY id desc");
								}
								else{
									$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE status_hapus!='Y' AND id_unit='$_SESSION[id_units]' AND id_perusahaan='$id_kategori_harga'  AND  tanggal_edit BETWEEN '$tanggal_awal' AND '$tanggal_akhir'ORDER BY id desc");

								}
								

								$no=1;
								while($r=pg_fetch_array($tampil)){
									if($r['foto']!=''){
										$foto="<img src='images/pasien/upload_$r[foto]' class='img-fluid img-thumbnail'>";
									}
									else{
										$foto="<img src='images/default.png' class='img-fluid img-thumbnail'>";
									}
									
									$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenkel WHERE id='$r[jenkel]'"));
									$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_perusahaan]'"));
									
									
									$tanggal_lahir=DateToIndo2($r['tanggal_lahir']);
									
									if($r['tempat_lahir']==''){
										$tempat_lahir="-";
									}
									else{
										$tempat_lahir=$r['tempat_lahir'];
									}
									?>
									<tr>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $no;?></td>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo DateToIndo2($r['tanggal_edit']);?></td>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo "$r[nama] / $r[no_rm]";?></td>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo "$tempat_lahir / $tanggal_lahir";?></td>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $j['nama'];?></td>
										<td style='border:1px solid #CCC; padding:4px 8px; text-align:left;'><?php echo $k['nama'];?></td>
										
									</tr>
									<?php
									$no++;
								}
								?>
							<tbody>
				
					</tbody>
				</table>
			</div>
		</body>
	</html>
<?php
}
?>
