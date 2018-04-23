<?php
	session_start();
  
	include "../config/conn.php";
	$id = $_POST['id'];
	$result =pg_query($dbconn, "SELECT * FROM billing_paket WHERE id='$id' ");                        
  ?>
                          <select name='id_paket' id="id_paket" class='form-control ' required>
                          
                          <option value=''>Pilih Paket</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama_paket']."</option>";
                          }
                          ?>
                          </select>
	<?php
	pg_close($dbconn);
?>
