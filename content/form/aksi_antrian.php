<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	if ($module=='antrian' AND $act=='input'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		if($d['status_kunjungan']=='Y'){
			?>
			  <script type="text/javascript">alert("Pasien tersebut sudah ada dalam antrian. Tolong selesaikan terlebih dahulu kunjungan pasien sebelumnya.");history.go(-1);</script>
			<?php
		}
		else{
			$result=pg_query($dbconn,"INSERT INTO kunjungan (status_kunjungan, catatan, id_pasien, waktu_input, id_user, id_kategori_harga, id_unit) VALUES ('Y', '$_POST[catatan]', '$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]') RETURNING id");
			
			$insert_row = pg_fetch_row($result);
			$insert_id = $insert_row[0];
			
			$antrian=pg_query($dbconn,"INSERT INTO antrian (id_kunjungan, id_pasien, id_dokter,  waktu_masuk, status_antrian, status_aktif, id_user, no_antrian, id_prioritas, id_kategori_harga, id_unit, id_segmen, detail_segmen, id_paket) VALUES ('$insert_id', '$_POST[id_pasien]', '$_POST[id_dokter]', '$tgl_sekarang $jam_sekarang', 'Y', 'Y',  '$_SESSION[login_user]', '$_POST[no_antrian]', '$_POST[id_prioritas]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]','$_POST[id_segmen]', '$_POST[detail_segmen]', '$_POST[id_paket]') RETURNING id");

			

			if(!isset($_POST[id_paket]) || empty($_POST[id_paket]) ){
			}
				else{
			$h = pg_fetch_assoc(pg_query($dbconn, "SELECT * from billing_paket_kategori_harga_unit b where b.id_billing_paket='$_POST[id_paket]' 
											and b.id_kategori_harga='$_POST[id_kategori_harga]' and id_unit='$_SESSION[id_units]' "));

			$pasien_o =pg_query($dbconn,"INSERT INTO pasien_order (id_pasien, id_kunjungan, id_unit, total, waktu_input, id_user) VALUES ('$_POST[id_pasien]', '$insert_id','$_SESSION[id_units]',  '$h[harga]', '".date("Y-m-d")."','$_SESSION[login_user]')  RETURNING id");
		
			$insert_r = pg_fetch_row($pasien_o);	

			$tgl_sekarang = date("Y-m-d");
			$jam_sekarang = date("H:i:s");	

			pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, id_kategori_harga, waktu_input,id_unit, id_pasien_order, id_detail, status_hapus, kuantitas) VALUES ('$_POST[id_pasien]', '$insert_id', 'E', '$h[harga]', 'Y', '$_SESSION[login_user]',$_POST[id_kategori_harga], '$tgl_sekarang $jam_sekarang','$_SESSION[id_units]', '$insert_r[0]','$_POST[id_paket]' ,'N','1') ");

			
		}


			
			
			$insert_row = pg_fetch_row($antrian);
			$insert_id = $insert_row[0];
			
			pg_query($dbconn,"UPDATE master_pasien SET status_kunjungan='Y' WHERE id='$_POST[id_pasien]'");
			
			//LOG USER
			header("location:antrian");
		}
	}
	
	elseif ($module=='antrian' AND $act=='update'){

		if(($_POST['id_segmen']==1) || ($_POST['id_segmen']==4) ){
			$detail ="";
		}else{
			$detail =$_POST['detail_segmen'];			
		}
		pg_query($dbconn,"UPDATE antrian SET  id_dokter='$_POST[id_dokter]', id_prioritas='$_POST[id_prioritas]', id_kategori_harga='$_POST[id_kategori_harga]', id_segmen='$_POST[id_segmen]', detail_segmen='$detail' WHERE id='$_POST[id]'");
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id='$_POST[id]'"));
		pg_query($dbconn,"UPDATE kunjungan SET id_kategori_harga='$_POST[id_kategori_harga]' WHERE id='$d[id_kunjungan]'");
		
		//LOG USER
		
		header("location:antrian");
	}
	
	
	
	elseif ($module=='antrian' AND $act=='delete'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM antrian WHERE id='$_GET[id]'"));
		
		pg_query($dbconn,"UPDATE antrian SET waktu_keluar='$tgl_sekarang $jam_sekarang', status_aktif='N', status_antrian='N' WHERE id='$_GET[id]'");
		
		pg_query($dbconn,"UPDATE master_pasien SET status_kunjungan='N' WHERE id='$d[id_pasien]'");
		
		pg_query($dbconn,"UPDATE kunjungan SET status_kunjungan='N' WHERE id='$d[id_kunjungan]'");
		
		//LOG USER
		header("location:antrian");
		
	}
	
	elseif ($module=='antrian' AND $act=='lama'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM antrian WHERE id='$_POST[id]'"));
		
		
		$diff = beda_waktu("$d[waktu_masuk]", date('Y-m-d H:i:s'));
		?>
		<div class="modal-dialog modal-sm modal-info">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="title-form">Info</h4>
				</div>
				<div class="modal-body" id="form-data">
					<h6><?php echo "$diff[d] hari, $diff[h] jam $diff[i] menit $diff[s] detik";?></h6>
				</div>
			</div>
		<?php
	}
	pg_close($dbconn);
}
?>