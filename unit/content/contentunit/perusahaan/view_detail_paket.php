<?php
	include "../../config/conn.php";
	$id = $_POST["id"];
	?>
	<table class="input2" class="table table-bordered table-striped" >
      <thead  class="table-info">
        <th></th>
        <th width="110px">Jenis</th>
        <th width="10px">Harga</th>
        <th colspan="2" width="40px" class="text-center">Disc</th>
        
      </thead>

        <tbody>
                <tr><td colspan="5"><label><b>Non Laboratorium</b></label></td></tr>
            <?php
							$res=pg_query($dbconn,"Select * from billing_paket_detail where id_billing_paket='$id'
								and jenis='T' ");


                            while ($row=pg_fetch_assoc($res)) {
                            	$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='$row[id_detail]'"));
                                 ?>
                                   <tr>
                                   <td>
                                    <input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_detail'] ?>" name="tindakan[]" />
                                    </td>
                                  
                                    <td class="text-left ">
                                    <?php echo $data["nama"] ?>
                                      
                                    </td>
                                     <td>
                                     <input type="text" name="harga_tindakan[]" placeholder="Rp" disabled style="width: 120px !important;" /></td>
                                     <td >
                                     <input type="text" name="dis_persen_tindakan[]" placeholder="%" disabled style="width: 50px !important;" maxlength="3" />                                   
                                     </td>
                                     <td>
                                     <input type="text" name="dis_amt_tindakan[]" placeholder="Rp" disabled style="width: 90px !important;"/>
                                     </td>
                                                 
                                </tr>
                          <?php 
                          } 
                ?> 
           <br>
           <tr><td colspan="5"><label><b>Laboratorium</b></label></td></tr>
                       <?php

                      $res=pg_query($dbconn,"Select * from billing_paket_detail  where id_billing_paket='$id'
                                   and jenis='L'");

                            while ($row=pg_fetch_assoc($res)) {
                              $data=pg_fetch_array(pg_query($dbconn,"Select * from lab_analysis where id='$row[id_detail]'"));
                                 ?>
                                   <tr>
                                    <td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_detail'] ?>" name="lab_analysis[]" /></td>
                                   
                                    <td class="text-left" ><?php echo $data["nama"] ?></td>
                                    <td ><input type="text" name="harga_lab[]" placeholder="Rp" disabled style="width: 120px !important;" /></td>
                                    <td><input type="text" name="dis_persen_lab[]" placeholder="%" disabled style="width: 50px !important;" /></td>
                                     <td><input type="text" name="dis_amt_lab[]" placeholder="Rp" disabled style="width: 90px !important;" /></td>
                               
                                   
                                    </tr>  

                  <?php
                  }
                  ?> 
                  <tr class="table-info">
                  <td>
                    <input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_detail'] ?>" name="total_paket" />
                                    </td>
                  </td>
                    <td colspan="2"><b>Diskon Total</b></td>
                    <td><input type="text" name="dis_unit_persen" placeholder="%"  style="width: 50px !important;"/></td>
                    <td><input type="text" name="dis_unit_amt" placeholder="Rp" style="width: 90px !important;" /></td>
                  </tr>
                  </tbody>             
					</table>
		<?php			
	
	pg_close($dbconn);
?>