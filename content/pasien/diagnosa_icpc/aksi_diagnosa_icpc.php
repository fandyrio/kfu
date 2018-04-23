<?php 
session_start();
include "../../../config/conn.php";
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";

switch ($_GET['act']) {
	
	case 'tambah':
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		$catatan=$_POST['catatan'];
		
		
		$result=pg_query($dbconn,"INSERT INTO pasien_diagnosa_icpc (id_user, versi, tgl_diagnosa, catatan, id_unit, id_pasien, id_kunjungan, status_hapus)
		 VALUES (
		 	'$_SESSION[login_user]',
		 	'1',
		 	'$tgl_sekarang',
		 	'$catatan',
			'$_SESSION[id_units]',
			'$id_pasien',
			'$id_kunjungan',
			'N'

		) RETURNING id");

				
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
			
		$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail_icpc WHERE id_pasien='$_POST[id_pasien]' AND id_kunjungan='$_POST[id_kunjungan]' AND status_temp='Y'");

		
		
		
		while($r=pg_fetch_array($data)){
				
			pg_query($dbconn,"UPDATE pasien_diagnosa_detail_icpc SET id_pasien_diagnosa='$insert_id', status_temp='N' WHERE id='$r[id]'");

			
			
		}
	break;
	
	case 'tambahdiagnosa':

	$id_pasien=$_POST['id_pasien'];
	$id_diagnosa=$_POST['id_diagnosa'];
	$id_kunjungan=$_POST['id_kunjungan'];


		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_diagnosa_detail WHERE id_diagnosa='$id_diagnosa' AND id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'"));
	
		if($c['tot']==0){
			$data=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail_icpc WHERE id_pasien='$id_pasien' AND status_temp='Y' AND id_kunjungan='$id_kunjungan' ");
	
			$ada=0;
			$countData=pg_query("SELECT count(*) as jumlah from pasien_diagnosa_detail_icpc where id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan' and id_pasien_diagnosa is NULL");
			$row=pg_fetch_assoc($countData);
			if($row['jumlah']==0)			
			{
				$statusPriority="1";
			}
			else
			{
				$statusPriority="2";
			}
					
			pg_query($dbconn,"INSERT INTO pasien_diagnosa_detail_icpc (id_diagnosa,  id_pasien, id_kunjungan, status_temp, id_unit,status) VALUES ('$_POST[id_diagnosa]',  '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'Y', '$_SESSION[id_units]', '$statusPriority')");

		

			
					
		}
		if($ada==1){
			echo"sudah_ada";
		}

	
	break;

	case 'deleteicpc';
	pg_query($dbconn,"DELETE from pasien_diagnosa_detail_icpc WHERE id='$_POST[id]'");
	break;

	case 'deletediagnosa';
	pg_query($dbconn,"DELETE from pasien_diagnosa_icpc WHERE id='$_POST[id]'");
	pg_query($dbconn,"DELETE from pasien_diagnosa_detail_icpc WHERE id_pasien_diagnosa='$_POST[id]'");
	break;
}


?>