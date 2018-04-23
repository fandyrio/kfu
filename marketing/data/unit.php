<?php
session_start();
	include "../../config/conn.php";
    if($_SESSION['id_units']>1){
        $cek ="checked";
        $perusahaan=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM master_unit_perusahaan p 
        INNER JOIN  master_unit u ON u.id=p.id_unit WHERE p.id_perusahaan='$_POST[id]' AND p.id_unit='$_SESSION[id_units]'");
    }else {
	$perusahaan=pg_query($dbconn,"SELECT  p.id_unit, u.nama FROM master_unit_perusahaan p 
		INNER JOIN 	master_unit u ON u.id=p.id_unit WHERE p.id_perusahaan='$_POST[id]'");
    $cek ="";
    }

                            while ($row =pg_fetch_assoc($perusahaan)){
                             ?>
                             <tr>
                             <td>
                             <input style="vertical-align:left; margin: 5px" type="checkbox" class="unit" value="<?php echo $row['id_unit'] ?>" name="unit[]" <?php echo $cek; ?>/>
                             </td>                                   
                              <td class="text-left"><?php echo $row["nama"];?></td>  
                              </tr>
                             <?php 
                            }
                           
	
	pg_close($dbconn);
?>