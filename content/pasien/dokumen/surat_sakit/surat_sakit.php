<?php
session_start();
require('../../../../fpdf/fpdf.php');
include "../../../../config/conn.php";
include "../../../../config/library.php";
include "../../../../config/fungsi_tanggal.php";

$images="../../../../images/klinik_pratama.jpg";
$imagesCC="../../../../images/cc.png";



$idPasien=$_POST['idPasien'];
$idDokter=$_POST['id_dokter'];
$diBuatDi=$_POST['dibuat_di'];

$mulai_istirahat=$_POST['mulai_istirahat'];
$selesai_istirahat=$_POST['selesai_istirahat'];

$tgl_awal=date_create($mulai_istirahat);
$tgl_akhir=date_create($selesai_istirahat);

$hariIstirahat=date_diff($tgl_awal, $tgl_akhir);
$selisih=$hariIstirahat->d;
$selisih+=1;

$idUnit=$_SESSION['id_units'];
$getUnitInfo=pg_fetch_assoc(pg_query("SELECT * from master_unit where id='$idUnit'"));
$kodeUnit=$getUnitInfo['kode'];

$getDataPasien=pg_query("SELECT mps.* from master_pasien mps where mps.id='$idPasien'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);

$getDataPekerjaan=pg_query("SELECT * from master_pekerjaan where id='$fetchDataPasien[id_pekerjaan]'");
$fetchDataPekerjaan=pg_fetch_assoc($getDataPekerjaan);

$getDataDoker=pg_query("SELECT * from master_karyawan where id='$idDokter'");
$fetchDokter=pg_fetch_assoc($getDataDoker);


//get data pemeriksaan fisik
//===============================================
$getDataDiagnosa=pg_query("select * from pasien_diagnosa_detail pdd join master_icd10 micd on micd.id=pdd.id_diagnosa 
	join kunjungan k on k.id=pdd.id_kunjungan where 
	pdd.id_kunjungan=(select max(id) from kunjungan where id_pasien='$idPasien' and status_kunjungan='Y')");


$dataDiagnosa=array();
while($fetchDataDiagnosa=pg_fetch_assoc($getDataDiagnosa))
{
	$diagnosa .= $fetchDataDiagnosa['nama']." ,";
}

//===============================================
//data Klinik
$tipeKlinik="KLINIK PRATAMA";
$namaKlinik=$getUnitInfo['nama'];
$alamat='Alamat : '.$getUnitInfo['alamat'].' Telp. '.$getUnitInfo['telepon'];
//================================================

//data dokter
$namaDokter=$fetchDokter['nama'];
$sip=$fetchDokter['no_izin_praktek'];
//================================================

//data pasien
if($fetchDataPasien['jenkel']==1)
{
	$jenisKelamin="Laki - Laki";
}
else
{
	$jenisKelamin="Perempuan";
}

$tanggal_lahir=date_create($fetchDataPasien['tanggal_lahir']);
$tgl_sekarang=date_create();
	
$diff=date_diff($tanggal_lahir,$tgl_sekarang);
//echo"$diff[y] tahun, $diff[m] bulan, $diff[d] hari";

$namaPasien=$fetchDataPasien['nama'];
$tempaTanggaLahir=$fetchDataPasien['tempat_lahir'];
$umurPasien=$diff->y;
$pekerjaan=$fetchDataPekerjaan['nama'];
$alamatPasien=$fetchDataPasien['alamat'];
$hasil="SEHAT JASMANI";
$tujuan=$tujuan;

	$tanggal=date('d F Y');
	$jam=date('h:i:s');
	$timeStamp=$tanggal.' '.$jam;


$uniqueName=date('d').date('m').date('Y').$idPasien.date('h').date('i').date('s');
$namaFile="surat_sakit".$uniqueName.".pdf";



$thisYear=date('Y');
$thisMonth=date('m');
$getMaxId=pg_query("SELECT count(id) as jumlah from pasien_dokumen where id_dokumen='1' and extract(month from created_at::TIMESTAMP)='$thisMonth' and extract(year from created_at::TIMESTAMP)='$thisYear' and status_hapus='N'");
$fetchMaxId=pg_fetch_assoc($getMaxId);
$jumlahData=pg_num_rows($getMaxId);


if($jumlahData==0)
{
	$runningNumber=sprintf('%04d', 1);
}
else
{
	$jumlah=$fetchMaxId['jumlah']+=1;
	$runningNumber=sprintf('%04d', $jumlah);	
}
//FORMAT NO SURAT =KSEHAT/  Kode Unit /  / MONTH / YEAR / Running Number
$noSurat='KSAKIT/'.$kodeUnit.'/'.$thisMonth.'/'.$thisYear.'/'.$runningNumber;


$insertDokumen=pg_query("INSERT into pasien_dokumen (no_surat,id_dokumen,id_dokter,created_at,dibuat_di,id_pasien,nama_file, mulai_istirahat, selesai_istirahat)
	values('$noSurat','1', '$idDokter','$timeStamp', '$diBuatDi', '$idPasien','$namaFile','$mulai_istirahat', '$selesai_istirahat');
	");


$pdf = new FPDF();
$pdf->AddPage();
$pdf->Cell(-10);
$pdf->SetFillColor(91,155,213);
$pdf->Rect(0, 0, 10, 297, 'F');
$pdf->setXY(10,0);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(110,6,$tipeKlinik,0,'C',true);
$pdf->setXY(10,5);
$pdf->SetTextColor(256,256,256);
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(110,10,$namaKlinik,0,'C',true);
$pdf->setXY(10,15);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(110,4,$alamat,0,'L',true);

$pdf->Cell( 40, 40, $pdf->Image($images, 130, 0, 60), 0, 0, 'L', false );
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20,40, 'Nomor Surat : ');
$pdf->Text(45,40, $noSurat);

$pdf->SetFont('Arial','',3);
$pdf->SetTextColor(0,0,256);
$pdf->Text(30,44,'___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');
$pdf->Text(30,53,'___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Text(70,50,'SURAT KETERANGAN SAKIT');
$pdf->SetFont('Arial','',11);
$pdf->Text(30,60,'Yang bertanda tangan dibawah ini:');

$x=68;
$pdf->Text(40,68, 'Nama');
$pdf->Text(80,68,":");
$pdf->Text(85,68,$namaDokter);
$pdf->Text(40,$x+=5, 'SIP');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$sip);

$pdf->Text(30,$x+=8,'menerangkan telah memeriksa kesehatan dari:');

$pdf->Text(40,$x+=8, 'Nama');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$namaPasien);
$pdf->Text(40,$x+=5, 'Tempat / Tanggal Lahir');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$tempaTanggaLahir);
$pdf->Text(40,$x+=5, 'Jenis Kelamin');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$jenisKelamin);
$pdf->Text(40,$x+=5, 'Umur');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$umurPasien." Tahun");
$pdf->Text(40,$x+=5, 'Pekerjaan');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$pekerjaan);
$pdf->Text(40,$x+=5, 'Alamat');
$pdf->Text(80,$x,":");
$pdf->setXY(84,$x-3);
$pdf->MultiCell(110,5,$alamatPasien,0,'L',false);

$pdf->Text(30, $x+=15,'Berdasarkan hasil pemeriksaan yang telah dilakukan. Pasien tersebut dalam keadaan');
$pdf->Text(30,$x+=5,'SAKIT, sehingga perlu beristirahat selama '.$selisih.' hari dari tanggal '.date('d F Y', strtotime($mulai_istirahat)));
$pdf->Text(30,$x+=5,'sampai dengan '.date('d F Y', strtotime($selesai_istirahat)));
$pdf->Text(30, $x+=7, 'Diagnosa :  '. $diagnosa);
$pdf->SetFont('Arial','B',11);


$pdf->SetFont('Arial','',11);
$pdf->Text(30, $x+=8,'Demikian surat keterangan ini di buat untuk dipergunakan sebagaimana perlunya.');


$pdf->SetFont('Arial','I', 11);
$pdf->Text(30,$x+=10,'Terimakasih');
$pdf->Text(30,$x+=5,'Semoga Sehat Selalu');

$pdf->SetFont('Arial','', 11);
$pdf->Text(30,$x+=15,$diBuatDi.', '.$tanggal);
$pdf->SetFont('Arial','UB', 11);
$pdf->Text(30,$x+=25,$namaDokter);

$pdf->Cell( 40, 20, $pdf->Image($imagesCC, 10, $x+=3, 60), 0, 0, 'L', false );

$pdf->Output("../dokumen_surat/".$namaFile,"F");
?>