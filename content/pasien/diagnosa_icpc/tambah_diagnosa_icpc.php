<?php
	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];		
?>
		<div class="card">
			<div class="card-header">
				<strong>Tambah</strong>
			</div>
			<div class="card-block">
				<div class="row">
				<input type="hidden" id="no_rm" value="<?php echo $_POST['no_rm'];?>">
				<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
				<input type="hidden" name="id_pasien" id="id_kunjungan" value="<?php echo $id_kunjungan;?>">
					
					
					<div class="col-md-7">
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkiri1" role="tab" aria-controls="tabkiri1">List</a>
                                </li>
                            </ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tabkiri1" role="tabpanel">
									<br>
																	
								
										 <table id="lookup" class="table table-bordered table-striped">  
		                                     <thead align="center">
		                                        <tr>
		    
		                                       
		                                      <th>Kode </th>
		                                        <th>Nama </th>
		                                      <th class="text-center"> Action </th> 
		    
		                                       </tr>
		                                      </thead>
		                                        <tbody>
		                                        </tbody>
		                                    </table>
									</div>
								</div>
								
								
							</div>
							
			
					<div class="col-md-5">
						<fieldset>
							<legend>Hasil Diagnosa</legend>
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabkanan1" role="tab" aria-controls="tabkanan1">Data</a>
                                </li>
                                
                            </ul>
							
							<div class="tab-content">
								<div class="tab-pane active" id="tabkanan1" role="tabpanel">
									<br>

								</div>
								
								
							</div>
							</fieldset>
								<div class="form-group row">
									<label class="col-md-2">Catatan</label>
									<div class="col-md-9">
										<input name="catatan" id="catatan"  class="form-control">
														
									</div>
								</div>
						<div class="form-group row">
										<label class="col-md-2">Tipe Diagnosa</label>
										<div class="col-md-8">
											<select name="tipe_diagnosa" id="tipe_diagnosa" class="form-control">
												<option value="Confirmed">Confirmed</option>
												<option value="Differential">Differential</option>
												<option value="Provisional">Provisional</option>
												
											</select>
										</div>
						</div>
						

					</div>
					
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanDiagnosa">Simpan</button>
						<button type="button" class="btn btn-danger btn-sm" id="btnBatalDiagnosa">Batal</button>
					</div>
				</div>
			</div>
		</div>

		<script src="assets/plugins/select2/select2.full.min.js"></script>
		<script>

		$(document).ready(function() {
		 	
		 	
		 	 $("#tabkanan1").load("content/pasien/diagnosa_icpc/detail_diagnosa.php?id_pasien="+<?php echo $id_pasien?>+"&id_kunjungan="+<?php echo $id_kunjungan?>);		 	
            });

		 $(document).ready(function() {
                var dataTable = $('#lookup').DataTable( {
                  "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ "

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"content/pasien/diagnosa_icpc/ajax-grid-data-icpc.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".lookup-error").html("");
                            $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#lookup_processing").css("display","none");
                            
                        }
                    }
                } );
            } );
		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});

		
		$(function () {		
			$("#group_diagnosa").change(function(){
				var id_group=$(this).val();
				//alert(id_group);
				$.ajax({
					type 	: 'POST',
					url 	: 'data-diagnosa',
					data: { 
						'name_group': id_group
					},
					success	: function(response){
						//alert(response);
						$('#data_lab').html(response);
					}
				});
			});
		});


		$('#tabkiri1').on('click', '.btnTambahDiagnosaIcpc', function (){
			
			var id_diagnosa=$(this).attr('id');
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_diagnosa='+id_diagnosa;
		

			$.ajax({
				type: "POST",
				url: "content/pasien/diagnosa_icpc/aksi_diagnosa_icpc.php?act=tambahdiagnosa",
				data: dataString,
				cache: false,
				success: function(data){
					
					$("#tabkanan1").load("content/pasien/diagnosa_icpc/detail_diagnosa.php?id_pasien="+<?php echo $id_pasien?>+"&id_kunjungan="+<?php echo $id_kunjungan?>);
				}
			});

		});

		
		$('#btnSimpanDiagnosa').click(function()
		{
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var catatan = $("#catatan").val();
			var tipe_diagnosa = $("#tipe_diagnosa").val();
			var no_rm = $("#no_rm").val();

			var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&catatan='+catatan+'&tipe_diagnosa'+tipe_diagnosa;

			$.ajax({
				type: "POST",
				url: "content/pasien/diagnosa_icpc/aksi_diagnosa_icpc.php?act=tambah",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnSimpanDiagnosa").val('Submitting...');},
				success: function(data){
				
					$("#data_diagnosa").load("content/pasien/diagnosa_icpc/pasien_diagnosa.php?id="+no_rm);
				}
			});
		});
		
		$('#btnBatalDiagnosa').click(function()
		{
			var no_rm=$("#no_rm").val();
		$("#data_diagnosa").load("content/pasien/diagnosa_icpc/pasien_diagnosa.php?id="+no_rm);

		});
		
		$('#tabkanan1').on('click', '.btnHapusDiagnosaPilih', function (){
			if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
				var id=$(this).attr('id');
				var id_pasien=$("#id_pasien").val();
				var id_kunjungan=$("#id_kunjungan").val();
				var dataString = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
				

				$.ajax({
					type: "POST",
					url: "content/pasien/diagnosa_icpc/aksi_diagnosa_icpc.php?act=deleteicpc",
					data: dataString,
					cache: false,
					success: function(data){
						$("#tabkanan1").load("content/pasien/diagnosa_icpc/detail_diagnosa.php?id_pasien="+<?php echo $id_pasien?>+"&id_kunjungan="+<?php echo $id_kunjungan?>);
					}
				});
			}
			else{
				return false;
			}
		});
		
		</script>