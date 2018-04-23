<?php
include "../../koneksi.php";
$module=$_GET['module'];
$aksi=$_GET['aksi'];

$nip = $_POST['nip'];
$nm_pegawai = $_POST['nm_pegawai'];
$jk = $_POST['jk'];
$tpt_lhr = $_POST['tpt_lhr'];
$tgl_lhr = $_POST['tgl_lhr'];
$tgl_msk = $_POST['tgl_msk'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$agama = $_POST['agama'];
$email = $_POST['email'];
$no_sk = $_POST['no_sk'];
$id_pangkat = $_POST['pangkat'];
$id_lokasi = $_POST['lokasi'];
$id_jabatan = $_POST['jabatan'];
$id_unit_krj = $_POST['unit_krj'];
$status = $_POST['status'];

// HAPUS
if($module=='pegawai' AND $aksi=='hapus' ){ 
	$mySql1 = pg_query("DELETE FROM pendidikan WHERE nip='".$_GET['nip']."'");
	$mySql2 = pg_query("DELETE FROM pengalaman_krj WHERE nip='".$_GET['nip']."'");
	$mySql3 = pg_query("DELETE FROM prestasi WHERE nip='".$_GET['nip']."'");
	$mySql4 = pg_query("DELETE FROM hukuman WHERE nip='".$_GET['nip']."'");
	$mySql5 = pg_query("DELETE FROM sk_krj WHERE nip='".$_GET['nip']."'");
	$mySql = "DELETE FROM pegawai WHERE nip='".$_GET['nip']."'";
	$myQry = pg_query($mySql);
	header('location:../../index.php?module='.$module);
	}
	if($module=='pegawai' AND $aksi=='hapus_pend' ){ 
	$mySql2 = pg_query("DELETE FROM pendidikan WHERE id_pend='".$_GET['id_pend']."'");
	echo "<script>window.location='javascript:history.back()';</script>";
	}
	if($module=='pegawai' AND $aksi=='hapus_peng_krj' ){ 
	$mySql2 = pg_query("DELETE FROM pengalaman_krj WHERE id_peng_krj='".$_GET['id_peng_krj']."'");
	header('location:../../index.php?module='.$module);
}
// EDIT
else if($module=='pegawai' AND $aksi=='edit' ){ 
		$query = pg_query("UPDATE pegawai SET				 
						  nm_pegawai = '$nm_pegawai',
						  jk = '$jk',
						  alamat = '$alamat',
						  no_hp = '$no_hp',
						  tpt_lhr = '$tpt_lhr',
						  tgl_lhr = '$tgl_lhr',
						  tgl_msk = '$tgl_msk',
						  agama = '$agama',
						  email = '$email'
						  WHERE nip = '$nip'");
		$query1 = pg_query("UPDATE sk_krj SET				 				  				  
						  id_jabatan = '$id_jabatan',
						  id_lokasi = '$id_lokasi',
						  id_pangkat = '$id_pangkat',
						  id_unit_krj = '$id_unit_krj',
						  tgl_sk = '$tgl_msk'				  
						  WHERE no_sk = '$no_sk'");	

		$num_input = count($_POST['add_nm_jjg']);
		//input data pendidikan
		for ($i = 0; $i < $num_input; $i++) {
		$nip = $_POST['nip'];
		$jjg = $_POST['add_jjg'][$i];
		$nm_jjg = $_POST['add_nm_jjg'][$i];
		$thn_jjg = $_POST['add_thn_jjg'][$i];
		    $query = "insert into pendidikan (nip, thn_pend, jenjang, nm_pendidikan) 
			values('{$nip}','{$thn_jjg}', '{$jjg}','{$nm_jjg}')";
		pg_query($query);	
		}
		$count = count($_POST['nm_jjg']);
		for($i = 0; $i < $count; $i++){
		$id = $_POST['id_pend'][$i];
		$jjg = $_POST['jjg'][$i];
		$nm_jjg = $_POST['nm_jjg'][$i];
		$thn_jjg = $_POST['thn_jjg'][$i];	
			
				$query_nilaiupdate = "UPDATE pendidikan set thn_pend = '".$thn_jjg."',
		jenjang = '".$jjg."',nm_pendidikan = '".$nm_jjg."' where id_pend = '".$id."'";
				$simpan = pg_query($query_nilaiupdate);
			}
		$counts = count($_POST['thn_krj']);
		for($i = 0; $i < $counts; $i++){
		$ids = $_POST['ids'][$i];
		$pekerjaan = $_POST['pekerjaan'][$i];
		$nm_pt = $_POST['nm_pt'][$i];
		$thn_krj = $_POST['thn_krj'][$i];				
		$simpans = pg_query("UPDATE pengalaman_krj set thn_krj = '".$thn_krj."',
		nm_pt = '".$nm_pt."',nm_krj = '".$pekerjaan."' where id_peng_krj = '".$ids."'");
			}	

		//input riwayat kerja
		$num = count($_POST['add_pekerjaan']);
		for ($j = 0; $j < $num; $j++) {
		$nip = $_POST['nip'];
		$nm_krj = $_POST['add_pekerjaan'][$j];
		$nm_pt = $_POST['add_nm_pt'][$j];
		$thn_krj = $_POST['add_thn_krj'][$j];
		    $quer = "insert into pengalaman_krj (nip, thn_krj, nm_krj, nm_pt) 
			values('{$nip}','{$thn_krj}', '{$nm_krj}','{$nm_pt}')";
		pg_query($quer) ;	
		}
						  
		header('location:../../index.php?module='.$module);
}
//Tambah
else if($module=='pegawai' AND $aksi=='tambah' ){ 
	header('location:../../index.php?module='.$module);
		$sql = "INSERT INTO pegawai  (nip, nm_pegawai, jk, tpt_lhr, tgl_lhr, agama, alamat, no_hp, email, tgl_msk) VALUES ('$nip', '$nm_pegawai', '$jk', '$tpt_lhr', '$tgl_lhr',  '$agama', '$alamat', '$no_hp', '$email', '$tgl_msk')";
		$simpan = pg_query($sql);

		$sq="INSERT INTO sk_krj  (no_sk, tgl_sk, nip, id_jabatan, id_lokasi, id_pangkat, id_unit_krj, status_sk) VALUES ( '{$no_sk}','{$tgl_msk}','{$nip}','{$id_jabatan}', '{$id_lokasi}','{$id_pangkat}','{$id_unit_krj}','{$status}')";
		var_dump("INSERT INTO sk_krj  (no_sk, tgl_sk, nip, id_jabatan, id_lokasi, id_pangkat, id_unit_krj, status_sk) VALUES ( '{$no_sk}','{$tgl_msk}','{$nip}','{$id_jabatan}', '{$id_lokasi}','{$id_pangkat}','{$id_unit_krj}','{$status}')");
		$simpa = pg_query($dbconn,$sq);

		$num_input = count($_POST['nm_jjg']);
		//input data pendidikan
		for ($i = 0; $i < $num_input; $i++) {
		$nip = $_POST['nip'];
		$jjg = $_POST['jjg'][$i];
		$nm_jjg = $_POST['nm_jjg'][$i];
		$thn_jjg = $_POST['thn_jjg'][$i];
		    $query = "insert into pendidikan (nip, thn_pend, jenjang, nm_pendidikan) 
			values('{$nip}','{$thn_jjg}', '{$jjg}','{$nm_jjg}')";
		pg_query($query);	
		}
		//input riwayat kerja
		$num = count($_POST['pekerjaan']);
		for ($j = 0; $j < $num; $j++) {
		$nip = $_POST['nip'];
		$nm_krj = $_POST['pekerjaan'][$j];
		$nm_pt = $_POST['nm_pt'][$j];
		$thn_krj = $_POST['thn_krj'][$j];
		    $quer = "insert into pengalaman_krj (nip, thn_krj, nm_krj, nm_pt) 
			values('{$nip}','{$thn_krj}', '{$nm_krj}','{$nm_pt}')";
		pg_query($quer);	
		}
}
?>