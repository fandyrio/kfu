			    <div class="row">
			
                <div class="col-md-6 ">
				<div class="box-body">
                 <div class="form-group" style="margin-bottom:55px !important;">
                    <label class="col-sm-3">Metode Harga</label>
					<div class="col-sm-9">
                      <select name='metode_harga' class='form-control' required>
                      	 <option value=''>Pilih</option>
                      
                      <option value='S'>Harga Standar</option>
                      <option value='M'>Harga Markup</option>
                      
                      </select>
					</div>
                  </div>
				   <div class="form-group" style="margin-bottom:5px !important;">
                    <label class="col-sm-3">Harga Layanan</label>
					<div class="col-sm-9">

			               <table id="example1" class="table table-bordered table-striped">
			                <thead>
			                </thead>
			                <tbody>
			             <?php
			                 $res=pg_query($dbconn,"Select * from master_kategori_harga");

			                 while ($row=pg_fetch_assoc($res)) {
			                     ?>
			                       <tr >
			                        <td style="vertical-align:middle;"  ><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_layanan[]" /></td>
			                        
			                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>


			                        <td id="uang">
			                        	
			                        <input type="text" name="harga[]"  placeholder="Rp"   disabled  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></td>
			                   
			                     
			                        </tr>
			                    
			                 
			                 <?php } ?> 
			                </tbody>
			                <tfoot>
			            
			                </tfoot>

			              </table>
					</div>
                  </div>
				  
				  </div>
            </div>
			</div>