<?php
session_start();
//error_reporting(0);
include("../../data/api_post_pasien.php");
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	include "../../config/fungsi_thumb.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='pasien' AND $act=='input'){
		$tanggal_lahir=DateToEng($_POST['tanggal_lahir']);

		$date="2012-09-12";

		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['tanggal_lahir'])) 
		{
    		$tanggal_lahir=$_POST['tanggal_lahir'];
		} 
		else 
		{
    		$tanggal_lahir=DateToEng($_POST['tanggal_lahir']);
		}
		
		$acak			 = rand(1,99);
		$lokasi_file     = $_FILES['fupload']['tmp_name'];
		$tipe_file       = $_FILES['fupload']['type'];
		$nama_file       = $_FILES['fupload']['name'];
		$nama_file_unik  = $acak.$nama_file;
		
		if ($_FILES["fupload"]["error"] > 0 OR empty($lokasi_file)){
			$nama_file_unik = "";
		}
	  
		else{
			UploadPasien($nama_file_unik);
		}

		$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));

		$kode=$unit['kode'];

		$d=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_rm) AS no_rm FROM master_pasien WHERE id_unit='$_SESSION[id_units]'"));

		$no_rm=$d['no_rm'];

		$kode_now="KF".$kode;

		$kode_before = substr($no_rm,0,8);
		if($kode_before==$kode_now){
			$no_urut = (int) substr($no_rm,8,5);
			$no_urut++;
			$no_rm_new = $kode_now.sprintf("%05s",$no_urut);
		}
		else{	
			$no_rm_new = $kode_now.sprintf("%05s",1);	
		}

		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE no_rm='$_POST[no_rm]'"));
		if($c['tot']==0){
			$no_rm=$_POST['no_rm'];
		}
		else{
			$no_rm=$no_rm_new;
		}
		
		//pasien umum
			$getMaxData=pg_query("SELECT MAX(id) as max_id from master_pasien");
			$dataMAX=pg_fetch_assoc($getMaxData);
			$jumlah=$dataMAX['max_id']+1;
			$sprintF=sprintf("%06d", $jumlah);
			$unikUnit=sprintf("%03d", $_SESSION['id_units']);
			$public_id="P1".$unikUnit.''.$sprintF;

			/*$customerID=strtoupper($_POST['customerID']);

			$result=pg_query($dbconn,"INSERT INTO master_pasien (public_id,customer_id,no_rm, no_bpjs, nik, nama, id_title, id_lainnya, tanggal_lahir, jenkel, no_telepon, no_handphone, email, no_telepon_kerja, id_goldar, id_status_kawin, id_suku, id_pekerjaan, id_provinsi, id_kabupaten, id_kecamatan, alamat, register_by, tanggal_edit, jam_edit, foto, tempat_lahir, id_warga_negara, id_kategori_pasien, status_meninggal,  id_bahasa, id_agama, status_kunjungan, status_hapus, id_perusahaan, id_unit, kode_faskes) VALUES ('$public_id','$customerID','$_POST[no_rm]', '$_POST[no_bpjs]', '$_POST[nik]', '$_POST[nama]', '$_POST[id_title]', '$_POST[id_lainnya]', '$tanggal_lahir', '$_POST[jenkel]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[email]', '$_POST[no_telepon_kerja]', '$_POST[id_goldar]', '$_POST[id_status_kawin]', '$_POST[id_suku]', '$_POST[id_pekerjaan]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$_POST[alamat]', '$_SESSION[login_user]', '$tgl_sekarang', '$jam_sekarang', '$nama_file_unik', '$_POST[tempat_lahir]', '$_POST[id_warga_negara]', '$_POST[id_kategori_pasien]', 'N',  '$_POST[id_bahasa]', '$_POST[id_agama]', 'N', 'N', '$_POST[id_jenis_pasien]', '$_SESSION[id_units]', '$_POST[kode_faskes]') RETURNING id");*/

			$dataToUpper=array($_POST['customerID'], $no_rm, $_POST['nama'], $_POST['alamat'], $_POST['tempat_lahir']);
			$dataToUpper=array_map('strtoupper', $dataToUpper);

			$getStatusFaskes=pg_query("SELECT * from master_unit where kode_faskes='$_POST[kode_faskes]'");
			$numRowFaskes=pg_num_rows($getStatusFaskes);

			if($numRowFaskes==1)
			{
				$statusFaskes="KF";
			}
			elseif($numRowFaskes==0)
			{
				$statusFaskes="NKF";
			}
			else
			{
				$statusFaskes="ERROR";
			}

			$result=pg_query($dbconn,"INSERT INTO master_pasien (public_id,customer_id,no_rm, no_bpjs, nik, nama, id_title, id_lainnya, tanggal_lahir, jenkel, no_telepon, no_handphone, email, no_telepon_kerja, id_goldar, id_status_kawin, id_suku, id_pekerjaan, id_provinsi, id_kabupaten, id_kecamatan, alamat, register_by, tanggal_edit, jam_edit, foto, tempat_lahir, id_warga_negara, id_kategori_pasien, status_meninggal,  id_bahasa, id_agama, status_kunjungan, status_hapus, id_perusahaan, id_unit, kode_faskes,status_faskes) VALUES ('$public_id','$dataToUpper[0]','$dataToUpper[1]', '$_POST[no_bpjs]', '$_POST[nik]', '$dataToUpper[2]', '$_POST[id_title]', '$_POST[id_lainnya]', '$tanggal_lahir', '$_POST[jenkel]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[email]', '$_POST[no_telepon_kerja]', '$_POST[id_goldar]', '$_POST[id_status_kawin]', '$_POST[id_suku]', '$_POST[id_pekerjaan]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$dataToUpper[3]', '$_SESSION[login_user]', '$tgl_sekarang', '$jam_sekarang', '$nama_file_unik', '$dataToUpper[4]', '$_POST[id_warga_negara]', '$_POST[id_kategori_pasien]', 'N',  '$_POST[id_bahasa]', '$_POST[id_agama]', 'N', 'N', '$_POST[id_jenis_pasien]', '$_SESSION[id_units]','$_POST[kode_faskes]','$statusFaskes') RETURNING id");
			
			
			var_dump($_POST['IDReservasi']);
			$IDReservasi=$_POST['IDReservasi'];
			$idAntrian=$_POST['idAntrian'];
			if($IDReservasi!="")
			{
				echo "test";
				$post_patient=API_POST_PATIENT($public_id);
	
				if($post_patient=="")
				{
					echo "a";
					$insert_row = pg_fetch_row($result);
					$insert_id = $insert_row[0];
					
					pg_query($dbconn, "UPDATE master_pasien_keluarga SET id_pasien='$insert_id', id_session='' WHERE id_session='$_SESSION[id_session]'");
					pg_query($dbconn, "UPDATE master_pasien_penjamin SET id_pasien='$insert_id', id_session='' WHERE id_session='$_SESSION[id_session]'");


					$confirm_patient=API_POST_CONFIRM($_POST['IDReservasi']);
					echo $confirm_patient;
					header("location:antrian?no_rm=$_POST[no_rm]&idDokter=$_POST[idDokter]&idAntrian=$idAntrian");
				}
				else
				{
					$deleteData=pg_query("Delete from master_pasien where public_id='$public_id'");
					?>
					<script>
						alert('<?php echo $post_patient; ?>');
						history.go(-1);
					</script>
					<?php
				}
			}
			else
			{
				echo "test2";
				$insert_row = pg_fetch_row($result);
				$insert_id = $insert_row[0];
					
				pg_query($dbconn, "UPDATE master_pasien_keluarga SET id_pasien='$insert_id', id_session='' WHERE id_session='$_SESSION[id_session]'");
				pg_query($dbconn, "UPDATE master_pasien_penjamin SET id_pasien='$insert_id', id_session='' WHERE id_session='$_SESSION[id_session]'");
				header("location:antrian?no_rm=$_POST[no_rm]&idDokter=$_POST[idDokter]&idAntrian=$idAntrian");
			}

			
			
			
			
			
	}
	pg_close($dbconn);
}
?>