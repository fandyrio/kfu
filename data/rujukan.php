<?php
	session_start();
  
	include "../config/conn.php";
	$id = $_POST['id'];

	
	           			if($id==1){
                              $result =pg_query($dbconn, "SELECT * FROM master_unit ");
                          }
                          else{
                             $result =pg_query($dbconn, "SELECT r.*, u.nama FROM master_cabang_rujukan_unit r inner join
                             				master_cabang_rujukan u on u.id=r.id_rujukan where r.id_unit='$_SESSION[id_units]'  ");
                          }
                          ?>
                          <select name='id_perusahaan' id="id_perusahaan" class='form-control select2' required>
                          
                          <option value=''>Pilih Perusahaan</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
	<?php
	pg_close($dbconn);
?>
