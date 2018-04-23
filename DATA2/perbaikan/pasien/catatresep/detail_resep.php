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
									<input value="<?php echo $data['nama_brand'];?>" type="text"  id="nama_brand">
									<div class="form-group data-lab2" id="data_laborder_kanan">
									<fieldset>	
									<div class="form-group row">
										<label class="col-md-2 form-control-label">Dosis  </label>
										<div class="col-md-10">
										<input value="<?php echo $data['dosis'];?>" type="text" class="form-control" name="dosis" id="dosis" readonly placeholder="0x0x0"> 
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 form-control-label">Diberi </label>
										<div class="col-md-3">
									
											<input value="<?php echo $data['diberi'];?>" type="text" class="form-control diberi" name="diberi">
										</div>
										<div class="col-md-7">
											<?php 
				                          $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
				                         
				                          ?>
				                          <select name='id_satuan' class='form-control' disabled>
				                          
				                          <option value=''></option>
				                          <?php 
				                          while ($row =pg_fetch_assoc($result)){
				                          	if($t['id_satuan']==$row['id']){
				                          			echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
				                          	}else  echo "<option value='".$row['id']."'>".$row['nama']."</option>";
				                          }
				                          ?>
				                          </select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 form-control-label">Kali/Hari </label>
										<div class="col-md-4">
											<input value="<?php echo $data['jumlah_perhari'];?>" type="text" class="form-control" name="jumlah_perhari">
										</div>
										<label class="col-md-2 form-control-label">Dept </label>
										<div class="col-md-4">
										<select name="id_departemen" id="id_departemen_resep" class="form-control" disabled>
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM inv_departemen");
										while($r=pg_fetch_array($tampil)){
											if($data['id_departemen']==$r['id']){
												echo"<option value='$r[id]' selected>$r[nama]</option>";
											}
											else {
												echo"<option value='$r[id]'>$r[nama]</option>";
											}
											
										}
										?>
									</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 form-control-label">Hari </label>
										<div class="col-md-4">
											<input value="<?php echo $data['number_of_day'];?>" type="text" class="form-control" name="number_of_day">
										</div>
									</div>
									<div class="form-group row">
				                      <label  class="col-sm-2 form-control-label">Intruksi</label>

				                      <div class="col-sm-5" >                     
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
				                      

				                      <div class="col-sm-5" style="padding-left: 0px">                      
				                        <?php 
				                          $result =pg_query($dbconn, "SELECT * FROM inv_intruksi_obat");
				                         
				                          ?>
				                          <select name='instruksi2' class='form-control' required>
				                          
				                          <option value=''>Pilih</option>
				                          <?php 
				                          while ($row =pg_fetch_assoc($result)){
				                            	if($data['instruksi2']==$row['id']){
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
				                      <label  class="col-sm-2 form-control-label">Indikasi</label>

				                      <div class="col-sm-10" >                     
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
				                     
				                      <div class="form-group row">
				                      <label class="col-sm-2 form-control-label">Dari</label>
									<div class="col-sm-4">
										<input type="date" name="tanggal_awal" value="<?php echo $data['tgl_mulai'];?>" class="form-control" required>
									</div>
				                      

				                    <label class="col-sm-2 form-control-label">s/d Tgl</label>
									<div class="col-sm-4">
									<input type="date" name="tanggal_akhir" value="<?php echo $data['tgl_akhir'];?>" class="form-control" required>
									</div>
				                      </div> 
				                      <div class="form-group row">
				                      <label  class="col-sm-2 form-control-label">Total</label>

				                      <div class="col-sm-3" >
				                                         
				                        <input value="0"   type="number" name="total"  class="form-control" value="<?php echo $data['qty'];?>">
				                          
				                      </div>

				                      
				                      </div> 
				                      </fieldset>
				                  </form>

									<div class="col-md-6">
										<button type="button" class="btn btn-primary btn-xs" id="btnUpdateResep">Update</button>
						
									</div>
									</div>
									
		