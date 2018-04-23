<?php
include "../config/conn.php";
	?>
<label>Simptom </label>
<table  class="table">
				                
				                <tr>
				                	<th></th>
				                	<th colspan="2">Nama Sym</th>				                	
				                </tr>
				                <tbody>
				             <?php

				                $v=pg_query($dbconn,"SELECT * FROM master_sympton WHERE id_body='$_POST[id_body]' AND id_lokasi='$_POST[id]' ");

				                 while ($row=pg_fetch_assoc($v)) {

				                     ?>
				                       <tr>
				                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_s[]"  /></td>
				                        <td style="vertical-align:middle;"><?php echo $row["nama_sympton"] ?></td>
				                        
				                   
				                       
				                        </tr>
				                    
				                 
				                 <?php } ?> 
				                </tbody>
				                <tfoot>
				            
				                </tfoot>

				              </table>
