<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$data=pg_fetch_assoc(pg_query($dbconn,"SELECT i.* from pasien_resep_order i where i.id='".$_POST['id']."' AND i.id_unit='$_SESSION[id_units]'"));
$t=pg_fetch_assoc(pg_query($dbconn,"SELECT  qty, id_satuan from pasien_resep_order_detail  where id_pasien_resep='".$_POST['id']."' "));

?>
<br>
<form method="POST" class="form-horizontal" enctype="multipart/form-data" id="form_resep">
	<input value="<?php echo $_POST['id'];?>" type="hidden"  name="id" id="id_resep">
	<input style="border:none; font-weight: bold;" value="<?php echo $data['nama_brand'];?>" type="text"  id="nama_brand">
		<div class="form-group data-lab2" id="data_laborder_kanan">
		<fieldset>	
		<div class="form-group row">
			<label class="col-md-3 form-control-label">Aturan Pakai  </label>
		<div class="col-md-8">
		<input style="width:100px;" value="<?php echo $data['dosis'];?>" type="text" class="form-control" name="dosis" id="dosis" readonly placeholder="0x0"> 
								
		</div>
		</div>
		<div class="form-group row">
		<label class="col-md-3 form-control-label">Diberi </label>
			<div class="col-md-3">
											
				<input value="<?php echo $data['diberi'];?>" type="text" class="form-control diberi" name="diberi">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 form-control-label">Kali/Hari </label>
			<div class="col-md-3">
				<input value="<?php echo $data['jumlah_perhari'];?>" type="text" class="form-control" name="jumlah_perhari">
			</div>
										
		</div>
		<div class="form-group row">
			<label class="col-md-3 form-control-label">Hari </label>
			<div class="col-md-3">
					<input value="<?php echo $data['number_of_day'];?>" type="text" class="form-control" name="number_of_day">
			</div>
		</div>
		<div class="form-group row">
		    <label  class="col-sm-3 form-control-label">Cara Pakai</label>
			<div class="col-sm-9" >                     
				<?php
				   	$result =pg_query($dbconn, "SELECT * FROM inv_intruksi_obat");
				?>
			<select name='instruksi1' class='form-control' required>
				<option value=''>Pilih</option>
				<?php 
				while ($row =pg_fetch_assoc($result)){
				   if($data['instruksi1']==$row['id']){
				     echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
				    }
				else{
				     echo "<option value='".$row['id']."'>".$row['nama']."</option>";
				     }
				 }
				?>
			 </select>
			</div>
		</div> 

		<div class="form-group row">
			<label  class="col-sm-3 form-control-label">Keterangan</label>
				 <div class="col-sm-9" >                     
				<?php 
					$result =pg_query($dbconn, "SELECT * FROM inv_indikasi");
				    ?>
			<select name='indikasi' class='form-control' required>
			<option value=''>Pilih</option>
				<?php 
				    while ($row =pg_fetch_assoc($result)){
				    if($data['indikasi']==$row['id']){
				       echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
				    }
				    else{
				        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
				    }
				    }
				?>
			</select>
		</div>
	</div>
	</fieldset>
		<fieldset>
			<br />
			<div class="form-group row">
				<label  class="col-sm-3 form-control-label">Total</label>
				<div class="col-sm-4" >
				<input type="text" name="total"  class="form-control" id="total_obat" value="<?php echo $data['qty'];?>">
				</div>
			</div> 
		</fieldset>
</form>
	<div class="col-md-6">
		<button type="button" class="btn btn-primary btn-xs" id="btnUpdateResep">Update</button>
	</div>
</div>
									
		