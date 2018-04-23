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
				<strong>Tambah Resep</strong>
			</div>
			<div class="card-block">
				<div class="row">
				
					
					<div class="col-md-5">
						<fieldset>
							<div class="form-group row" style="display:none;">
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
							<div class="form-group row" style="display:none;">
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
									<select name="id_layanan" id="id_layanan" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga where id='$_SESSION[id_units]'");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							
							
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">Obat</a>
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
												<th>Kode</th>
												<th>Nama</th>
												<th width="50px">#</th>
											</thead>
											<tbody>
												<?php
												$tampil=pg_query($dbconn,"select i.*, n.nama from inv_inventori i inner join inv_nama_brand n on n.id=i.id_brand
													inner join inv_kategori_harga harga on harga.id_brand = n.id
													WHERE harga.id_layanan='$id_kategori_harga' ");
												
												
												while($r=pg_fetch_array($tampil)){
													?>
													<tr>
														<td><?php echo $r['code'];?></td>
														<td><?php echo $r['nama'];?></td>
														<td>
															<button class="btn btn-default btn-xs btnTambahPesanAnalysis" id="<?php echo $r['id'];?>"><i class="icon-plus"></i></button>
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
					<button type="button" class="btn btn-info btn-xs btnLoadResep">Load</button>
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
                                    <!--<a class="nav-link" data-toggle="tab" href="#tabkanan2" role="tab" aria-controls="tabkanan2">Batch</a>-->
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
			
		$(".btnLoadResep").click(function(){
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'load-resep',
			data: {id_pasien:id_pasien, id_kunjungan:id_kunjungan},
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
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
		    var h =  $('[name=jumlah_perhari]').val();   
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
		
	