<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../config/conn.php";


$kunci=$_SERVER["HTTP_SIGNATURE"];
$request_method=$_SERVER["REQUEST_METHOD"];

if($kunci=='abc')
{
//$data = json_decode(file_get_contents("php://input"), true);
	$id_kunjungan=$_GET['idKunjungan'];
	$getData=pg_query("SELECT * from reservasi_lab where id_kunjungan='$id_kunjungan'");
	$jumlah=pg_num_rows($getData);
	if($jumlah>0)
	{
		$getDataPasien=pg_query("SELECT k.*, mp.*, mkh.nama as penjamin from kunjungan k
		join master_pasien mp on mp.id=k.id_pasien
		join master_kategori_harga mkh on mkh.id=k.id_kategori_harga::integer
		where k.id='$id_kunjungan'");
		$fetchDataPasien=pg_fetch_assoc($getDataPasien);

		while($fetchData=pg_fetch_array($getData))
		{
			$arr[]=array(
				'id_tindakan'=>$fetchData['id_pemeriksaan'],
				'jenis_test'=>$fetchData['jenis_lab']
			);
		}
		$data=array(
			'status'=>'0',
			'message'=>'OK',
			'data_pasien'=>array(
				'id_pasien'=>$fetchDataPasien['public_id'],
				'nama_pasien'=>$fetchDataPasien['nama'],
				'tgl_lahir'=>$fetchDataPasien['tanggal_lahir'],
				'penjamin'=>$fetchDataPasien['penjamin'],
				'alamat'=>$fetchDataPasien['alamat']
				),
			
			'data_tindakan'=>$arr,
			'request_method'=>$request_method
		);
		$json=json_encode($data);
		echo $json;
	}
	else
	{
		$data=array(
			'status'=>'1',
			'message'=>'Data tidak ditemukan'
			);
		$json=json_encode($data);
		echo $json;
	}
	
	
}
else
{
	echo"error";
}

?>