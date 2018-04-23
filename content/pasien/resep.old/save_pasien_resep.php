<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";

$id_pasien    = $_POST['id_pasien'];
$id_kunjungan = $_POST['id_kunjungan'];

$_SESSION["id_pasien"]=$id_pasien;
$_SESSION["id_kunjungan"]=$id_kunjungan;

$nama_dokter = 	$_POST['dokter'];
 if ($nama_dokter=== false) {
			$nama_dokter = NULL;
} 
 else {
			$nama_dokter = "'" . pg_escape_string($_POST['dokter']) . "'";
		}


$sql= pg_query($dbconn, "select p.id_pasien,p.total_cost,p.id_kategori_layanan, p.id_kunjungan, b.* 
		from pasien_resep p
		left outer join pasien_resep_batch b on b.id_pasien_resep = p.id
		where p.status_proses='N' and p.id_pasien='".$id_pasien."' and p.id_kunjungan='".$id_kunjungan."' and p.total_cost is not null  ");



		While($data= pg_fetch_assoc($sql)){
				  				pg_query($dbconn,"INSERT INTO inv_alokasi (ke_id_hdr, ke_id_batch, dari_id_hdr,dari_id_ln, dari_id_batch, base_qty, id_satuan, doc_type, total_cost) 
										VALUES(
										'".$data['id_pasien_resep']."',
										'".$data['id']."',
										'".$data['dari_id_hdr']."',
										'".$data['dari_id_ln']."',
										'".$data['dari_id_batch']."',
										'".abs($data['qty'])."',
										'".$data['id_satuan']."',		
										'RSP',
										'".$data['total_cost']."'
																		
										) ");
				  		

				  				$fifo= pg_query($dbconn, "select * from inv_fifo where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='".$data['dari_doc_type']."'" );
				                if($jlh=pg_num_rows($fifo)>0){
				                    $fifetch = pg_fetch_array($fifo);
				                    $qtynew= $fifetch["qty_out"] + abs($data['qty']);
				                     $costnew = $fifetch["cost_out"]+ $data['total_cost'] ;

				                   	pg_query($dbconn,"update inv_fifo set qty_out='".$qtynew."', cost_out='".$costnew."' where id_hdr='".$data['dari_id_hdr']."' and id_ln='".$data['dari_id_ln']."' AND id_batch='".$data['dari_id_batch']."' AND doc_type='".$data['dari_doc_type']."' "); 
				                   	

				                }
					                $id_details=$data['id'];
					                $qty=$data['qty'];
					                $harga=$data['total_cost'];
					                $id_kategori_harga = $data['id_kategori_layanan'];
					                pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_master_kategori_harga, id_detail, kuantitas, status_hapus) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'O', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$id_details', '$qty', 'N')");

					             

					               pg_query($dbconn, "update pasien_resep set status_proses='Y' , nama_dokter = $nama_dokter where id='".$data["id_pasien_resep"]."' ");
					               // var_dump("Delete from inv_fiforeserve id_users='".$_SESSION['id_users']."'");

					               pg_query($dbconn,"Delete from inv_fiforeserve WHERE id_users='".$_SESSION['id_users']."' "); 


					                



				  			}


?>