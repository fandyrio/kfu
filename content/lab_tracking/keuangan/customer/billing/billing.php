<?php
switch($_GET['act']){
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Billing</li>
</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<?php
			if($_GET['id_pasien']){
				$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_GET[id_pasien]'"));
				$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);
				
				if($d['jenkel']==1){
					$jenkel="<i class='icon-user'></i>";
					$icon_jenkel="<i class='icon-symbol-male'></i>";
				}
				else{
					$jenkel="<i class='icon-user-female'></i>";
					$icon_jenkel="<i class='icon-symbol-female'></i>";
				}
				
				if($d['foto']!=''){
					$gambar="images/pasien/upload_$d[foto]";
				}
				else{
					$gambar="images/default.png";
				}
				
				$id_pasien=$d['id'];
				$nama_pembayar=$d['nama'];
				$no_handphone=$d['no_handphone'];
				
				$k=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga, id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y' ORDER BY id DESC LIMIT 1"));
				
				
				$id_kategori_harga=$k['id_kategori_harga'];
				$id_kunjungan=$k['id'];
				
			?>
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-user"></i> Billing
					</div>
					<div class="card-block">
						<div class="row">
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
						

						
						<fieldset>
							<legend>Detail Transaksi</legend>
							<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="50px" class="text-center">No.</th>
										<th width="100px" class="text-center">Tanggal</th>
										<th class="text-center">Jenis Pemeriksaan</th>
										<th class="text-center">Detail</th>
										<th class="text-center">Kunjungan</th>
										<th class="text-center">Qty</th>
										<th width="100px" class="text-center">Harga</th>
										<th class="text-center">Sub Total</th>
										<th class="text-center">Penjamin</th>
										<th class="text-center" width="60px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT t.* FROM transaksi_invoice_detail t
										INNER JOIN transaksi_invoice i on i.id=t.id_invoice
									 WHERE t.id_pasien='$id_pasien' AND t.id_kunjungan='$id_kunjungan' AND t.status_aktif='Y' AND t.status_hapus='N' AND i.status_issue is NULL ORDER BY id ASC");

									
									$no=1;
									$total=0;
									$id_invoice = 0;

									

									while($r=pg_fetch_array($tampil)){
										$id_invoice=$r[id_invoice];
										$c=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id='$id_invoice' "));

										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$jam=$a[1];
										?>

										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo "$tanggal";?></td>
											
										<?php
										
										$b=pg_fetch_array(pg_query($dbconn,"SELECT m.nama FROM antrian n
												INNER join segmen m on m.id = n.id_segmen 
												WHERE n.id_pasien='$r[id_pasien]' and n.id_unit = '$_SESSION[id_units]' "));
										$kategori="$b[nama]";

										if($r['jenis']=='E'){
											
											$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail ");

											echo '<td>';
												echo $jenis="MCU";
											echo '</td>';

											echo '<td>';
											$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));
											$nama_transaksi=$h[nama_paket];
											echo $nama_transaksi;
											echo '<ul style="margin:0 auto">';
											while($row=pg_fetch_assoc($a)){
												?>

											<?php	
												
											if($row['jenis']=='L'){
												$l=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
												 echo '<li>'.$l[nama].'</li>';	
												 									
												
											}
											elseif($row['jenis']=='LG'){
												$lg=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
												 echo '<li>'.$lg[nama].'</li>';
												
											}
											else{
												$t=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
												 echo '<li>'.$t[nama].'</li>';
																			
											}	
																							
											}
											echo '</ul>';
											echo '</td>';
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Single Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';	
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Multiple Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										elseif($r['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Non Laboratorium";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}

										elseif($r['jenis']=='O'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_resep a 
												WHERE a.id_pasien='$id_pasien' AND a.id_kunjungan='$id_kunjungan' AND a.status_proses='Y'"));

											$b=pg_fetch_array(pg_query($dbconn,"SELECT  n.nama from inv_inventori i
												left outer join inv_opsi_billing n on n.id = i.id_opsi_billing
												WHERE i.id='".$a["id_inv"]."' "));

											echo '<td>';
												echo $jenis="$b[nama]";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama_brand]";
											echo '</td>';											
										
										}
						
										
										$harga=formatRupiah3($r['harga']);
										$disc_amount=formatRupiah3($r['disc_amount']);
										
										$subtotal=$r['harga']*$r['kuantitas'];
										$total+=$subtotal;
										$subtotal=formatRupiah3($subtotal);
										
										$m_u=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
										
										
										?>
										
											
											<td><?php echo $kategori;?></td>
											<td class="text-right"><?php echo $r['kuantitas'];?></td>
											<td class="text-right"><?php echo $harga;?></td>
											<td class="text-right"><?php echo $subtotal;?></td>
											<td><?php echo $m_u[nama];?></td>
											<td>
											
											<a href="#" class="btn btn-primary btn-xs btnEditBilling <?php
								
												if($c['status_issue']==1){
													echo "disabled";
												}
											
											?> " title="Edit" data-toggle="tooltip" data-placement="top" id="<?php echo $r['id'];?>"  ><i class="icon-note"></i></a>
											<a href="hapus-transaksi-invoice-detail-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs <?php
								
												if($c['status_issue']==1){
													echo "disabled";
												}
											
											?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"  ></i></a>
											</td>
										</tr>
										<?php
										$no++;
									}
									$total2=formatRupiah3($total);
									?>
								</tbody>
							</table>
							</div>
						</fieldset>
						
					<form class="form-horizontal" method="POST" action="aksi-tambah-billing">
							
						<div class="row">
							<div class="col-md-6">
								<?php
								$distc=pg_query($dbconn,"SELECT DISTINCT id_kategori_harga FROM transaksi_invoice_detail WHERE id_invoice='$id_invoice'");
								?>
								<fieldset>
									<legend>Ditagihkan</legend>
									<table class="table">
										<thead>
											<th>Billing Kepada</th>
											<th>Jumlah Bayar</th>
											<th>Diskon</th>
											<th>Harus Bayar</th>
										</thead>
										<tbody>
								<?php
									while($ti=pg_fetch_array($distc)){
										$idh=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$ti[id_kategori_harga]'"));

										$hrg=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id_invoice' and id_kategori_harga='$ti[id_kategori_harga]'");

										$total = 0;
										while($tid= pg_fetch_array($hrg) ){
											$subtotal = $tid['harga']*$tid['kuantitas'];

											$total += $subtotal;
										}
										$ti_id = $ti[id_kategori_harga];

										?>



										<tr id_s="<?php echo $ti_id."_".$total ?>" >
											<td><?php if($ti[id_kategori_harga]=='1'){
												echo $d['nama'];
												

												}else
												{echo $idh[nama];
													}
											echo "<input type='hidden' name='total_bayar_s#$ti_id' value='$total'>";		
											?>
														
											</td>
											<td><?php echo formatRupiah($total) ?></td>
											<td><input type="text" value="0" name="diskon_s#<?php echo $ti_id?>" class="clickable"></td>
											<td><input type="text" value="<?php echo number_format($total,"0","",".") ?>">
											<input type="hidden"  name="sisa_bayar_s#<?php echo $ti_id?>" value="<?php echo $total ?>"></td>
											
										</tr>

										
										

								<?php
									}

							?>

									</tbody>
									</table>
							</fieldset>	
						<!--  -->
						<!--  -->

						<input type="hidden" name="id_invoice" value="<?php echo $id_invoice ?>">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>">
						<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>">
						<div class="row">
							<!-- <div class="col-md-12">
								<fieldset>
									<legend>Total</legend>
									<div class="form-group row">
										<label class="col-md-1">Total</label>
										<div class="col-md-2">
											<input type="text" class="form-control text-right" disabled value="<?php echo $total2;?>">
											<input type="hidden" class="form-control" id="total" value="<?php echo $total;?>" name="total">
										</div>	
									
										 <label class="col-md-1">Diskon</label>
										<div class="col-md-2">
											<input type="text" class="form-control text-right" name="diskon" id="diskon" value="0" min="0" max="<?php echo $total;?>">
										</div>
								
										<label class="col-md-2">Sisa Pembayaran</label>
										<div class="col-md-3">
											<input type="hidden" class="form-control text-right" name="sisa" id="sisa" disabled value="<?php echo $total2;?>">
											<input type="hidden" class="form-control" name="sisa" id="sisa2" value="<?php echo $total;?>">
										</div> 
									</div>
								</fieldset>
							</div> -->
						</div>
						</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-sm btn-primary"
								<?php
								
									
									if($c['status_issue']==1){
										echo"disabled";
									}
								
								?>
								><i class="fa fa-dot-circle-o"></i> Issue Invoice</button>
								<a href="javascript: window.history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Kembali</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
			<?php
			}
			else{
			?>
				
				<?php
				if(isset($_GET['no_rekam_medik'])){
				?>
					<div class="col-sm-8 col-lg-8">
						<div class="card">
							<div class="card-header">
								<i class="icon-layers"></i> Hasil Pencarian
							</div>
							<div class="card-block">
								<table class="table  table-striped" id="myTable">
									<thead>
										<tr class="text-center">
											<th width="50px">No.</th>
											<th>No. Rekam Medis</th>
											<th>No. Kartu BPJS</th>
											<th>Nama</th>
											<th>Tanggal Lahir</th>
											<th>ID Lainnya</th>
										</tr>
									</thead>
									<tbody>
										<?php
										
										$no_rm=$_GET['no_rekam_medik'];
										$no_bpjs=$_GET['no_bpjs'];
										$nama=$_GET['nama'];
										if($_GET['tanggal_lahir']!=''){
											$tanggal_lahir=DateToEng($_GET['tanggal_lahir']);
										}
										else{
											$tanggal_lahir="";
										}
										$id_lainnya=$_GET['id_lainnya'];
										if($no_rm=='' AND $no_bpjs=='' AND $nama=='' AND $tanggal_lahir=='' AND $id_lainnya==''){
											
										}
										else{
											if($no_rm!=''){
												if($no_bpjs!=''){
													if($nama!=''){
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%'");
															}
														}
													}
													else{
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs'");
															}
														}
													}
												}
												else{
													if($nama!=''){
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%'");
															}
														}
													}
													else{
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
															}
														}
													}
												}
											}
											else{
												if($no_bpjs!=''){
													if($nama!=''){
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%'");
															}
														}
													}
													else{
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs'");
															}
														}
													}
												}
												else{
													if($nama!=''){
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%'");
															}
														}
													}
													else{
														if($tanggal_lahir!=''){
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir'");
															}
														}
														else{
															if($id_lainnya!=''){
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE id_lainnya='$id_lainnya'");
															}
															else{
																$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
															}
														}
													}
												}
											}
											$no=1;
											while($r=pg_fetch_array($tampil)){
												$tanggal_lahir=DateToIndo3($r['tanggal_lahir']);
												echo"
												<tr>
													<td>$no</td>
													<td><a href='keuangan-customer-billing-$r[no_rm]'>$r[no_rm]</a></td>
													<td>$r[no_bpjs]</td>
													<td>$r[nama]</td>
													<td>$tanggal_lahir</td>
													<td>$r[id_lainnya]</td>
												</tr>
												";
												$no++;
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php
				}
				else{
				?>
					<div class="col-sm-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<i class="icon-layers"></i> Pasien Dalam Antrian
							</div>
							<div class="card-block">
								<table class="table" id="myTable">
							<thead>
								<tr>
									<th width="160px">Jam Masuk</th>
									<th width="100px">No. Antrian</th>
									<th>Nama Pasien / No. RM</th>
									<th>Nama Dokter</th>
									<th>Kategori Harga</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' ORDER BY id DESC");
								//$no=1;
								while($r=pg_fetch_array($tampil)){
									$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_dokter]'"));
									$p=pg_fetch_array(pg_query($dbconn,"SELECT nama, no_rm FROM master_pasien WHERE id='$r[id_pasien]'"));
									
									$a=explode(" ",$r['waktu_masuk']);
									$tanggal_masuk=DateToIndo2($a[0]);
									
									
									$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
									$nama_kategori_harga=$kh['nama'];
									
									$pr=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_prioritas_pasien WHERE id='$r[id_prioritas]'"));
									
									$prioritas="<button class='btn btn-$pr[warna] btn-xs'><i class=' fa fa-square'></i></button>";
									?>
									<tr>
										<td><?php echo "$prioritas $tanggal_masuk $a[1]";?></td>
										<td><?php echo $r['no_antrian'];?></td>
										<td><a href="keuangan-customer-billing-<?php echo $p['no_rm'];?>"><?php echo "$p[nama] / $p[no_rm]";?></a></td>
										<td><?php echo $k['nama'];?></td>
										<td><?php echo $nama_kategori_harga;?></td>
									</tr>
									<?php
									//$no++;
								}
								?>
							</tbody>
						</table>
							</div>
						</div>
					</div>

				<?php
				}
			}
			?>
		</div>
	</div>
</div>

<div id="form-modal" class="modal fade melayang2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script type="text/javascript">
	function convertToRupiah(angka){
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return rupiah.split('',rupiah.length-1).reverse().join('');
	}


	
	
	$(".btnEditBilling").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-transaksi-invoice-detail',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
	$('#id_metode_bayar').on('change', function() {
		var id=$("#id_metode_bayar").val();
		if(id>1){
			$(".hidden").show();
		}
		else{
			$(".hidden").hide();
		}
	});
	/*$('#diskon').on('input', function() {
		var id=$(this).attr('id_s');
		alert(id);
		var total=parseInt($("#total_bayar_s").val());
		var diskon=parseInt($("#diskon_s").val());
		var sisa = total-diskon;
		if(sisa<0){
			alert("Diskon melebihi harga");
			$("#diskon").val(0);
			$("#sisa").val(total);
			$("#sisa2").val(convertToRupiah(total));
		}
		else{
			var sisa2 = convertToRupiah(total-diskon);
			$("#sisa").val(sisa2);
			$("#sisa2").val(sisa);
			
		}
		return false;
	});*/

	 $('body').on('change', '.clickable', function (){ 
	 		 
              var trid = $(this).closest('tr').attr('id_s');

              var nilai = $.trim(trid).split("_"); // table row ID 
              var tara = $(this).val();

              var total=nilai[1];
        	  var diskon=parseInt($(this).val());

        	  var x = $(this).closest('tr').find("input:eq(1)").val();

			  var sisa = total-diskon;
				if(sisa<0){
					alert("Diskon melebihi harga");
					$(this).val(0);
					var sisa2 = convertToRupiah(sisa);
					$(this).closest('tr').find("input:eq(2)").val("0");
					$(this).closest('tr').find("input:eq(3)").val("0");
					
					
				}
				else{
					var sisa2 = convertToRupiah(sisa);
					$(this).closest('tr').find("input:eq(2)").val(sisa2);
					$(this).closest('tr').find("input:eq(3)").val(sisa);
					
				}
				return false;

               
            });


</script> 
<?php
break;

}
?>
