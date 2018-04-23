<?php
session_start();
require('../../../fpdf/fpdf.php');
include "../../../config/conn.php";
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";

$images="../../../images/klinik_pratama.jpg";
$imagesCC="../../../images/cc.png";



$idKunjungan=$_GET['idKunjungan'];

$getDataPasien=pg_query("SELECT * from kunjungan k 
	join master_pasien mp on mp.id=k.id_pasien
	where k.id='$idKunjungan'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);

$getBeratBadan=pg_query("select * from pasien_fisik pf 
	join pasien_fisik_detail pfd on pf.id=pfd.id_pasien_fisik 
	where pf.id_kunjungan='$idKunjungan' and pfd.id_fisik='2'");
$fetchBeratBadan=pg_fetch_assoc($getBeratBadan);

$getNoResep=pg_query("SELECT * from pasien_no_resep pnr 
	join kunjungan k on k.id=pnr.id_kunjungan 
	join antrian a on a.id_kunjungan=k.id
	join master_karyawan mk on mk.id=a.id_dokter
	where pnr.id_kunjungan='$idKunjungan'");
$fetchNoResep=pg_fetch_assoc($getNoResep);
$noResep=$fetchNoResep['no_resep'];

$idUnit=$_SESSION['id_units'];
$getUnit=pg_query("SELECT * from master_unit where id='$idUnit'");
$fetchUnit=pg_fetch_assoc($getUnit);
$alamatUnit=$fetchUnit['alamat'];

$getProvinsi=pg_query("SELECT * from master_provinsi where id='$fetchUnit[id_provinsi]'");
$fetchProvinsi=pg_fetch_assoc($getProvinsi);

$getKabupaten=pg_query("SELECT * from master_kabupaten where id='$fetchUnit[id_kabupaten]'");
$fetchKabupaten=pg_fetch_assoc($getKabupaten);

$getKecamatan=pg_query("SELECT * from master_kecamatan where id='$fetchUnit[id_kecamatan]'");
$fetchKecamatan=pg_fetch_assoc($getKecamatan);


$pdf = new FPDF();
$pdf->AddPage();
$pdf->Cell(-10);
$pdf->SetFillColor(91,155,213);
$pdf->Rect(0, 0, 10, 297, 'F');
$pdf->setXY(10,1);
$pdf->SetTextColor(256,256,256);
$pdf->SetFont('Times','B',16);
$pdf->MultiCell(110,8,$fetchNoResep['nama'],0,'C',true);

$pdf->setXY(0,8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',14);
$pdf->MultiCell(119.5,8,'SIP : '.$fetchNoResep['no_izin_praktek'],0,'C',true);

$pdf->setXY(10,15);
$pdf->SetFont('Times','I',10);
$pdf->MultiCell(110,6,$alamatUnit.', '.$fetchKecamatan['nama'].', '.$fetchKabupaten['nama'].', '.$fetchProvinsi['nama'].'. Telp. '. $fetchUnit['telepon'].', Email :'.$fetchUnit['email'] ,0,'L',true);

$pdf->Cell( 40, 40, $pdf->Image($images, 130, 0, 60), 0, 0, 'L', false );
$pdf->SetFont('Times','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20,40, 'Nomor Surat : ');
$pdf->Text(45,40, $noResep);
$pdf->Text(160,40, date('d-F-Y'));

$pdf->SetFont('Times','',3);
$pdf->SetTextColor(0,0,256);
$pdf->Text(30,44,'_____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');
$pdf->Text(30,53,'______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');

$pdf->SetFont('Times','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Text(90,50,'R E S E P');

//GET RESEP KETERANGAN
$x=60;
$getKeteranganResep=pg_query("SELECT prk.*, mf.kode as kode_mf, mi.kode as kode_iterasi, k.id_pasien as id_pasien, ms.arti as arti_sediaan, msd.arti as arti_sediaan_detail, cp.arti as arti_cara_pakai from pasien_resep_keterangan prk 
	join master_mf mf on mf.id=prk.ah 
	join master_iterasi mi on mi.id=prk.iterasi
	join cara_pakai cp on cp.id=prk.cara_pakai::integer
	join kunjungan k on k.id=prk.id_kunjungan
	left join master_sediaan ms on ms.id=prk.sediaan::integer
	left join master_sediaan_detail msd on msd.id=prk.sediaan_detail::integer
	where id_kunjungan='$idKunjungan' order by id_resep ASC");
while($fetchKeteranganResep=pg_fetch_assoc($getKeteranganResep))
{
	$getObat=pg_query("SELECT pro.*, me.kode as kode_satuan from pasien_resep_order pro 
		join master_me me on me.id=pro.satuan
		where pro.id_resep='$fetchKeteranganResep[id_resep]' and pro.id_kunjungan='$idKunjungan'");
	$pdf->Text(15,$x,'R /');
	while($fetchObat=pg_fetch_assoc($getObat))
	{
		$pdf->SetFont('Times','B',8);
		$pdf->Text(30,$x,$fetchObat['nama_brand'].' '.$fetchKeteranganResep['id_resep']);
		$pdf->Text(120,$x,$fetchObat['dosis'].' '.$fetchObat['kode_satuan']);
		if($fetchKeteranganResep['status_racikan']=="NR")
		{
			$pdf->Text(160,$x,$fetchKeteranganResep['kode_mf']);	
			$pdf->Text(170,$x,$fetchKeteranganResep['jml']);
			$pdf->Text(180,$x,$fetchKeteranganResep['kode_iterasi']);
		}
		$x+=5;
	}
	$pdf->SetFont('Times','',10);
	$x+=2;
	if($fetchKeteranganResep['status_racikan']=="R")
	{
		$pdf->Text(30,$x, 'm.f.');
		$pdf->Text(45,$x, $fetchKeteranganResep['k1_1']);
		$pdf->Text(60,$x, $fetchKeteranganResep['k2_1']);
		$pdf->Text(75,$x, $fetchKeteranganResep['k3_1']);
		$pdf->Text(90,$x, $fetchKeteranganResep['k4_1']);
		$pdf->Text(105,$x, $fetchKeteranganResep['k5_1']);
		$pdf->Text(120,$x, $fetchKeteranganResep['k6_1']);
		$pdf->Text(135,$x, $fetchKeteranganResep['k7_1']);
		$pdf->Text(150,$x, $fetchKeteranganResep['k8_1']);
		$pdf->Text(160,$x,$fetchKeteranganResep['kode_mf']);	
		$pdf->Text(170,$x,$fetchKeteranganResep['jml']);
		$pdf->Text(180,$x,$fetchKeteranganResep['kode_iterasi']);
		$x+=5;
	}

	$pdf->Text(30,$x, 's');
	$pdf->Text(45,$x, $fetchKeteranganResep['ket_1']);
	$pdf->Text(60,$x, $fetchKeteranganResep['ket_2']);
	$pdf->Text(75,$x, $fetchKeteranganResep['xperh']);
	$pdf->Text(90,$x, 'd.d');
	$pdf->Text(105,$x, $fetchKeteranganResep['operh']);
	$pdf->setXY(120,$x-3);
	$pdf->MultiCell(30,5, $fetchKeteranganResep['arti_sediaan_detail']);
	//$pdf->Text(120,$x, );
	$pdf->setXY(155,$x-3);
	$pdf->MultiCell(40,5, $fetchKeteranganResep['arti_cara_pakai']);
	//$pdf->Text(135,$x, );
	$x+=7;
	$pdf->SetFont('Times','B',11);
	$pdf->Text(30,$x,'_________________________________________________________________________________');
	$x+=5;		
}

$x+=20;
$pdf->Text(30,$x,'PRO');
$pdf->Text(55,$x,':');
$pdf->Text(60,$x,$fetchDataPasien['nama']);
$x+=5;
$pdf->Text(30,$x,'Berat Badan');
$pdf->Text(55,$x,':');
$pdf->Text(60,$x,$fetchBeratBadan['nilai'].' KG');

$x+=10;
$pdf->Cell( 40, 20, $pdf->Image($imagesCC, 10, $x+=3, 60), 0, 0, 'L', false );

/*$pdf->Output("../dokumen_surat/".$namaFile,"F");*/
$pdf->Output('I');
?>