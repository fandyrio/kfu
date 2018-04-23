<?php
	session_start();
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Lab Order</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Import Data
							
						</div>
						<div class="card-block">
		<div style="padding: 0 15px;">

			
			
			<form method="post" action="" enctype="multipart/form-data">
				<a href="Format2.xlsx" class="btn btn-success">
					<span class="glyphicon glyphicon-download"></span>
					Download Format
				</a>
				
				<a href="Contoh2.xlsx" class="btn btn-primary">
					<span class="glyphicon glyphicon-download"></span>
					Download Contoh
				</a>
				<br><br>
				

				<input type="file" name="file" class="pull-left">
				
				<button type="submit" name="preview" class="btn btn-success btn-sm">
					<span class="fa fa-eye"></span> Preview
				</button>
			</form>
			
			<hr>
			
			<!-- Buat Preview Data -->
			<?php
			// Jika user telah mengklik tombol Preview
			if(isset($_POST['preview'])){

			
				$nama_file_baru = 'data.xlsx';
				if(is_file('tmp/'.$nama_file_baru)) 
					unlink('tmp/'.$nama_file_baru); 
				
				$tipe_file = $_FILES['file']['type']; 
				$tmp_file = $_FILES['file']['tmp_name'];
				
				if($tipe_file == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){

					//$cek =move_uploaded_file($tmp_file, 'content/import/tmp/'.$nama_file_baru);
					//var_dump($tmp_file);
					move_uploaded_file($tmp_file, 'tmp/'.$nama_file_baru);
					// Load librari PHPExcel nya
					require_once 'PHPExcel/PHPExcel.php';
					
					$excelreader = new PHPExcel_Reader_Excel2007();
					$loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
					$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

					
					echo "<form method='post' class='form-horizontal' action='aksi-import'>";

					 echo "<div class='form-group'>
                    <label ><b>Perusahaan</b></label>";
                     
                      $result =pg_query($dbconn, "SELECT h.* FROM master_kategori_harga h 
                                INNER JOIN master_unit_perusahaan p ON p.id_perusahaan = h.id 
                                WHERE p.id_unit='$_SESSION[id_units]'");

                      echo "<select name='id_perusahaan' id='id_perusahaan' class='form-control col-md-4 id_per' required>
                      
                      <option value=''>Pilih Perusahaan</option>";
                  
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
               
	                 	echo "</select></div>";

	                echo "<div class='form-group'>
                    <label ><b>Pilih Event MCU</b></label>";
                     
               
	                 	echo "<div id='pilih_sel'></div>
	           			</div>"; 	
	                 	

	                  echo "<div class='form-group row'>
		                    <label class='col-md-2'><b>Skala Pemeriksaan</b></label>";
		                      echo "<input id='datepicker' name='jadwal' value='".date("d-m-Y")."' class='form-control col-md-2' >
		                       <b> To </b>
		                      <input id='datepicker2' name='jadwal_akhir' value='".date("d-m-Y")."' class='form-control col-md-2' >";
		                                               
	                  echo "</div>";

						
						echo "<div class='alert alert-danger' id='kosong'>
						 Ada <span id='jumlah_kosong'></span> data NIK yang belum diisi.
						</div>";
						
						echo "<div style='overflow-y:scroll' ><table class='table table-bordered'>
						<tr>
							<th colspan='9' class='text-center'>Preview Data</th>
						</tr>
						<tr>
							<th>No</th>
							<th>NIK</th>
							<th>No BPJS</th>
							<th>Id lainnya</th>
							<th>Nama</th>
							<th>Tanggal Lahir</th>
							<th>Jenis Kelamin</th>
							<th>Departemen</th>
							<th>Divisi</th>
							<th>Jabatan</th>						
							<th>Tanggal Mulai Bekerja</th>						
						</tr>";
					
					$numrow = 1;
					$kosong = 0;

					foreach($sheet as $row){
						
						$no = $row['A'];
						$nik = $row['B']; 
						$no_bpjs = $row['C']; 
						$id_lainnya = $row['D']; 
						$nama = $row['E'];
						$tgl_lahir = $row['F']; 
						$jenkel = $row['G']; 
						$unit_kerja = $row['H'];
						$divisi = $row['I']; 
						$jabatan = $row['J']; 
						$tanggal_mulai_bekerja = $row['K']; 
						
						// Cek jika semua data tidak diisi
						/*if(empty($nik) && empty($no_bpjs) && empty($id_lainnya) && empty($nama) && empty($alamat))
							continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)*/
						
						// Cek $numrow apakah lebih dari 1
						// Artinya karena baris pertama adalah nama-nama kolom
						// Jadi dilewat saja, tidak usah diimport
						if($numrow > 1){
							// Validasi apakah semua data telah diisi
							$no_td = ( ! empty($no))? "" : " style='background: #EFF2F4;'";
							$nik_td = ( ! empty($nik))? "" : " style='background: #EFF2F4;'";
							$no_bpjs_td = ( ! empty($no_bpjs))? "" : " style='background: #EFF2F4;'"; 
							$id_lainnya_td = ( ! empty($id_lainnya))? "" : " style='background: #EFF2F4;'"; 
							$nama_td = ( ! empty($nama))? "" : " style='background: #EFF2F4;'";
							$tgl_lahir_td = ( ! empty($tgl_lahir))? "" : " style='background: #EFF2F4;'";
							$jenkel_td = ( ! empty($jenkel))? "" : " style='background: #EFF2F4;'";
							$unit_kerja_td = ( ! empty($unit_kerja))? "" : " style='background: #EFF2F4;'";
							$divisi_td = ( ! empty($divisi))? "" : " style='background: #EFF2F4;'";
							$jabatan_td = ( ! empty($jabatan))? "" : " style='background: #EFF2F4;'";
							$tanggal_mulai_bekerja_td = ( ! empty($tanggal_mulai_bekerja))? "" : " style='background: #EFF2F4;'";

							/*if(empty($nik)){
								$kosong++; // Tambah 1 variabel $kosong
							}*/
							echo "<tr>";
							echo "<td".$no_td.">".$no."</td>";
							echo "<td".$nik_td.">".$nik."</td>";
							echo "<td".$no_bpjs_td.">".$no_bpjs."</td>";
							echo "<td".$id_lainnya_td.">".$id_lainnya."</td>";
							echo "<td".$nama_td.">".$nama."</td>";
							echo "<td".$tgl_lahir_td.">".$tgl_lahir."</td>";
							echo "<td".$jenkel_td.">".$jenkel."</td>";
							echo "<td".$unit_kerja_td.">".$unit_kerja."</td>";
							echo "<td".$divisi_td.">".$divisi."</td>";
							echo "<td".$jabatan_td.">".$jabatan."</td>";
							echo "<td".$tanggal_mulai_bekerja_td.">".$tanggal_mulai_bekerja."</td>";
							echo "</tr>";
						}
						
						$numrow++; // Tambah 1 setiap kali looping
					}
					
					echo "</table></div>";
					
					// Cek apakah variabel kosong lebih dari 1
					// Jika lebih dari 1, berarti ada data yang masih kosong
					if($kosong > 0){
					?>	
						<script>
						$(document).ready(function(){
							// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
							$("#jumlah_kosong").html('<?php echo $kosong; ?>');
							
							$("#kosong").show(); // Munculkan alert validasi kosong

							
						});
					
						</script>
					<?php
					}else{ // Jika semua data sudah diisi
						echo "<hr>";
						
						// Buat sebuah tombol untuk mengimport data ke database
						echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";

						?>
						<script>
						$("#pilih_sel").load("data/event_import.php?");
						$('.id_per').change(function(){
							
							var id= $('#id_perusahaan').val();
							$("#default_sel").hide();

							$("#pilih_sel").load("data/event_import.php?id="+id); 

							});
						</script>
						<?php
					}
					
					echo "</form>";
				}else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
					// Munculkan pesan validasi
					echo "<div class='alert alert-danger'>
					Hanya File Excel 2007 (.xlsx) yang diperbolehkan
					</div>";
				}
			}
			?>

		</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>


