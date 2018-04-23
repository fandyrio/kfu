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
$tujuan=$_POST['tujuan_surat'];
$diBuatDi=$_POST['dibuat_di'];

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
$getDataFisik=pg_query("SELECT * from pasien_fisik_detail pfd join fisik f on f.id=pfd.id_fisik join pasien_fisik pf on pf.id=pfd.id_pasien_fisik
 where pf.id_pasien='$idPasien'");


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

$arrayFisik=array();
while($fetchDataFisik=pg_fetch_assoc($getDataFisik))
{
	array_push($arrayFisik, $fetchDataFisik['nilai']);
}
	$beratBadan=$arrayFisik[0];
	$tinggiBadan=$arrayFisik[1];
	$tekananDarah=$arrayFisik[2];	
	$denyutNadi=$arrayFisik[3];
	$butaWarna="Negatif";
	$tanggal=date('d F Y');
	$jam=date('h:i:s');
	$timeStamp=$tanggal.' '.$jam;


$uniqueName=date('d').date('m').date('Y').$idPasien.date('h').date('i').date('s');
$namaFile="surat_bebas_narkoba".$uniqueName.".pdf";



$thisYear=date('Y');
$thisMonth=date('m');
$getMaxId=pg_query("SELECT count(id) as jumlah from pasien_dokumen where id_dokumen='3' and extract(month from created_at::TIMESTAMP)='$thisMonth' and extract(year from created_at::TIMESTAMP)='$thisYear' and status_hapus='N'");
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
$noSurat='KBN/'.$kodeUnit.'/'.$thisMonth.'/'.$thisYear.'/'.$runningNumber;

//1 -> Surat Sehat
//2 -> Surat Sakit
//3 -> SUhat Bebas Narkoba
//4 -> Surat rujukan

$insertDokumen=pg_query("INSERT into pasien_dokumen (no_surat,id_dokumen,id_dokter,created_at,tujuan,dibuat_di,id_pasien,nama_file)
	values('$noSurat','3', '$idDokter','$timeStamp', '$tujuan', '$diBuatDi', '$idPasien','$namaFile');
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
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(256,256,256);
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
$pdf->Text(70,50,'SURAT KETERANGAN BEBAS NARKOBA');
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

$pdf->Text(30, $x+=15,'Berdasarkan hasil pemeriksaan beberapa zat Adiktif /Narkoba pada urine yang');
$pdf->Text(30,$x+=5,'bersangkukan pada Senin, 25 September 2017, dengan hasil sebagai berikut:');
$pdf->SetFont('Arial','B',11);

//Table header
	//colom 1
		//baris 1
			$pdf->setXY(74,$x+=5);
			$pdf->MultiCell(10,5,'No.',1,'L',false);
		//=
		//baris 2
			$pdf->setXY(84,$x);
			$pdf->MultiCell(60,5,'JENIS PEMERIKSAAN',1,'L',false);
		//=
		//baris 3
			$pdf->setXY(144,$x);
			$pdf->MultiCell(25,5,'HASIL',1,'L',false);
		//=
	//=
	//colom 2
		//baris 1
			$pdf->setXY(74,$x+=5);
			$pdf->MultiCell(10,5,'1.',1,'L',false);
		//=
		//baris 2
			$pdf->setXY(84,$x);
			$pdf->MultiCell(60,5,'Amphetamine',1,'L',false);
		//=
		//baris 3
			$pdf->setXY(144,$x);
			$pdf->MultiCell(25,5,'Negatif (-)',1,'L',false);
		//=
	//=
	//colom 3
		//baris 1
			$pdf->setXY(74,$x+=5);
			$pdf->MultiCell(10,5,'2.',1,'L',false);
		//=
		//baris 2
			$pdf->setXY(84,$x);
			$pdf->MultiCell(60,5,'Opiate /Morphine',1,'L',false);
		//=
		//baris 3
			$pdf->setXY(144,$x);
			$pdf->MultiCell(25,5,'Negatif (-)',1,'L',false);
		//=
	//=
	//colom 4
		//baris 1
			$pdf->setXY(74,$x+=5);
			$pdf->MultiCell(10,5,'3.',1,'L',false);
		//=
		//baris 2
			$pdf->setXY(84,$x);
			$pdf->MultiCell(60,5,'Cannabinoid /THC',1,'L',false);
		//=
		//baris 3
			$pdf->setXY(144,$x);
			$pdf->MultiCell(25,5,'Negatif (-)',1,'L',false);
		//=
	//=
//=

$pdf->SetFont('Arial','', 11);
$pdf->Text(30,$x+=15,'Kesimpulan: Yang bersangkutan Bebas dari Zat Adiktif /Narkoba tersebut.');
$pdf->Text(30,$x+=15,'Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan sebagaimana perlunya.');
$pdf->SetFont('Arial','I', 11);
$pdf->Text(30,$x+=10,'Terimakasih');
$pdf->Text(30,$x+=5,'Semoga Sehat Selalu');

$pdf->SetFont('Arial','', 11);
$pdf->Text(30,$x+=15,$diBuatDi.', '.$tanggal);
$pdf->SetFont('Arial','UB', 11);
$pdf->Text(30,$x+=25,$namaDokter);

$pdf->Cell( 40, 20, $pdf->Image($imagesCC, 10, $x+=3, 60), 0, 0, 'L', false );

$pdf->Output("../dokumen_surat/".$namaFile,"F");
//$PDF->Output();
?>