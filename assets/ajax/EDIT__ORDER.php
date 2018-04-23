<?php 
$id=$_POST['id'];
$id_pasien=$_POST['id_pasien'];
$id_kunjungan=$_POST['id_kunjungan'];
$id_kategori_harga=$_POST['id_kategori_harga'];


		
		?>
<input type="hidden" name="id" value="<?php echo $id;?>" id="id"> 
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien"> 	
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga;?>" id="id_kategori_harga">
<input type="hidden" name="rm" value="<?php echo $_POST[rm];?>" id="rm">
		<div class="card">
			<div class="card-header">
				<strong>EDIT </strong>
			</div>
			<div class="card-block">
				<div class="row">
						<div class="col-md-12">
					<div class="form-group row">
						<label class="col-md-3 form-control-label">Keterangan</label>
						<div class="col-md-9">
							<textarea  name="keterangan" id="keterangan"  class="form-control" placeholder="Keterangan/Catatan"></textarea>
						</div>
					</div>
				</div>
					
					<div class="col-md-12">
						<fieldset>
							<legend>Daftar Order</legend>
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">Single Test</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkiri2" role="tab" aria-controls="tabkiri2">Multi Test</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkiri3" role="tab" aria-controls="tabkiri2">Non Lab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkiri4" role="tab" aria-controls="tabkiri2">MCU</a>
                                </li>

                            </ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tabkiri1" role="tabpanel" style="overflow-y: scroll;">
									<br>
									 <table id="myTable6" class="table">
                    <thead class="table-info">
                    <tr>
                    <th width="10px"></th>
                      <th width="">Nama</th>
                      <th width="">Harga</th>  
                    </tr>
                    </thead>
                    <tbody>                   
                              <?php
                          $id_unit= $_SESSION['id_units'];
			                 $res=pg_query($dbconn,"Select id, id_lab_analysis, harga from lab_analysis_kategori_harga_unit where id_unit='$id_unit' and id_kategori_harga='$id_kategori_harga' order by id asc");	                                 
			                 while ($row=pg_fetch_assoc($res)) {
			                    $view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis WHERE id='$row[id_lab_analysis]'"));
			                    $invoice_lab=pg_fetch_assoc(pg_query($dbconn,"Select id_detail from transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id_unit='$id_unit' AND jenis='S' AND  id_detail='$row[id_lab_analysis]' AND id = '$id'  "));
			                    

                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox"  value="<?php echo $row['id_lab_analysis']."_".$row["harga"] ?>" name="lab_analysis[]" class="stest" harga="<?php echo $row["harga"]; ?>"
                                          	<?php if($invoice_lab['id_detail'] == $row['id_lab_analysis']) echo "checked"; ?>
                                          />
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $view["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($row["harga"], 0,',','.') ?>" name="harga_lab[]" readonly/>
                                          </td>
                                     
                                         
                        </tr>     

                        <?php
                        }
                        ?>
                        </tbody>                 
                </table>
				</div>
								
				<div class="tab-pane" id="tabkiri2" role="tabpanel">
					<div class="form-group data-lab2">
					<table id="myTable4" class="table">
	                    <thead class="table-info">
	                    <tr>
                    <th width="10px"></th>
                      <th width="">Nama</th>
                      <th width="">Harga</th>                             
                    
                      
                    </tr>
                    </thead>
                    <tbody>
                   
                      <?php

                      $id_unit= $_SESSION['id_units'];
						$res=pg_query($dbconn,"Select id, id_lab_analysis_group, harga_unit from lab_analysis_group_unit WHERE id_unit='$id_unit' and id_kategori_harga='$id_kategori_harga' order by id asc");

					
						while ($row=pg_fetch_assoc($res)) {
							$view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis_group 
									WHERE id='$row[id_lab_analysis_group]'"));

							 $invoice_g=pg_fetch_assoc(pg_query($dbconn,"Select id_detail from transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id_unit='$id_unit' AND jenis='M' AND  id_detail='$row[id_lab_analysis_group]' AND id = '$id' "));
                                       ?>
                                         <tr>
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_lab_analysis_group']."_".$row["harga_unit"] ?>" name="lab_analysis_group[]" class="mtest" harga="<?php echo $row["harga_unit"];?>"
                                          <?php if($invoice_g['id_detail'] == $row['id_lab_analysis_group']) echo "checked";?>/>
                                          </td>
                                          
                                          <td class="text-left" ><?php echo $view["nama"] ?></td>
                                           
                                           <td class="text-right">
                                            <input style="vertical-align:left; margin: 5px" type="text" 
                                          value=" <?php echo number_format($row["harga_unit"], 0,',','.') ?>" name="harga_lab[]" readonly/>
                                          </td>
                                     
                                         
                        </tr>     

                        <?php
                        }
                        ?>
                      </tbody>                 
                </table>
									</div>
				</div>
				<div class="tab-pane" id="tabkiri3" role="tabpanel">
				<div class="form-group ">
				  <table id="myTable5" class="table">
	                <thead class="table-info">
                <tr>
                <th width="10px"></th>
                  <th width="">Nama</th>
                  <th width="">Harga</th>                             
                
                  
                </tr>
                </thead>
                <tbody>
                    <?php
					 $unit = $_SESSION['id_units'];
					 $res=pg_query($dbconn,"Select id, id_tindakan, harga from tindakan_kategori_harga_unit where id_unit='$unit' and id_kategori_harga='$id_kategori_harga' order by id_tindakan asc");

					while ($row=pg_fetch_assoc($res)) {
							$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
							 $invoice_n=pg_fetch_assoc(pg_query($dbconn,"Select id_detail from transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id_unit='$id_unit' AND jenis='N' AND  id_detail='$row[id_tindakan]' AND id = '$id' "));
                                       ?>
                                         <tr>
                                          <td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_tindakan']."_".$row["harga"] ?>" name="tindakan[]" class="nonlab" harga="<?php echo $row["harga"];?>"
                                          	<?php if($invoice_n['id_detail'] == $row['id_tindakan']) echo "checked";?>
                                          />
                                          </td>
                                         
                                          <td class="text-left"><?php echo $data["nama"] ?></td>
                                          
                                          <td>
                                          <input style="vertical-align:left; margin: 5px" type="text" 
                                          value="<?php echo number_format($row["harga"], 0,',','.')  ?>" name="harga_tindakan[]" readonly class="text-right" />
                                          
                                            
                                          </td>
                                     
                                         
                                      </tr>
                                     <?php 
                    } 
                  ?> 
                     </tbody>
                     </table>
						</div>
							</div>
							<div class="tab-pane" id="tabkiri4" role="tabpanel">
							<div class="form-group ">
								<table id="myTable13" class="table table-sm">
									<thead class="table-secondary">
										<tr>
											<th></th>
											<th>Nama</th>
			               					<th>Harga</th>
												
											</tr>
										</thead>
										<tbody>
										<?php
										$unit = $_SESSION['id_units'];
										$res=pg_query($dbconn,"Select distinct id_billing_paket from billing_paket_kategori_harga_unit where id_unit='$unit' and id_kategori_harga='$id_kategori_harga' order by id_billing_paket asc");
										
										while ($row=pg_fetch_assoc($res)) {
											$data=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket where id='".$row["id_billing_paket"]."' "));
			               					 $w=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket_kategori_harga_unit where id_billing_paket='".$row["id_billing_paket"]."' and id_unit='$unit'  and id_kategori_harga='$id_kategori_harga' "));

			               					 $invoice_e=pg_fetch_assoc(pg_query($dbconn,"Select id_detail from transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id_unit='$id_unit' AND jenis='E' AND  id_detail='$row[id_billing_paket]' AND id ='$id'"));

			             		               					

										?>
											<tr>
											<td><input style="vertical-align:left; margin: 5px" type="checkbox" value="<?php echo $row['id_billing_paket']."_".$w["harga"] ?>" name="mcu[]"  harga="<?php echo $w["harga"];?>"
											<?php if($invoice_e['id_detail'] == $row['id_billing_paket']) echo "checked";?>
											/>
											</td>
												<td><?php echo $data["nama_paket"] ?></td>
			                  					<td><?php echo number_format($w["harga"],'0','','.') ?></td>
												
									
										   
											</tr>
										<?php 
										} 
										?> 
										</tbody>
									</table>
									</div>
									</div>
							</div>
						</fieldset>
					</div>				
					<div class="col-md-12">
						<!-- <button type="button" class="btn btn-primary btn-sm" id="btnUpdateLaborder">Simpan</button> -->
						<button type="button" class="btn btn-danger btn-sm" id="btnBatalLaborder">Batal</button>
					</div>
				</div>
			</div>
		</div>
		<script>

			$('#btnUpdateLaborder').click(function(){
       
      		  	var id_kategori_harga=$("#id_kategori_harga").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var keterangan=$("#keterangan").val();
				var id=$("#id").val();

				
              var checkbox_single_test = [];
                  $("input[name='lab_analysis[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox_single_test.push($(this).val());
                    }

                  });

            var checkbox_multiple_test = [];
                  $("input[name='lab_analysis_group[]']").each(function ()
                  {
                       if ($(this).is(':checked')) {
                      checkbox_multiple_test.push($(this).val());
                    }
                  });

              var checkbox_non_lab = [];
                  $("input[name='tindakan[]']").each(function ()
                  {
                       if ($(this).is(':checked')) {
                      checkbox_non_lab.push($(this).val());
                    }
                  });

               var checkbox_mcu = [];
                  $("input[name='mcu[]']").each(function ()
                  {
                       if ($(this).is(':checked')) {
                      checkbox_mcu.push($(this).val());
                    }
                  });

                $.ajax({
                         type:'post',
                         url :"media.php?ajax=UPDATE__ORDER",
                          data:{  
                                            checkbox_single_test:checkbox_single_test,   
                                            checkbox_multiple_test:checkbox_multiple_test,
                                            checkbox_non_lab:checkbox_non_lab,
                                            checkbox_mcu:checkbox_mcu,
                                            id_kategori_harga:id_kategori_harga,
                                            id_pasien:id_pasien,
                                            id_kunjungan:id_kunjungan,
                                            keterangan:keterangan,
                                            id:id
                                  },
                         success: function(data) {     
                         	$("#data_order").load('pasien-order');
                         }                                                           
 
                         });
             
              });

		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});
		
		$(function () {
			$("#id_specimen").change(function(){
				var id_specimen=$(this).val();
				var id_kategori=$("#id_kategori").val();
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				
				var dataString = 'id_specimen='+id_specimen+'&id_kategori='+id_kategori+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
				
				$.ajax({
					type 	: 'POST',
					url 	: 'data-lab',
					data	: dataString,
					success	: function(response){
						$('#data_lab').html(response);
					}
				});
			});
			
			
		});
		
		
		$('.btnTambahPesanAnalysis').click(function(){
			var id_analysis=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_analysis='+id_analysis;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-analysis",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_laborder_kanan").html(data);
				}
			});
		});
		
		
		$('.btnTambahPesanAnalysisGroup').click(function(){
			var id_analysis_group=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_analysis_group='+id_analysis_group;
			$.ajax({
				type: "POST",
				url: "aksi-tambah-pesan-analysis-group",
				data: dataString,
				cache: false,
				success: function(data){
					$("#data_laborder_kanan").html(data);
				}
			});
		});
		
		
		
			
		$('#btnBatalLaborder').click(function()
		{
				
				var rm=$("#rm").val();
				$("#data_order").load('content/pasien/order/pasien_order.php?id='+rm);
		});
		
		
		
		

	
		
		</script>

