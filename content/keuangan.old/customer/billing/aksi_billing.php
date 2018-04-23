<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../../config/conn.php";
	include "../../../../config/library.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	if ($module=='keuangan_customer_billing' AND $act=='edit'){
		$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id='$_POST[id]'  ");
		$r=pg_fetch_array($tampil);
		$nama_transaksi="";						
			if($r['jenis']=='E'){
									
				$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail ");
				$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));
				$nama_transaksi=$h[nama_paket];
				}
										
			if($r['jenis']=='S'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
				$nama_transaksi="$a[nama]";
												
				}
			elseif($r['jenis']=='M'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
				$nama_transaksi="$a[nama]";
											
				}
			elseif($r['jenis']=='N'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
				$nama_transaksi="$a[nama]";
											
				}
			elseif($r['jenis']=='O'){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_resep a 
					WHERE a.id_pasien='$id_pasien' AND a.id_kunjungan='$id_kunjungan' AND a.status_proses='Y'"));
				$nama_transaksi="$a[nama_brand]";											
				}	
							
										
		
		$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm FROM master_pasien WHERE id='$r[id_pasien]'"));
		$no_rm=$p['no_rm'];
		
	
		//$k=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$d[id_kunjungan]'"));
		//$id_kategori_harga=$k['id_kategori_harga'];

		?>
		<form action="aksi-edit-transaksi-invoice-detail" id="editBilling" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
		<input type="hidden" name="id_pasien" value="<?php echo $r['id_pasien'];?>">		
		<input type="hidden" name="id_kunjungan" value="<?php echo $r['id_kunjungan'];?>">
		<input type="hidden" name="qty_awal" id="hrg" value="<?php echo $r['kuantitas'];?>">
		<input type="hidden" name="jenis" id="hrg" value="<?php echo $r['jenis'];?>">
		<input type="hidden" name="id_detail" id="hrg" value="<?php echo $r['id_detail'];?>">
		<input type="hidden" name="no_rm" value="<?php echo $no_rm;?>">
		<div class="modal-dialog modal-primary">
			<div class="modal-content">
				<div class="modal-header">
					<b>Edit Billing</b>
				</div>
				<div class="modal-body" id="form-data">

					<div class="form-group row">
						<label class="col-md-2">Item</label>
						<div class="col-md-8">
							<input type="text" disabled class="form-control" value="<?php echo $nama_transaksi;?>">
						</div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 form-control-label" >Perusahaan</label>
					<div class="col-sm-8"><?php										
						$result =pg_query($dbconn, "SELECT u.* FROM master_kategori_harga u 
										 ORDER BY id");

						?>
							<select name='id_kategori_harga' id='id_kategori_harga' class='form-control' required>									
										<?php 
										while ($row =pg_fetch_assoc($result)){
											if($r[id_kategori_harga]==$row['id']){
												echo"<option value='$r[id_kategori_harga]' selected>$row[nama]</option>";
											}
											else{
											echo"<option value='$row[id]'>$row[nama]</option>";
											}									
									}
											?>
							</select>
					</div>	
					</div>							
					<div class="form-group row">
						<label class="col-md-2">Qty</label>
						<div class="col-md-4">
							<input type="number" name="kuantitas"  class="form-control"  value="<?php echo $r['kuantitas']?>" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2">Harga</label>
						<div class="col-md-4">
							<input type="number" name="harga" id="hrg_new"  class="form-control" value="<?php echo $r['harga']?>" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary btn-sm" id="btnSimpan">Simpan</button>
				</div>
			</div>
		</div>
		</form>

		<!--  -->
		<script>
		$('#id_kategori_harga').change(function(){
			var data = $('#editBilling').serialize();
			var id_kat = $('#id_kategori_harga').val();
			

			$.ajax({
              type:'post',
              url :"content/keuangan/customer/billing/split_billing.php",
              data:data,              
                success: function(data) {

                	$('#hrg_new').val(parseInt(data));
                  //window.location.href = 'media.php?inventori=terimabarang';
                },
            	error:function(exception){alert('Exeption:'+exception);}
              })

		});

		</script>

		<!--  -->
		<?php
	}
	
	elseif ($module=='keuangan_customer_billing' AND $act=='update'){

		$qty = $_POST['qty_awal'];
		$qty_akhir = $_POST['kuantitas'];
		$selisih = $qty_akhir-$qty;


		date_default_timezone_set("Asia/Jakarta");
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");

		$r= pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id='$_POST[id]'"));

		if($selisih<=0){
			/*kurang dari awal*/
			$min = abs($selisih);
			$rlo= pg_num_rows(pg_query($dbconn,"SELECT distinct uniq_id from lab_order 
						where id_transaksi_invoice_detail='$_POST[id]' and status <> '1' "));

			$jlh = $qty_akhir-$rlo;

			var_dump($jlh);

			$harga=$min * $_POST[harga] ;

			$rfl= pg_query($dbconn,"SELECT * from lab_order 
						where id_transaksi_invoice_detail='$_POST[id]' and status = '1' ");

			while ($row=pg_fetch_array($rfl)) {
				pg_query($dbconn,"DELETE from lab_order 
						where id_transaksi_invoice_detail='$_POST[id]' and status = '1' and uniq_id='$row[uniq_id]'");

				var_dump("DELETE from lab_order 
						where id_transaksi_invoice_detail='$_POST[id]' and status = '1' and uniq_id='$row[uniq_id]'");
				
			}

		pg_query($dbconn,"UPDATE transaksi_invoice_detail SET kuantitas='$_POST[kuantitas]', harga='$_POST[harga]', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang', id_kategori_harga='$_POST[id_kategori_harga]' WHERE id='$_POST[id]'");

			for($i=0; $i<$jlh; $i++){
				$harga += $_POST[harga];

				if($_POST['jenis']=='S'){
					$uniq = uniqid();
					 pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$uniq' )");



				}
				elseif($_POST['jenis']=='N'){
					$uniq = uniqid();
					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'N', '1','$uniq' )");
				}
				elseif($_POST['jenis']=='M'){
					$uniq = uniqid();
					$ag=pg_query($dbconn,"SELECT g.*, g.id_lab_analysis_group l from lab_analysis_group_detail g
					inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$_POST[id_detail]'");


				while($lg=pg_fetch_assoc($ag))
				{

				pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_pasien]', 'S', '1','$uniq' )");

				
				}
				}
				elseif($_POST['jenis']=='E'){
				$a=pg_query($dbconn,"SELECT  d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$_POST[id_detail]' ");
				$uniq_p = uniqid();

					while($row=pg_fetch_assoc($a)){
					?>

					<?php	
												
					if($row['jenis']=='L'){
					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]','$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$uniq_p' )");

					}
					elseif($row['jenis']=='LG'){
					$ag=pg_query($dbconn,"SELECT g.*, g.id_lab_analysis_group l from lab_analysis_group_detail g
							inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$row[id_detail]'");

						while($lg=pg_fetch_assoc($ag))
							{
					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, id_lab_group, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$lg[id_lab_analysis_group]' ,'$uniq_p')");
						}												
					}
					elseif($row['jenis']=='T'){

					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'T', '1', '$uniq_p' )");

				
						}
					else{

						}
																							
				 }	
				}

			}
			/**/

			//pg_query($dbconn,"UPDATE transaksi_invoice SET total=total-'$harga' WHERE id='$r[id_invoice]'");

		}elseif ($selisih>0) {
			/*tambah*/


			pg_query($dbconn,"UPDATE transaksi_invoice_detail SET kuantitas='$_POST[kuantitas]', harga='$_POST[harga]', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang', id_kategori_harga='$_POST[id_kategori_harga]' WHERE id='$_POST[id]'");

			$harga=0 ;

			for($i=0; $i<$selisih; $i++){
				$harga += $_POST[harga];

				if($_POST['jenis']=='S'){
					$uniq = uniqid();
					 pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$uniq' )");

				}
				elseif($_POST['jenis']=='N'){
					$uniq = uniqid();
					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'N', '1','$uniq' )");
				}
				elseif($_POST['jenis']=='M'){
					$uniq = uniqid();
					$ag=pg_query($dbconn,"SELECT g.*, g.id_lab_analysis_group l from lab_analysis_group_detail g
					inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$_POST[id_detail]'");


				while($lg=pg_fetch_assoc($ag))
				{

				pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_pasien]', 'S', '1','$uniq' )");

				
				}
				}
				elseif($_POST['jenis']=='E'){
				$a=pg_query($dbconn,"SELECT  d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$_POST[id_detail]' ");
				$uniq_p = uniqid();

					while($row=pg_fetch_assoc($a)){
					?>

					<?php	
												
					if($row['jenis']=='L'){
					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$_POST[id_detail]]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]','$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$uniq_p' )");

					}
					elseif($row['jenis']=='LG'){
					$ag=pg_query($dbconn,"SELECT g.*, g.id_lab_analysis_group l from lab_analysis_group_detail g
							inner join lab_analysis l on l.id = g.id_lab_analysis where g.id_lab_analysis_group='$row[id_detail]'");

						while($lg=pg_fetch_assoc($ag))
							{
								pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, id_lab_group, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'S', '1','$lg[id_lab_analysis_group]' ,'$uniq_p')");
						}												
					}
					elseif($row['jenis']=='T'){

					pg_query($dbconn, "INSERT into lab_order (id_transaksi_invoice_detail, id_detail,  waktu_input, id_users, id_pasien, id_kunjungan, jenis, status, uniq_id) values ('$_POST[id]', '$lg[id_lab_analysis]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$r[id_pasien]','$r[id_kunjungan]', 'T', '1', '$uniq_p' )");

				
						}
					else{

						}
																							
				 }	
				}

			}
			/**/

			//pg_query($dbconn,"UPDATE transaksi_invoice SET total=total+'$harga' WHERE id='$r[id_invoice]'");

			/*end tambah*/

		}

		header("location:keuangan-customer-billing-$_POST[no_rm]");
	}
	
	elseif ($module=='keuangan_customer_billing' AND $act=='delete'){
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id='$_GET[id]'"));
		$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm FROM master_pasien WHERE id='$d[id_pasien]'"));

		pg_query($dbconn,"UPDATE transaksi_invoice_detail SET status_hapus='Y', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id='$_GET[id]'");
		
		if($d['jenis']=='LO'){
			$a=pg_fetch_array(pg_query($dbconn,"SELECT id_lab_order FROM pasien_laborder_detail WHERE id='$d[id_detail]'"));
			
			pg_query($dbconn,"UPDATE pasien_laborder SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$a[id_lab_order]'");
			pg_query($dbconn,"UPDATE pasien_hasillab SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id_laborder='$d[id_lab_order]'");
		}
		elseif($d['jenis']=='BTP'){
			pg_query($dbconn,"UPDATE pasien_billing_paket SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$d[id_detail]'");
		}
		elseif($d['jenis']=='BT'){
			pg_query($dbconn,"UPDATE pasien_tindakan SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$d[id_detail]'");
		}
		
		header("location:keuangan-customer-billing-$p[no_rm]");
	}
	
	elseif ($module=='keuangan_customer_billing' AND $act=='inputtindakan'){
		$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
		//echo"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'";
		$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM tindakan_kategori_harga WHERE id_tindakan='$_POST[id_tindakan]' AND id_kategori_harga='$id_kategori_harga'"));
		
		//echo"SELECT harga FROM tindakan_kategori_harga WHERE id_tindakan='$_POST[id_tindakan]' AND id_kategori_harga='$id_kategori_harga'";
		$harga=$bt['harga'];
		
		$result=pg_query($dbconn,"INSERT INTO pasien_tindakan (id_pasien, id_user, waktu_input, status_hapus, harga, id_tindakan, id_kunjungan, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N', '$harga',  '$_POST[id_tindakan]', '$_POST[id_kunjungan]', '$_SESSION[id_units]') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM transaksi_invoice_detail a, pasien_tindakan b WHERE a.id_detail='$insert_id' AND b.id_tindakan='$_POST[id_tindakan]' AND a.id_kunjungan='$_POST[id_kunjungan]' AND a.id_pasien='$_POST[id_pasien]' AND a.jenis='BT'"));
		
		if($c['tot']>0){
			$c=pg_fetch_array(pg_query($dbconn,"SELECT a.id, a.kuantitas FROM transaksi_invoice_detail a, pasien_tindakan b WHERE a.id_detail='$insert_id' AND b.id_tindakan='$_POST[id_tindakan]' AND a.id_kunjungan='$_POST[id_kunjungan]' AND a.id_pasien='$_POST[id_pasien]' AND a.jenis='BT'"));
			
			$kuantitas=$c['kuantitas']+1;
			pg_query($dbconn,"UPDATE transaksi_invoice_detail SET kuantitas='$kuantitas' WHERE id='$c[id]'");
		}
		else{
			pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_master_kategori_harga, id_detail, kuantitas, status_hapus) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'BT', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$insert_id', '1', 'N')");
			
		}
		
		$data=pg_query($dbconn,"SELECT id FROM lab_analysis WHERE id_tindakan='$_POST[id_tindakan]'");
		while($d=pg_fetch_array($data)){
			pg_query($dbconn,"INSERT INTO pasien_laborder (waktu_input, id_user, id_pasien,  id_kunjungan, status_hapus, status_jawab, status_track, status_billing, id_status_laborder, id_unit) VALUES ('$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', 'N', 'Y', 'N', '1', '$_SESSION[id_units]')");
		}
		header("location:keuangan-customer-billing-$p[no_rm]");
	}

	elseif ($module=='keuangan_customer_billing' AND $act=='inputpaket'){
		$p=pg_fetch_array(pg_query($dbconn,"SELECT no_rm FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
		
		$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM billing_paket_kategori_harga WHERE id_billing_paket='$_POST[id_billing_paket]' AND id_kategori_harga='$id_kategori_harga'"));
		$harga=$bt['harga'];
		
		$result=pg_query($dbconn,"INSERT INTO pasien_billing_paket (id_pasien, id_user, waktu_input, status_hapus, harga, id_billing_paket, id_kunjungan, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N', '$harga',  '$_POST[id_billing_paket]', '$_POST[id_kunjungan]', '$_SESSION[id_units]') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_master_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'BPT', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$insert_id', '1', 'N', '$_SESSION[id_units]')");
		
		$data=pg_query($dbconn,"SELECT * FROM billing_paket_detail WHERE id_billing_paket='$_POST[id_billing_paket]'");
		while($d=pg_fetch_array($data)){
			if($d['jenis']=='T'){
				pg_query($dbconn,"INSERT INTO pasien_tindakan (id_pasien, id_user, waktu_input, status_hapus, id_tindakan, id_kunjungan, id_pasien_billing_paket, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N',  '$d[id_detail]', '$_POST[id_kunjungan]', '$insert_id', '$_SESSION[id_units]')");
				
				$result=pg_query($dbconn,"INSERT INTO pasien_laborder (waktu_input, id_user, id_pasien,  id_kunjungan, status_hapus, status_jawab, status_track, status_billing, id_status_laborder, id_unit) VALUES ('$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', 'N', 'Y', 'N', '1', '$_SESSION[id_units]') RETURNING id");
		
				$insert_row = pg_fetch_row($result);
				$insert_id = $insert_row[0];
				
				$data=pg_query($dbconn,"SELECT id FROM lab_analysis WHERE id_tindakan='$_POST[id_tindakan]'");
				while($d=pg_fetch_array($data)){
					pg_query($dbconn,"INSERT INTO pasien_laborder_detail (id_lab_analysis,  id_pasien, id_kunjungan, status_temp, id_unit) VALUES ('$d[id]', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]')");
				}
			}
			
		}
		
		
		header("location:keuangan-customer-billing-$p[no_rm]");
	}
	
	elseif ($module=='keuangan_customer_billing' AND $act=='input'){

		/**/
		/*pg_query($dbconn,"UPDATE transaksi_invoice SET total='$_POST[total]',  sisa='$_POST[sisa]', status_bayar='N', status_issue='1' WHERE id='$_POST[id_invoice]'");*/

		/**/
		/**/
		$distc=pg_query($dbconn,"SELECT DISTINCT id_kategori_harga FROM transaksi_invoice_detail WHERE id_invoice='$_POST[id_invoice]'");

		$total=0;
		$disk = 0;
		$total_disk =0;
		while($r=pg_fetch_array($distc))
		{

		$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_payment) AS no_payment FROM transaksi_payment"));
		$no_payment=$q['no_payment'];
		$kode_before = substr($no_payment,2,6);
		$tahun = $thn_sekarang;
		$bulan = $bln_sekarang;
		$tanggal = $tgl_skrg;

		$thn = substr($tahun,-2);
		$kode_now = $thn.$bulan.$tanggal;
		if($kode_before==$kode_now){
			$no_payment_new = 'TP'.$kode_now.sprintf("%03s",1);
		}
		else{
			
			$no_urut = (int) substr($no_payment,8,3);
			$no_urut++;
			
			$no_payment_new = 'TP'.$kode_now.sprintf("%03s",$no_urut);
		}

		$id_d= $r[id_kategori_harga];
		$harga_invoice = $_POST["total_bayar_s#$id_d"];
		$diskon = $_POST["diskon_s#$id_d"];
		$sisa_bayar =  $_POST["sisa_bayar_s#$id_d"];


		$total += $harga_invoice;
		$disk += $diskon;
		$total_disk += $sisa_bayar;

		pg_query($dbconn,"INSERT INTO transaksi_payment ( id_invoice, waktu_input,   no_payment, status_hapus, id_user, harga_invoice,  id_pasien, id_unit, id_kategori_harga,diskon, harga_invoice_diskon) VALUES ('$_POST[id_invoice]', '$tgl_sekarang $jam_sekarang',   '$no_payment_new', 'N',  '$_SESSION[login_user]', '$harga_invoice',  '$_POST[id_pasien]', '$_SESSION[id_units]','$id_d', '$diskon','$sisa_bayar')");

		}
		
		/**/
		/**/

		/*pg_query($dbconn,"UPDATE transaksi_invoice SET total='$total',  sisa='$total_disk',diskon='$disk', status_bayar='N',
						status_issue='1' WHERE id='$_POST[id_invoice]'");*/

		pg_query($dbconn,"UPDATE transaksi_invoice SET total='$total',  sisa='$total_disk',diskon='$disk', status_bayar='N' WHERE id='$_POST[id_invoice]'");

		/*var_dump("UPDATE transaksi_invoice SET total='$_POST[total]',  sisa='$_POST[sisa]', status_bayar='N', status_issue='1' WHERE id='$_POST[id_invoice]'");*/

		$dt = pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id='$_POST[id_invoice]'"));
		$no_invoice_new = $dt[no_invoice];
		$id_invoice = $_POST[id_invoice];
		header("location:view-keuangan-customer-invoice-$no_invoice_new-$id_invoice");
		/**/
	}

	
	pg_close($dbconn);
}
?>