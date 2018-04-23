<?php
session_start();
if(!isset($_POST['cari']) ){
	$_SESSION['tgl_awal']=date('Y-m-d');
	$_SESSION['tgl_akhir']=date('Y-m-d');
}else{
	$_SESSION['tgl_awal']  =$_POST["tgl_awal"];
	$_SESSION['tgl_akhir'] =$_POST["tgl_akhir"];

}
switch($_GET['act']){
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Analisis Pasien</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Analisis Pasien
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">										
										<input name='tgl_awal' class='form-control datedatabase' value="<?php echo $_SESSION['tgl_awal'] ; ?>" required>		
									</div>									
									S/d
									<div class="col-sm-2">
										<input name='tgl_akhir' class='form-control datedatabase' required value="<?php echo $_SESSION['tgl_akhir'];  ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									<button type="reset" class="btn btn-sm btn-danger" id="analisis_pasien"><i class="fa fa-ban"></i> Reset</button></div>
								</div>
							</form>
						
							<div class="row">
								<div class="col-md-3">
									<div class="card-block">
									<table class="table">
										<thead>
											<tr>
												<th >Jenis Kelamin</th>
												<th >Jumlah Pasien</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
											
												$tampil=pg_query($dbconn,"SELECT * from master_jenkel");																							
											while($r=pg_fetch_array($tampil)){

												if(isset($_POST['cari'])){
													$tgl_awal=$_POST["tgl_awal"];
													$tgl_akhir=$_POST["tgl_akhir"];								
													$k=pg_num_rows(pg_query($dbconn,"SELECT * from master_pasien where jenkel='".$r["id"]."' and tanggal_edit::date >='$tgl_awal'  and tanggal_edit::date <='$tgl_akhir'"));								
													}

													else{
														$k=pg_num_rows(pg_query($dbconn,"SELECT * from master_pasien where jenkel='".$r["id"]."'"));

													}?>

														<tr>
															<td><?php echo $r['nama'];?></td>
															<td><?php echo $k  ?></td>										
														</tr>
														<?php
												}
											?>
										</tbody>
									</table>
									</div>									
									</div>
									<div class="col-md-7">
									<div class="canvasChart">
									 <canvas id="demobar" ></canvas>
									 </div>
									 </div>

							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;
case "hapus":
	$p=pg_query($dbconn,"Update pasien_hasillab set status_hapus='Y' WHERE id='$_GET[id]'");

?>
<script>
			document.location.href = "lab-hasil";
				
			</script>


<?php

break;
?>
<?php
}
?>



	<script>
		$('#analisis_pasien').click(function()
		{
			document.location.href = "analisis-pasien";

		});
		</script>
		<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		
		$(document).ready(function(){
			$(".datedatabase").mask("9999/99/99",{placeholder:"yyyy-mm-dd"});
			
			 $('.js-example-basic-single').select2();
		});


		  var ctx = document.getElementById("demobar").getContext("2d");
    	  var data = {
    	            labels: [<?php
                    $sql= pg_query($dbconn,"SELECT * from master_jenkel ");
                    $row_cnt = pg_num_rows($sql);
                    $i=1;
                    while($dataSelect=pg_fetch_array($sql))
                    {
                        if($row_cnt==$i){
                            echo "'".$dataSelect['nama']."'";
                        }else {
                        echo "'".$dataSelect['nama']."'".",";
                        }
                        $i++;
                    }
                    ?>],
    	            datasets: [
    	            {
    	              label: "Analisis Pasien",
    	              data: [<?php

    	            $tampil= pg_query($dbconn,"SELECT * from master_jenkel ");

    	            while($r=pg_fetch_array($tampil))
    	            {	
    	            	if(isset($_POST['cari'])){
							$tgl_awal=$_POST["tgl_awal"];
							$tgl_akhir=$_POST["tgl_akhir"];
							$sql=pg_query($dbconn,"SELECT * from master_pasien where jenkel='".$r["id"]."' and tanggal_edit::date >='$tgl_awal'  and tanggal_edit::date <='$tgl_akhir'");
													
							}

							else{
							$sql=pg_query($dbconn,"SELECT * from master_pasien where jenkel='".$r["id"]."'");				
							
								}
							//$sql=pg_query($dbconn,"SELECT * from master_pasien where jenkel='".$r["id"]."'");										
		                    $row_cnt = pg_num_rows($sql);       
		                    $i=1;
		                    while($dataSelect=pg_fetch_assoc($sql)){
		                        if($row_cnt==$i){
		                            echo "'". $row_cnt."'";
		                        }else {
		                        echo "'". $row_cnt."'".",";
		                        }
		                        $i++;
		                    }

                	}
                    ?>],
                    backgroundColor: [
                      "rgba(59, 100, 222, 1)",
                      "rgba(203, 222, 225, 0.9)",
                      "rgba(102, 50, 179, 1)",
                      "rgba(201, 29, 29, 1)",
                      "rgba(81, 230, 153, 1)",
                      "rgba(246, 34, 19, 1)"]
    	            }
    	            ]
    	            };

    	  var myBarChart = new Chart(ctx, {
    	            type: 'pie',
    	            data: data,
    	            options: {
                    responsive: true
    	          }
    	        });
		
	</script>