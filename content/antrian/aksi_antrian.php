<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(1);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";
	include "../../config/fungsi_tanggal.php";
	include("../../data/api_post_pasien.php");

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	if ($module=='antrian' AND $act=='input')
	{
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$_POST[id_pasien]'"));
		
		if($d['status_kunjungan']=='Y'){
			?>
			  <script type="text/javascript">alert("Pasien tersebut sudah ada dalam antrian. Tolong selesaikan terlebih dahulu kunjungan pasien sebelumnya.");history.go(-1);</script>
			<?php
		}
		else{

			$getDokter=pg_query("SELECT * from master_karyawan_unit where id_karyawan='$_POST[id_dokter]' and id_unit='$_SESSION[id_units]'");
			$fetchDokter=pg_fetch_assoc($getDokter);

			if($fetchDokter['siok']=="")
			{
				$dpp="Y";
			}
			else if($fetchDokter['siok']!="")
			{
				$dpp="N";
			}

			$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));
			$kode=$unit['kode'];

			

			//TRIGER no antrian reservasi atau manual
			if($_POST['status_antrian']=='online')
			{
				$antrianReservasi=$_POST['no_antrian'];
				$cetakAntrian=substr($antrianReservasi, 12,3);
			}
			else
			{
				//NO ANTRIAN
				$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian WHERE id_unit='$_SESSION[id_units]' and waktu_masuk > '$tgl_sekarang 00:00:00'"));
				$no_antrian=$q['no_antrian'];
				var_dump("SELECT MAX(no_antrian) AS no_antrian FROM antrian WHERE id_unit='$_SESSION[id_units]' and waktu_masuk > '$tgl_sekarang 00:00:00'");


				$tahun = $thn_sekarang;
				$bulan = $bln_sekarang;
				$tanggal = $tgl_skrg;
				$thn = substr($tahun,-2);


				$tglBefore=substr($no_antrian,6,6);

				$tglNow = $thn.$bulan.$tanggal;
				if($tglNow==$tglBefore){
					$urut_before = substr($no_antrian,12,3);//228
					$urut_before++;
					
					$no_antrian_new = $kode.$tglNow.sprintf("%03s",$urut_before);
					
				}
				else{
					$no_antrian_new = $kode.$tglNow.sprintf("%03s",1);
										
				}
				//=================================================================================
				//NO ANTRIAN RESERVASI
				$antrianUnit=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian_reservasi WHERE id_unit='$_SESSION[id_units]'"));
				$no_antrian_unit=$antrianUnit['no_antrian'];


				$tahun = $thn_sekarang;
				$bulan = $bln_sekarang;
				$tanggal = $tgl_skrg;
				$thn = substr($tahun,-2);


				$tglBefore=substr($no_antrian_unit,6,6);

				$tglNow = $thn.$bulan.$tanggal;
				if($tglNow==$tglBefore){
					$urut_before = substr($no_antrian_unit,12,3);//228
					$urut_before++;
						
					$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",$urut_before);	
						
				}
				else
				{
					$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",1);	
					
				}

				//=================================================================================
				//Compare No Antrian
				if($no_antrian_new == $no_antrian_reservasi_new)
				{
					$antrianReservasi=$no_antrian_reservasi_new;

				}
				else if($no_antrian_new > $no_antrian_reservasi_new)
				{
					$antrianReservasi=$no_antrian_new++;
				}
				else if($no_antrian_new < $no_antrian_reservasi_new)
				{
					$antrianReservasi=$no_antrian_reservasi_new++;
				}
				//=================================================================================
				$cetakAntrian=substr($antrianReservasi, 12,3);
			}

			//Membuat invoice 
			$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));

			//update CUSTOMERID
			if(isset($_POST['customerID']))
			{
				if($d['customer_id']=="")
				{
					$updateCustomerId=pg_query("UPDATE master_pasien set customer_id='$_POST[customerID]' where id='$_POST[id_pasien]' ");
					$post_patient=API_POST_PATIENT($d['public_id']);
				}
				
				$confirm_patient=API_POST_CONFIRM($_POST['reservasiID']);

			}


			$kode=$unit['kode'];

			$getInvoice=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_invoice) AS no_invoice FROM transaksi_invoice WHERE id_unit='$_SESSION[id_units]'"));

			$no_invoice=$getInvoice['no_invoice'];

			$kode_now="TX".$kode;

			$kode_before = substr($no_invoice,0,8);
			if($kode_before==$kode_now){
				$no_urut = (int) substr($no_invoice,8,5);
				$no_urut++;
				$no_invoice_new = $kode_now.sprintf("%05s",$no_urut);
			}
			else{	
				$no_invoice_new = $kode_now.sprintf("%05s",1);	
			}
			//

			if($_POST['id_kategori_harga']=="005001000")//BPJS
			{
				$tanggal=date('Y-m-d');
				$thisYear=date("Y");


				$getDataDokter=pg_query("SELECT * from master_karyawan where id='$_POST[id_dokter]'");
				$fetchDataDokter=pg_fetch_assoc($getDataDokter);
				$polyID=$fetchDataDokter['poly_id'];

				$bpjsData=pg_query("SELECT count(*) as jumlah from log_bpjs where no_bpjs='$d[no_bpjs]' and extract(year from tanggal::timestamp)='$thisYear' and id_poly='$polyID'");
				$fetchBPJS=pg_fetch_assoc($bpjsData);
				$jumlahTahunIni=$fetchBPJS['jumlah'];
				var_dump($d[no_bpjs]);


				if($jumlahTahunIni<3)
				{
					$result=pg_query($dbconn,"INSERT INTO kunjungan (status_kunjungan,id_pasien, waktu_input, id_user, id_kategori_harga, id_unit, prb) VALUES ('Y', '$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]','$_POST[prb]') RETURNING id");
			
					$insert_row = pg_fetch_row($result);
					$insert_id = $insert_row[0];
				
					$antrian=pg_query($dbconn,"INSERT INTO antrian (id_kunjungan, id_pasien, id_dokter,  waktu_masuk, status_antrian, status_aktif, id_user, no_antrian, id_prioritas, id_kategori_harga, id_unit, id_paket, dpp, no_cetak_antrian,id_poly) VALUES ('$insert_id', '$_POST[id_pasien]', '$_POST[id_dokter]', '$tgl_sekarang $jam_sekarang', 'Y', 'Y',  '$_SESSION[login_user]', '$antrianReservasi', '$_POST[id_prioritas]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]', '$_POST[id_paket]','$dpp', '$cetakAntrian', '$_POST[poly]') RETURNING id");
					$insertedIdAntrian=pg_fetch_row($antrian);
					$idAntrian=$insertedIdAntrian[0];
					$insertPanggilan=pg_query($dbconn, "INSERT INTO panggil_antrian(id_antrian, status, called,id_unit) values ('$idAntrian', 'N', 'N', '$_SESSION[id_units]')");

					$insertData=pg_query("INSERT into log_bpjs (no_bpjs,tanggal,id_poly ) values ('$d[no_bpjs]', '$tanggal', '$polyID')");

					$kunj=pg_query($dbconn,"INSERT INTO transaksi_invoice (no_invoice, id_pasien, id_kunjungan, waktu_input, id_users, total,  status_selesai, sudah_bayar, id_kategori_harga_bayar, id_unit) VALUES ('$no_invoice_new', '$_POST[id_pasien]', '$insert_id', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '0',  'N', '0', '$id_kategori_harga', '$_SESSION[id_units]') RETURNING id");
					
				}
				else
				{
					$getStatusFaskes=pg_query("SELECT * from master_pasien where id='$_POST[id_pasien]'");
					$fetchStatusFaskes=pg_fetch_assoc($getStatusFaskes);
					if($fetchStatusFaskes['status_faskes']=="NKF")
					{
						header("location:antrian?status=NKF");
						exit();
					}
				}
			}
			else
			{
				$result=pg_query($dbconn,"INSERT INTO kunjungan (status_kunjungan,id_pasien, waktu_input, id_user, id_kategori_harga, id_unit, prb) VALUES ('Y', '$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]', '$_POST[prb]') RETURNING id");
			
				$insert_row = pg_fetch_row($result);
				$insert_id = $insert_row[0];
				
					$antrian=pg_query($dbconn,"INSERT INTO antrian (id_kunjungan, id_pasien, id_dokter,  waktu_masuk, status_antrian, status_aktif, id_user, no_antrian, id_prioritas, id_kategori_harga, id_unit, id_paket, dpp, no_cetak_antrian,id_poly) VALUES ('$insert_id', '$_POST[id_pasien]', '$_POST[id_dokter]', '$tgl_sekarang $jam_sekarang', 'Y', 'Y',  '$_SESSION[login_user]', '$antrianReservasi', '$_POST[id_prioritas]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]', '$_POST[id_paket]','$dpp', '$cetakAntrian', '$_POST[poly]') RETURNING id");
				$insertedIdAntrian=pg_fetch_row($antrian);
					$idAntrian=$insertedIdAntrian[0];
					$insertPanggilan=pg_query($dbconn, "INSERT INTO panggil_antrian(id_antrian, status, called,id_unit) values ('$idAntrian', 'N', 'N', '$_SESSION[id_units]')");
				$kunj=pg_query($dbconn,"INSERT INTO transaksi_invoice (no_invoice, id_pasien, id_kunjungan, waktu_input, id_users, total,  status_selesai, sudah_bayar, id_kategori_harga_bayar, id_unit) VALUES ('$no_invoice_new', '$_POST[id_pasien]', '$insert_id', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '0',  'N', '0', '$id_kategori_harga', '$_SESSION[id_units]') RETURNING id");
				
				
			}			

			

			$insert_row = pg_fetch_row($antrian);
			$insert_id = $insert_row[0];
			
			pg_query($dbconn,"UPDATE master_pasien SET status_kunjungan='Y' WHERE id='$_POST[id_pasien]'");
			
			//LOG USER
			if($jumlahTahunIni==3 && $fetchStatusFaskes['status_faskes']=="KF")
			{
				$result=pg_query($dbconn,"INSERT INTO kunjungan (status_kunjungan,id_pasien, waktu_input, id_user, id_kategori_harga, id_unit, prb) VALUES ('Y', '$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]', '$_POST[prb]') RETURNING id");
			
				$insert_row = pg_fetch_row($result);
				$insert_id = $insert_row[0];
				
					$antrian=pg_query($dbconn,"INSERT INTO antrian (id_kunjungan, id_pasien, id_dokter,  waktu_masuk, status_antrian, status_aktif, id_user, no_antrian, id_prioritas, id_kategori_harga, id_unit, id_paket, dpp, no_cetak_antrian,id_poly) VALUES ('$insert_id', '$_POST[id_pasien]', '$_POST[id_dokter]', '$tgl_sekarang $jam_sekarang', 'Y', 'Y',  '$_SESSION[login_user]', '$antrianReservasi', '$_POST[id_prioritas]', '$_POST[id_kategori_harga]', '$_SESSION[id_units]', '$_POST[id_paket]','$dpp', '$cetakAntrian', '$_POST[poly]') RETURNING id");
				$insertedIdAntrian=pg_fetch_row($antrian);
					$idAntrian=$insertedIdAntrian[0];
					$insertPanggilan=pg_query($dbconn, "INSERT INTO panggil_antrian(id_antrian, status, called,id_unit) values ('$idAntrian', 'N', 'N', '$_SESSION[id_units]')");
				$kunj=pg_query($dbconn,"INSERT INTO transaksi_invoice (no_invoice, id_pasien, id_kunjungan, waktu_input, id_users, total,  status_selesai, sudah_bayar, id_kategori_harga_bayar, id_unit) VALUES ('$no_invoice_new', '$_POST[id_pasien]', '$insert_id', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '0',  'N', '0', '$id_kategori_harga', '$_SESSION[id_units]') RETURNING id");
				header("location:antrian?status=KF");	
			}
			else
			{
				header("location:antrian");
			}
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
	else if($module=='antrian' AND $act=='getPolyDoctor')
	{
		$idDokter=$_POST['idDokter'];
		$getData=pg_query("SELECT mk.*,p.name as nama_poly, p.id as idpoly from master_karyawan mk join master_poly p on p.id=mk.poly_id where mk.id='$idDokter'");
		$fetchData=pg_fetch_assoc($getData);

		echo "<option value='$fetchData[idpoly]'>$fetchData[nama_poly]</option>";
	}
	pg_close($dbconn);
}
?>