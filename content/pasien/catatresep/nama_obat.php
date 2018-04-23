<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

 $id_pasien=$_GET['id_pasien'];
 $id_kunjungan=$_GET['id_kunjungan'];
 $id_kategori_harga=$_GET["id_kategori_harga"];


?>


	<ul class="nav nav-tabs obat" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabnonracik" role="tab" aria-controls="tabkanan1">Resep</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabracik" role="tab" aria-controls="tabkanan2">Racikkan</a>
        </li>
    </ul>
	<div id="detail_catat_resep">
		<div class="tab-content">
			<div class="tab-pane active" id="tabnonracik" role="tabpanel">
				<table id="example2" class="table resep_loader ">
					<thead>
						<th>Racikkan</th>
						<th>Nama</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						$tampil=pg_query($dbconn,"select i.* from pasien_resep_order i where i.id_pasien='".$id_pasien."' AND i.id_kunjungan='".$id_kunjungan."' AND i.status_proses='N' ");
						while($r=pg_fetch_array($tampil)){
							?>
							<tr id="<?php echo $r['id'];?>">
								<td><input type="checkbox"
								<?php
									if($r["status_racik"]=='Y'){
										echo "checked";
									}
								?>
								disabled ></td>	
								<td><?php echo $r['nama_brand'];?></td>	
								<td style="text-align: right;">
									<button class="btn btn-danger btn-xs btnHapusItemResep" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
								</td>						
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="tabracik" role="tabpanel">

				<form class="form-horizontal" id="racikan" action="">
				<input type="hidden" name="id_pasien" value="<?php echo $id_pasien ?>">
				<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan ?>">
				<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga ?>">
				<table id="example3" class="table resep_loader ">
					<thead>
						
						<th>Nama</th>
						<th>Qty</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						$tampil=pg_query($dbconn,"SELECT i.* from pasien_resep_order_detail i where i.id_pasien='$id_pasien' AND i.id_kunjungan='$id_kunjungan' and i.id_pasien_resep_order is NULL  ");
						while($r=pg_fetch_array($tampil)){
							
							?>
							<tr id="<?php echo $r['id'];?>">
								<td><?php echo $r['nama_brand'];?></td>
								<td><input type="text" name='qty#<?php echo $r[id] ?>' value='<?php echo "0" ?>'></td>	
								<td style="text-align: right;">
									<button class="btn btn-danger btn-xs btnHapusItemRacik" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
								</td>						
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>

				<!-- <?php 
				 $getIdKunjungan=pg_query("SELECT pro.*, mu.kode as kode_outlet from pasien_resep_order pro join master_unit mu on mu.id=pro.id_unit where pro.id='$id'");
			    $fetchKunjungan=pg_fetch_assoc($getIdKunjungan);
			    $noKunjungan=$fetchKunjungan['id_kunjungan'];

			    $check=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$noKunjungan'");
			    $jumlah=pg_num_rows($check);
			    if($jumlah==0)
			    {
			      $getMax=pg_query("SELECT max(id) as maxId from pasien_no_resep");
			      $fetchMax=pg_fetch_assoc($getMax);
			      $public_id=$fetchMax['maxid']+=1;
			      $sprintF=sprintf("%06d", $public_id);

			      $unikUnit=sprintf("%03d", $_SESSION['id_units']);
			      $public_idResep="R".$unikUnit.'0'.$sprintF;

			      $noResep=$fetchKunjungan['kode_outlet'].' / '.date('Y').date('m').' / '.$sprintF;

			      $insert=pg_query("INSERT into pasien_no_resep (id_kunjungan, public_id, no_resep) values ('$noKunjungan', '$public_idResep', '$noResep')");

			    }

			     ?> -->

				<div class="form-group row">
					<label class="col-md-4 form-control-label">Nama Barang </label>
					<div class="col-md-6">
							<input type="text" class="form-control" name="nama_barang">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-4 form-control-label">Kode Barang </label>
					<div class="col-md-6">
							<input type="text" class="form-control" value="<?php echo $noResep ?>" name="kode_barang">
					</div>
				</div>
				<div class="form-group row">
				    <label  class="col-sm-4 form-control-label">Sediaan</label>
					<div class="col-sm-8" >                     
						<?php
						   	$result =pg_query($dbconn, "SELECT * FROM inv_satuan");
						?>

					<select name='Sediaan' class='form-control' required>
						<option value=''>Pilih</option>
						<?php 
						while ($row =pg_fetch_assoc($result)){
						 
						     echo "<option value='".$row['id']."'>".$row['nama']."</option>";
						     
						 }
						?>
					 </select>
					</div>
				</div> 

				<div class="col-md-12 text-right">
					<button type="button" class="btn btn-primary btn-sm" id="btnSimpanRacik">Simpan Racik</button>
				</div>
				</form>
								
			</div>
		</div>
	</div>

		
					