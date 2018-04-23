<?php
include "../config/conn.php";
/*$decoded_input = json_decode(file_get_contents("php://input"), true);
parse_str($decoded_input, $putdata);

header('Content-type: application/json');
echo json_encode( $putdata );*/
$kunci=$_SERVER["HTTP_SIGNATURE"];
if($kunci=='3a359b9479f9bf3eac262af78e3ae2dc7a8fafc9'){
$data = json_decode(file_get_contents("php://input"), true);

$id=$data['list_layanan'];
$bayar=$data['total_bayar'];
$id_invoice=0;

foreach ($id as $item) {
	$view = pg_fetch_array(pg_query($dbconn, "SELECT id_invoice, harga from transaksi_invoice_detail where id='$item[id]' "));
	$id_invoice=$view['id_invoice'];

	$pay = $view['harga'];
	$row = pg_query($dbconn, "UPDATE  transaksi_invoice SET sudah_bayar=sudah_bayar+$pay, sisa=sisa-$pay where id='$id_invoice' AND status_bayar='N' ");

}
$cek = pg_fetch_array(pg_query($dbconn, "SELECT total, sudah_bayar, id_pasien from transaksi_invoice where id='$id_invoice' "));
	if($cek['sudah_bayar'] >= $bayar){
		
		$row = pg_query($dbconn, "UPDATE  transaksi_invoice SET status_bayar='Y' where id='$id_invoice' ");
		$json = array(
			'response'		=> 'success',
			'status'	=> 'LUNAS'
		);

		$updatePasien=pg_query("UPDATE master_pasien set status_kunjungan='N' where id='$cek[id_pasien]'");
		$updateKunjungan=pg_query("UPDATE kunjungan set status_kunjungan='N' where id_pasien='$cek[id_pasien]'");
		$updateAntrian=pg_query("UPDATE antrian set status_antrian='N' and status_aktif='N' where id_pasien='$cek[id_pasien]'");
		$getDataPasien=pg_query("SELECT * from master_pasien where id='$cek[id_pasien]'");
		$fetchDataPasien=pg_fetch_array($getDataPasien);
		$noRM=$fetchDataPasien['no_rm'];
		if($fetchDataPasien['customer_id']!="")
		{
			include "phr.php";
		}
		else
		{
			$update=pg_query("UPDATE kunjungan set status_sync='N' where id_pasien='$cek[id_pasien]'");
		}
	}
	else{
		$json = array(
			'response'		=> 'sukses',
			'status'	=> 'BELUM LUNAS '
		);

	}

}
else{
	$json = array(
		'response'	=> 'failed',
	);
}	
echo json_encode($json);
?>