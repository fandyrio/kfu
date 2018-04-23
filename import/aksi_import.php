<?php

	include "config/conn.php";
	include "config/library.php";
	session_start();


if(isset($_POST['import'])){ 
	$id_perusahaan = $_POST["id_perusahaan"];
	$id_billing_paket = $_POST["id_billing"];
	$jadwal = DateToEng($_POST["jadwal"]);
	$jadwal_akhir = DateToEng($_POST["jadwal_akhir"]);

	$res=pg_query($dbconn,"INSERT INTO jadwal (
				   id_kategori_harga,
				   id_unit,
				   tanggal,
				   tanggal_akhir,
				   id_billing_paket,
				   id_user
				   ) 
					VALUES(
					'$id_perusahaan',
					'$_SESSION[id_units]',
					'$jadwal',
					'$jadwal_akhir',
					'$id_billing_paket',
					'$_SESSION[login_user]'
					) RETURNING id" );			
	$jadwal_h = pg_fetch_row($res);

	$nama_file_baru = 'data.xlsx';
	
	require_once 'content/import/PHPExcel/PHPExcel.php';
	
	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('content/import/tmp/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
	
	
	$numrow = 1;
	foreach($sheet as $row){
		
		$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));

		$kode=$unit['kode'];

		$d=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_rm) AS no_rm FROM master_pasien WHERE id_unit='$_SESSION[id_units]'"));

		$no_rm=$d['no_rm'];

		$kode_now="RM".$kode;

		$kode_before = substr($no_rm,0,7);
		if($kode_before==$kode_now){
			$no_urut = (int) substr($no_rm,7,5);
			$no_urut++;
			$no_rm_new = $kode_now.sprintf("%05s",$no_urut);
		}
		else{	
			$no_rm_new = $kode_now.sprintf("%05s",1);	
		}
		

		$nik = $row['B']; 
		$no_bpjs = $row['C']; 
		$id_lainnya = $row['D']; 
		$nama = $row['E']; 
		//$alamat = $row['F']; 
		$tgl_lahir = $row['F']; 
		$jenkelamin = $row['G']; 
		$unit_kerja = $row['H']; 
		$divisi = $row['I']; 
		$jabatan = $row['J']; 
		$tanggal_mulai_bekerja= $row['K']; 
		$jenkel="";

		if($jenkelamin=='L'){
			$jenkel = '1';
		}else{
			$jenkel = '2';
		}
		
		// Cek jika semua data tidak diisi
		/*if(empty($nik) && empty($nama) && empty($alamat) && empty($tgl_lahir) )
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)*/
		if($res){
		if($numrow > 1){
			$unit= $_SESSION['id_units'] ;

			$result="INSERT INTO master_pasien (nik,no_rm, nama, id_lainnya, no_bpjs, tanggal_lahir, id_perusahaan, jenkel, unit_kerja, status_hapus, id_unit, status_kunjungan, jabatan_karyawan, divisi, tanggal_mulai_bekerja) VALUES('$nik','$no_rm_new','$nama','$id_lainnya','$no_bpjs','$tgl_lahir', '$id_perusahaan', '$jenkel', '$unit_kerja', 'N', '$unit', 'N', '$jabatan', '$divisi', '$tanggal_mulai_bekerja') RETURNING id";

			if($nik != ''){
				$hasil=pg_query($dbconn,"SELECT * FROM master_pasien where nik='$nik'");
				if(pg_num_rows($hasil) >0){
					$pasien_h = pg_fetch_array($hasil);
					pg_query($dbconn,"INSERT INTO jadwal_detail (id_jadwal,id_pasien ) VALUES('$jadwal_h[0]','$pasien_h[id]')");

				}else{
					pg_query($dbconn,$result);
					pg_query($dbconn,"INSERT INTO jadwal_detail (id_jadwal,id_pasien ) VALUES('$jadwal_h[0]','$pasien_id[0]')");
				}
			}else{
				
					$hasilCari = pg_query($dbconn,$result);
					$pasien_id = pg_fetch_row($hasilCari);

				    pg_query($dbconn,"INSERT INTO jadwal_detail (id_jadwal,id_pasien ) VALUES('$jadwal_h[0]','$pasien_id[0]')");

			}

		}
		
		$numrow++; // Tambah 1 setiap kali looping
	}
	}
}

//header('import-pasien'); // Redirect ke halaman awal


?>

<script type="text/javascript">
	document.location.href = "import-pasien";
</script>
