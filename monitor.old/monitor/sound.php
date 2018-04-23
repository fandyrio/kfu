<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
	include "../config/conn.php";
	include "../queue/client/function_panggil.php";

	$today=date("Y-m-d");
	if(isset($_POST['no_antrian']))
	{
		$noAntrian=$_POST['no_antrian'];
		$idUnit=$_POST['idUnit'];
		$ruangan=$_POST['ruangan'];
		$idDokter=$_POST['idDokter'];

		$getNotCall=pg_query("SELECT pa.id as id_panggilan, pa.id_antrian, pa.status, pa.called, pa.id_unit, a.id as id_table_antrian, a.id_dokter
			from panggil_antrian pa 
			join antrian a on a.id = pa.id_antrian
			 where a.no_cetak_antrian='$noAntrian' and a.id_unit='$idUnit' and a.status_antrian='Y' and status_aktif='Y' and a.waktu_masuk>='$today 00:00:00'");
		$fetchNotCall=pg_fetch_assoc($getNotCall);
		$idWantToCall=$fetchNotCall['id_panggilan'];
		$idAntrianUpdate=$fetchNotCall['id_table_antrian'];
		$id_dokter=$fetchNotCall['id_dokter'];

		if($id_dokter=="")
		{
			$update=pg_query("UPDATE antrian set id_dokter='$idDokter' where id='$idAntrianUpdate'");
			$update=pg_query("UPDATE panggil_antrian set called='N', status='N' where id='$idWantToCall'");
			$update=pg_query("UPDATE panggil_antrian set called='Y' where id='$idWantToCall'");
		}
		else
		{
			if($id_dokter==$idDokter)
			{
				$update=pg_query("UPDATE panggil_antrian set called='N', status='N' where id='$idWantToCall'");
				$update=pg_query("UPDATE panggil_antrian set called='Y' where id='$idWantToCall'");
			}
			else
			{
				/*echo "SELECT pa.id as id_panggilan, pa.id_antrian, pa.status, pa.called, pa.id_unit, a.id as id_table_antrian, a.id_dokter
			from panggil_antrian pa 
			join antrian a on a.id = pa.id_antrian
			 where a.no_cetak_antrian='$noAntrian' and a.id_unit='$idUnit' and a.status_antrian='Y' and status_aktif='Y' and a.waktu_masuk>='$today 00:00:00'";*/
			 echo "Sudah dipanggil dokter lain";
			}
		}


	}
	else
	{
		$idWantToCall=0;

		$getData=pg_query("SELECT pa.*, a.no_cetak_antrian as no_cetak_antrian,a.id_dokter as id_dokter, a.id_unit as id_unit from panggil_antrian pa join antrian a on a.id=pa.id_antrian
		where pa.called='Y' and pa.status='N'");
		$fetchData=pg_fetch_assoc($getData);
		$jumlahData=pg_num_rows($getData);
		$id_unit=$fetchData['id_unit'];

		
		/*$getData=mysqli_query($con, "SELECT * from antrian where called='Y' and status='N'");
		$jumlahData=mysqli_num_rows($getData);
		$fetchData=mysqli_fetch_array($getData);
		$id=$fetchData['id'];
*/
		if($jumlahData>=1)
		{
			$id=$fetchData['id'];
			$no_cetak_antrian=$fetchData['no_cetak_antrian'];
			$id_users=$_SESSION['login_user'];
			$id_dokter=$fetchData['id_dokter'];
			date_default_timezone_set("Asia/Jakarta");
			$today=date("Y-m-d");
			$getDokterRoom=pg_query("SELECT * from ruang_dokter where id_karyawan='$id_dokter' and status='online' and tanggal='$today'"); // id_unit belum masuk
			$fetchDokterRoom=pg_fetch_assoc($getDokterRoom);
			$getRoom=$fetchDokterRoom['nama_ruangan'];

			$token="XXI";
			$update=pg_query("UPDATE panggil_antrian set status='Y' where id='$id'");
			$a=array("token"=>$token, 
				"no_cetak_antrian"=>$no_cetak_antrian, 
				"getRoom"=>$getRoom,
				"id_dokter"=>"SELECT * from ruang_dokter where id_karyawan='$id_dokter' and status='online' and tanggal='$today'",
				"idUnit"=>$id_unit);

		}
		else
		{
			$id_users=$_SESSION['login_user'];
			$id_dokter=getKaryawan($id_users);
			$today=date("Y-m-d");
			$getDokterRoom=pg_query("SELECT * from ruang_dokter where id_karyawan='$id_dokter' and status='online' and tanggal='$today'"); // id_unit belum masuk
			$fetchDokterRoom=pg_fetch_assoc($getDokterRoom);
			$getRoom=$fetchDokterRoom['nama_ruangan'];
			$token="";
			$a=array("token"=>$token, 
				"no_cetak_antrian"=>0, 
				"getRoom"=>0,
				"idUnit"=>0);
		}
		echo json_encode($a, true);		
	}

	

	
?>