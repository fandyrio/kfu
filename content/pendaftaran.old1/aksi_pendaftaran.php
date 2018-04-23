<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='pendaftaran' AND $act=='inputantrian'){
		/*$d=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		if($d['status_kunjungan']=='Y'){
			?>
			  <script type="text/javascript">alert("Pasien tersebut sudah ada dalam antrian. Tolong selesaikan terlebih dahulu kunjungan pasien sebelumnya.");history.go(-1);</script>
			<?php
		}
		else{
			$result=pg_query($dbconn,"INSERT INTO kunjungan (status_kunjungan, catatan, id_pasien, waktu_input, id_user, id_kategori_harga, id_unit) VALUES ('Y', '$_POST[catatan]', '$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]') RETURNING id");
			
			$insert_row = pg_fetch_row($result);
			$insert_id = $insert_row[0];
			
			$antrian=pg_query($dbconn,"INSERT INTO antrian (id_kunjungan, id_pasien, id_departemen, id_dokter, id_jenis_kunjungan, catatan, waktu_masuk, status_antrian, status_aktif, id_user, no_antrian, id_prioritas, id_kategori_obat_perusahaan, id_kategori_tindakan_perusahaan, id_unit) VALUES ('$insert_id', '$_POST[id_pasien]', '$_POST[id_departemen]', '$_POST[id_dokter]', '1', '$_POST[catatan]', '$tgl_sekarang $jam_sekarang', 'Y', 'Y',  '$_SESSION[login_user]', '$_POST[no_antrian]', '$_POST[id_prioritas]', '$_POST[id_kategori_obat_perusahaan]' ,'$_POST[id_kategori_tindakan_perusahaan]', '$_SESSION[id_units]') RETURNING id");
			
			$insert_row = pg_fetch_row($antrian);
			$insert_id = $insert_row[0];
			
			//pg_query($dbconn,"INSERT INTO antrian_log_user (id_antrian, waktu_log, id_kegiatan, id_user) VALUES ('$insert_id', '$tgl_sekarang $jam_sekarang', '1', '$_SESSION[login_user]')");
			
			pg_query($dbconn,"UPDATE master_pasien SET status_kunjungan='Y' WHERE id='$_POST[id_pasien]'");
			header("location:antrian-resepsionis");
		}
		*/
	}
	pg_close($dbconn);
}
?>