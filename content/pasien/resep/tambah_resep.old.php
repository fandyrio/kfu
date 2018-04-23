<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";



if(isset($_SESSION["id_pasien"])){
	$id_pasien=$_SESSION["id_pasien"];
	$id_kunjungan=$_SESSION["id_kunjungan"];
	$id_kategori_harga=$_SESSION["id_kategori_harga"];
	
}else{
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	$id_kategori_harga=$_POST["id_kategori_harga"];
}


?>
<input type="hidden" id="id_pasien" value="<?php echo $id_pasien;?>">
<input type="hidden" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
<input type="hidden" id="id_kategori_harga" value="<?php echo $id_kategori_harga;?>">
		<div class="card">
			<div class="card-header">
				<strong>Tambah Barang Habis Pakai</strong>
			</div>
			<div class="card-block">
				<div class="row">
				
					
					<div class="col-md-5">
						<fieldset>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Cashier </label>
								<div class="col-md-8">
									<select name="id_unit_lab" id="id_unit_lab" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_unit_lab");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Departemen </label>
								<div class="col-md-8">
									<select name="id_departemen" id="id_departemen" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM inv_departemen");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Kategori Layanan </label>
								<div class="col-md-8">
									<select name="id_layanan" id="id_layanan" class="form-control" disabled>
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga");
										while($r=pg_fetch_array($tampil)){
											if($id_layanan=$r[id]){
												echo"<option value='$r[id]' selected>$r[nama]</option>";}
											else echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group ">
										<table class="table">
						<thead>
							<tr>
								<th width="40px">No</th>
								<!-- <th width="60px">Tanggal</th> -->
								<th >Jenis Pemeriksaan</th>
								<th >Detail</th>	
								<th >Komposisi</th>																						
								
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_order WHERE id_pasien='$id_pasien' AND  id_unit='$_SESSION[id_units]' AND id_kunjungan='$id_kunjungan' ORDER BY id DESC");
								$b=pg_fetch_array(pg_query($dbconn,"SELECT m.nama FROM antrian n
												INNER join segmen m on m.id = n.id_segmen 
												WHERE n.id_pasien='$id_pasien' and n.id_unit = '$_SESSION[id_units]' "));
										$kategori="$b[nama]";
								$no=1;
								$bahan['S_Inv']=array();
								$bahan['S_Jumlah']=array();
								$bahan['M']=array();
								$bahan['E']=array();
								
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$transaksi=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_aktif='Y' AND status_hapus='N'  AND id_pasien_order='$r[id]'  ORDER BY id ASC");

								
									?>
									<!-- <tr>
										<td><?php echo $no++;?></td>
										<td colspan="5"><?php echo $tanggal_input;?></td>
										
									</tr> -->
									<?php 
									$j=0;
									while($row=pg_fetch_array($transaksi)){
										$harga = number_format($row['harga'],0,',','.');
										
										 
         							 

									?>
									<tr>
								<!-- 	<td></td> -->
									<td></td>
										
										
										<?php if($row['jenis']=='E'){
											
											$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$row[id_detail]' order by d.id_detail ");

											echo '<td>';
												echo $jenis="MCU";
											echo '</td>';

											echo '<td>';
											$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$row[id_detail]' "));
											$nama_transaksi=$h[nama_paket];
											echo $nama_transaksi;
											echo '<ul style="margin:0 auto">';
											while($row=pg_fetch_assoc($a)){
												?>

											<?php	
												
											if($row['jenis']=='L'){
												$l=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
												 echo '<li>'.$l[nama].'</li>';


											$query="SELECT id_inv, jumlah FROM lab_analysis_reagensia WHERE id_lab_analysis='$row[id_detail]'";
											$find_bahan=pg_query($dbconn,$query);
											while($index_bahan=pg_fetch_array($find_bahan)){
												$nama_inv=pg_fetch_array(pg_query($dbconn,"select  n.nama from inv_inventori i inner join inv_nama_brand n on n.id=i.id_brand
														WHERE i.id='$index_bahan[id_inv]'") );	
												  echo '<td>'.$nama_inv['nama'].'<td>';
													 $lab_komposisi["id_inv"] = $index_bahan['id_inv'];
													 $lab_komposisi["jumlah"] = $index_bahan['jumlah'];
													  array_push( $bahan['S_Inv'], $lab_komposisi['id_inv']);
											 array_push( $bahan['S_Jumlah'], $lab_komposisi['jumlah']);	
											}
											
												 									
												
											}
											elseif($row['jenis']=='LG'){
												$lg=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
												 echo '<li>'.$lg[nama].'</li>';
												 $details=pg_query($dbconn,"SELECT id_lab_analysis FROM lab_analysis_group_detail WHERE id_lab_analysis_group='$lg[id]'");
													while($index_details=pg_fetch_array($details)){	

													$query="SELECT id_inv, jumlah FROM lab_analysis_reagensia WHERE id_lab_analysis='$index_details[id_lab_analysis]'";
													// var_dump($query);
													$find_bahan=pg_query($dbconn,$query);
													while($index_bahan=pg_fetch_array($find_bahan)){
															 $lab_komposisi["id_inv"] = $index_bahan['id_inv'];
															 $lab_komposisi["jumlah"] = $index_bahan['jumlah'];
															 array_push( $bahan['S_Inv'], $lab_komposisi['id_inv']);
													 array_push( $bahan['S_Jumlah'], $lab_komposisi['jumlah']);

													}

												}
												
											}
											
																							
											}
											echo '</ul>';
											echo '</td>';
											
										}
										
										if($row['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));



											$query="SELECT id_inv, jumlah FROM lab_analysis_reagensia WHERE id_lab_analysis='$row[id_detail]'";
											// var_dump($query);
											$find_bahan=pg_query($dbconn,$query);
											while($index_bahan=pg_fetch_array($find_bahan)){
													 $lab_komposisi["id_inv"] = $index_bahan['id_inv'];
													 $lab_komposisi["jumlah"] = $index_bahan['jumlah'];
													 array_push( $bahan['S_Inv'], $lab_komposisi['id_inv']);
											 		array_push( $bahan['S_Jumlah'], $lab_komposisi['jumlah']);

											}
											
											 
										
											echo '<td>';
												echo $jenis="ST";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';	
											
										}
										elseif($row['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));

											$details=pg_query($dbconn,"SELECT id_lab_analysis FROM lab_analysis_group_detail WHERE id_lab_analysis_group='$a[id]'");
											while($index_details=pg_fetch_array($details)){	

											$query="SELECT id_inv, jumlah FROM lab_analysis_reagensia WHERE id_lab_analysis='$index_details[id_lab_analysis]'";
											// var_dump($query);
											$find_bahan=pg_query($dbconn,$query);
											while($index_bahan=pg_fetch_array($find_bahan)){
													 $lab_komposisi["id_inv"] = $index_bahan['id_inv'];
													 $lab_komposisi["jumlah"] = $index_bahan['jumlah'];
													 array_push( $bahan['S_Inv'], $lab_komposisi['id_inv']);
											 array_push( $bahan['S_Jumlah'], $lab_komposisi['jumlah']);

											}

										}
											echo '<td>';
												echo $jenis="MT";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										
										//$harga=formatRupiah3();
										?>
										
																	
										</tr>
										
									<?php
									$j++;
								}?>
									
									
							<?php 
							}
							?>
						</tbody>
					</table>
									</div>
							
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">Barang Habis Pakai</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkanan" role="tab" aria-controls="tabkanan">Dokter</a>
                                </li>
                            </ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tabkiri1" role="tabpanel">
									<br>
							
									<div class="form-group data-lab" id="data_lab">
										<table id="example2" class="table">
											<thead>
												<th>Nama</th>
												<th>Jumlah</th>
												<th width="50px">#</th>
											</thead>
											<tbody>
												<?php
												$arrlength = count($bahan['S_Inv']);
												for($x = 0; $x < $arrlength; $x++) {
													$id_inv = $bahan['S_Inv'][$x];
												   
													$nama_inv=pg_fetch_array(pg_query($dbconn,"select  n.nama from inv_inventori i inner join inv_nama_brand n on n.id=i.id_brand
														WHERE i.id='$id_inv'") );												
													?>
													<tr>
														<td><?php  echo $nama_inv['nama'];?></td>
														<td><?php  echo $bahan['S_Jumlah'][$x];?></td>
														<td>
															<button class="btn btn-default btn-xs btnTambahPesanAnalysis" id="<?php echo $id_inv;?>"><i class="icon-plus"></i></button>
														</td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
										<br>
							<div class="tab-pane" id="tabkanan" role="tabpanel">
							
									<div class="form-group" >
										<label class="col-md-4 form-control-label">Nama Dokter </label>
										<div class="col-md-12">
											<input name="dokter" id="dokter" class="form-control">
												
										</div>
										
									</div>
								</div>
								
					
							</div>
							
						</fieldset>
					</div>
					
					<div class="col-md-7">
					<fieldset>
					<div class="col-md-12 list_resep" style="overflow-y:scroll;">
						<table id="example2" class="table resep_loader ">
							<thead>
								<th>Nama</th>
								<th style="text-align: right;">Charges</th>
								<th></th>
							</thead>
								<tbody>
								<?php
								$tampil=pg_query($dbconn,"select i.* from pasien_resep i where i.id_pasien='".$id_pasien."' AND i.id_kunjungan='".$id_kunjungan."' AND i.status_proses='N' ");
								
								while($r=pg_fetch_array($tampil)){
													?>
									<tr id="<?php echo $r['id'];?>">
										<td><?php echo $r['nama_brand'];?></td>
										<td style="text-align: right;"><?php echo $r['total_cost']; ?></td>	
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
					</fieldset>
						<fieldset>
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkanan1" role="tab" aria-controls="tabkanan1">Detail</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabkanan2" role="tab" aria-controls="tabkanan2">Batch</a>
                                </li>
                            </ul>
							
							<div class="tab-content">
								<div class="tab-pane active" id="tabkanan1" role="tabpanel">
									<br>
									BELUM ADA RESEP TERPILIH
									
								</div>
								
								<div class="tab-pane" id="tabkanan2" role="tabpanel">
									ada
								</div>
							</div>
						</fieldset>
					</div>
					
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanResep">Simpan</button>
						<!-- <a href=""><button type="button" class="btn btn-danger btn-sm">Batal</button></a> -->
					</div>
				</div>
			</div>
		</div>


			<div id="mit_pop_up" class="melayang" >
            <div class="melayang-content">
              <span class="close">&times;</span>
               <div class="form-horizontal" >
                <div class="card-block">
              <div class="row resultload"> 
              	
                </div>          
            </div>
            </div>
            <div class="modal-footer">  
              <button type="button" class="btn btn-sm btn-warning" id="save_batch_resep_x" >Simpan</button>
              </div>
              </div>
            </div>
		
		 <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">

         <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable_code.js"></script>
		<script type="text/javascript">	
		

		$('#btnSimpanResep').click(function(){
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dokter=$("#dokter").val();
			var data= 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&dokter='+dokter+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
			
			$.ajax({
				type: "POST",
				url: "aksi-pasien-resep",
				data: data,
				success: function(data){
					
					$("#data_pasien").load("resep-pasien");
				}
			});
			
		});
			
		$('.btnTambahPesanAnalysis').click(function(){
			var id=this.id;
			var id_departemen= $("#id_departemen").val();
			var id_layanan= $("#id_layanan").val();
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var data= 'id_inv='+id+'&id_departemen='+id_departemen+'&id_layanan='+id_layanan+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
	
			$.ajax({
				type: "POST",
				url: "aksi-tambah-resep",
				data: data,
				success: function(data){
					$("#data_pasien").load("form-tambah-pasien-resep");
				}
			});
			
		});

		$('body').on('click', '.btnHapusItemResep', function (){
			var id=this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
					

			$.ajax({
				type: "POST",
				url: "aksi-hapus-pasien-resep",
				data: dataString2,
				success: function(data){
					
					$("#data_pasien").load("form-tambah-pasien-resep");
				}
			});
			
		});

		//load batch 
		$('body').on('click', '.resep_loader tr', function (){
                var id= $(this).attr('id'); 

                           
                if(id){
                   
                     $.ajax({
                      url: 'content/pasien/resep/detail_resep.php',
                      type: 'POST',
                      data: {id:id},
                      success: function (data) {
                          $('#tabkanan1').html(data);
                          $('#tabkanan2').load("content/pasien/resep/detail_batch.php?id="+id);
                      }
                    
                      });
                  }

            });
		$('body').on('click', '#btnUpdateResep', function (){
               var data = $("#form_resep").serialize(); 
              // alert(data);
                           
              
                   
                     $.ajax({
                      url: 'content/pasien/resep/update_resep.php',
                      type: 'POST',
                      data: data,
                      success: function (data) {
                      	//alert(data);
                          $("#data_pasien").load("form-tambah-pasien-resep");
                      }
                    
                      });
                  

            });
		$('body').on('change', '[name=jumlah_perhari]', function (){ 
		    var h =  $(this).val(); 
		    var n =  $('[name=number_of_day]').val();
		    var q =  $('[name=qty]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+n+"x"+h);     
            
			
            });
		$('body').on('change', '[name=number_of_day]', function (){ 
		    var n =  $(this).val(); 
		    var h =  $('[name=jumlah_perhari]').val();
		    var q =  $('[name=qty]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+n+"x"+h);	      
            
			
            });
		$('body').on('change', '[name=qty]', function (){ 
		    var q =  $(this).val(); 
		    var n =  $('[name=number_of_day]').val();
		    var j =  $('[name=jumlah_perhari]').val();   
		    if(!h){h=0;}  if(!n){n=0;}  if(!q){q=0;}

		    $('#dosis').val(q+"x"+n+"x"+h);     
            
			
            });

		$('body').on('change', '#qty_load', function (){
               
               	//var id = $('#id_resep').val();
               	var name_brand = $('#nama_brand').val();
               	var nama= name_brand.split(' ').join('_');
               	var departemen = $('#id_departemen_resep').val();
               	var jenis_layanan = $('#id_layanan').val();
               	
               	$('#mit_pop_up').css("display", "block");               
             
             $(".resultload").load("content/pasien/resep/load_resep_batch.php?brand="+nama+"&dept="+departemen+"&jenis_layanan="+jenis_layanan);  
            // $(".resultload").load("content/pasien/resep/load_resep_batch.php");   
                           
              
                   /*
                     $.ajax({
                      url: 'content/pasien/resep/detail_resep.php',
                      type: 'POST',
                      data: {id:id},
                      success: function (data) {
                          $('#tabkanan1').html(data);
                      }
                    
                      });*/
                  

            });
		$('body').on('click', '.close', function (){        
        	$('#mit_pop_up').css("display", "none");  
      
      	});
      	/*hitung total cost*/
         $('body').on('change', '.clickable', function (){ 
              var trid = $(this).closest('tr').attr('id_batch');

               var nilai = $.trim(trid).split("_"); // table row ID 
               var tara = $(this).val();

              // alert("woi");
               

               if(parseInt(tara) > parseInt(nilai[0])){
                  alert("angka melebihi stok");
                  $(this).val("0");
                  $(this).next('input').val("0");
                  return false;
               }
               var total = parseInt(tara) * parseInt(nilai[1]);
               $(this).next('input').val(total);

               //alert(trid); 
              // alert(total);                     
            });


          /*disable checkbox harga inventori*/
            $('body').on('click', '#ceklis', function (){ 

                          
             var next = $(this).closest('tr').find('td input');
             if($(this).is(':checked')){
               next.attr('disabled', false);
               $(this).attr('disabled', false);
           } else {
               next.attr('disabled', true);
               $(this).attr('disabled', false);
           }
               
            });

           /*save ln batch trf*/
       
       $('#save_batch_resep_x').click(function(){
    
      	
         var id = $("[name='id']").val();
         var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();

              var checkbox1 = [];
                  $("input[name='checkbox_x[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }

                  });
                 // alert("woi");
          
              var total = [];
                  $("input[name='total_cost_x[]']").each(function ()
                  {
                      total.push($(this).val());
                  });

              var taken1 = [];
                  $("input[name='taken_x[]']").each(function ()
                  {
                     if(!$(this).attr("disabled")){
	                      	taken1.push($(this).val());
	                  		}
                  });
                 
                  
                                              
                             $.ajax({
                                           type:'post',
                                           url :"content/pasien/resep/save_load_resep_batch.php",
                                           data:{  
                                            check:checkbox1,   
                                            total:total,
                                            taken2:taken1,
                                            id:id
                                          },
                                           success: function(data) {
                                             $('#mit_pop_up').css("display", "none");
                                             $('#qty_load').attr('disabled', true);
                                             $('.resep_loader').load("content/pasien/resep/detail_item_obat.php?id_pasien="+id_pasien+"&id_kunjungan="+id_kunjungan);

                                      
                                              //$('#tabkanan1').load("content/pasien/resep/detail_resep.php?id="+id);      

                                           
                                              $.ajax({
	                                           type:'post',
	                                           url :"content/pasien/resep/detail_resep.php",
	                                           data:{ 	                                            
	                                            id:id
	                                          },
	                                           success: function(data) {                               
	                                             $('#tabkanan1').load(data);                          					 
	                            
	                                           },
	                                           error:function(exception){alert('Exeption:'+exception);}
	                                           });
	                          					 
                            
                                           },
                                           error:function(exception){alert('Exeption:'+exception);}
                                           });

             
              });

      	function tandaPemisahTitik(b){
		  var _minus = false;
		  if (b<0) _minus = true;
		  b = b.toString();
		  b=b.replace(".","");
		  
		  c = "";
		  panjang = b.length;
		  j = 0;
		  for (i = panjang; i > 0; i--){
		     j = j + 1;
		     if (((j % 3) == 1) && (j != 1)){
		       c = b.substr(i-1,1) + "." + c;
		     } else {
		       c = b.substr(i-1,1) + c;
		     }
		  }
		  if (_minus) c = "-" + c ;
		  return c;
		}
		function numbersonly(ini, e){
  if (e.keyCode>=49){
    if(e.keyCode<=57){
    a = ini.value.toString().replace(".","");
    b = a.replace(/[^\d]/g,"");
    b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
    ini.value = tandaPemisahTitik(b);
    return false;
    }
    else if(e.keyCode<=105){
      if(e.keyCode>=96){
        //e.keycode = e.keycode - 47;
        a = ini.value.toString().replace(".","");
        b = a.replace(/[^\d]/g,"");
        b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
        ini.value = tandaPemisahTitik(b);
        //alert(e.keycode);
        return false;
        }
      else {return false;}
    }
    else {
      return false; }
  }else if (e.keyCode==48){
    a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
    b = a.replace(/[^\d]/g,"");
    if (parseFloat(b)!=0){
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  }else if (e.keyCode==95){
    a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
    b = a.replace(/[^\d]/g,"");
    if (parseFloat(b)!=0){
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  }else if (e.keyCode==8 || e.keycode==46){
    a = ini.value.replace(".","");
    b = a.replace(/[^\d]/g,"");
    b = b.substr(0,b.length -1);
    if (tandaPemisahTitik(b)!=""){
      ini.value = tandaPemisahTitik(b);
    } else {
      ini.value = "";
    }
    
    return false;
  } else if (e.keyCode==9){
    return true;
  } else if (e.keyCode==17){
    return true;
  } else {
    //alert (e.keyCode);
    return false;
  }

}

		</script>
		
	