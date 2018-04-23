<?php
switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Analisis Kunjungan</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Analisis Kunjungan 
							<!--a href="media.php?module=analisis_kunjungan&act=jenkel" class="btn btn-primary btn-xs" title="Jenis Kelamin" data-toggle="tooltip" data-placement="top" title="view jenkel">Jenis Kelamin</a-->

						</div>

						<div class="card-block">
							<form method="post" class="form-horizontal" action="">
								<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">										
										<input name='tgl_awal' class='form-control date' value="<?php echo date('d-m-Y'); ?>" required>		
									</div>									
									<label class="col-sm-2 form-control-label" >Sampai Tanggal</label>
									<div class="col-sm-2">
										<input name='tgl_akhir' class='form-control date' required value="<?php echo date('d-m-Y'); ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									<!--a href="edit-antrian-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Jenis Kelamin" data-toggle="tooltip" data-placement="top" title="view jenkel">Grafik</a-->
								</div>
							</form>
						
							<div class="row">
								<div class="col-md-5">
									<table class="table">
										<thead>
											<tr>
												<th width="60px">Hari</th>
												<th width="150px">Jumlah Pasien</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
											
											if(isset($_POST['cari'])){
												$tgl_awal=DateToEng($_POST["tgl_awal"]);												
												$tgl_akhir=DateToEng($_POST["tgl_akhir"]);
												$_SESSION['awal']=	$tgl_awal;
												$_SESSION['akhir']=	$tgl_akhir;

												$tampil=pg_query($dbconn,"SELECT count(waktu_input) as \"jumlah\", waktu_input::date FROM kunjungan   where waktu_input::date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");
												//var_dump("SELECT count(waktu_input) as \"jumlah\", waktu_input:date FROM kunjungan   where waktu_input BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");

											}
											else{
												$tampil=pg_query($dbconn,"SELECT count(waktu_input) as \"jumlah\", waktu_input::date FROM kunjungan GROUP BY waktu_input");
											}

												
												while($r=pg_fetch_array($tampil)){
													$a=$r['jumlah'];
													
													?>
													<tr>
														<td><?php echo $r['waktu_input'];?></td>
														<td><?php echo  $a; ?></td>
														
													</tr>
													<?php
												}
											?>
										</tbody>
									</table>
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
case "jenkel":
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Analisis Kunjungan</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Analisis Kunjungan 
							<a href="media.php?module=analisis_kunjungan" class="btn btn-primary btn-xs" title="Jenis Kelamin" data-toggle="tooltip" data-placement="top" title="view jenkel">Tanggal</a>

						</div>

						<div class="card-block">
							<form method="post" class="form-horizontal" action="">
								<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">										
										<input name='tgl_awal' class='form-control date' value="<?php echo date('d-m-Y'); ?>" required>		
									</div>									
									<label class="col-sm-2 form-control-label" >Sampai Tanggal</label>
									<div class="col-sm-2">
										<input name='tgl_akhir' class='form-control date' required value="<?php echo date('d-m-Y'); ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									<a href="" class="btn btn-primary btn-xs" title="Jenis Kelamin" data-toggle="tooltip" data-placement="top" title="view jenkel">Grafik</a>
								</div>
							</form>
						
							<div class="row">
								<div class="col-md-12">
									<table class="table">
										<thead>
											<tr>
												<th width="60px">Hari</th>
												<th width="150px">Jumlah Pasien</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
											$k=pg_query($dbconn,"SELECT * from master_jenkel");

												while($rk=pg_fetch_array($k)){
													//var_dump($rk['id']);
													
											if(isset($_POST['cari'])){
												$tgl_awal=DateToEng($_POST["tgl_awal"]);
												$tgl_akhir=DateToEng($_POST["tgl_akhir"]);
												$tampil=pg_query($dbconn,"SELECT k.id_pasien from kunjungan k LEFT OUTER JOIN master_pasien l ON l.jenkel='".$rk['id']."'  where k.waktu_input::date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY k.waktu_input");
												//var_dump("SELECT count(k.id_pasien) from kunjungan k LEFT OUTER JOIN master_pasien l ON l.jenkel='".$rk['id']."'  where k.waktu_input::date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY k.waktu_input");
												

											}
											else{
												$tampil=pg_query($dbconn,"SELECT k.id_pasien from kunjungan k LEFT OUTER JOIN master_pasien l ON l.jenkel='".$rk['id']."'  GROUP BY k.waktu_input");
											}
												var_dump("SELECT k.id_pasien from kunjungan k LEFT OUTER JOIN master_jenkel l ON l.id='".$rk['id']."'  GROUP BY k.waktu_input");
												
												$r=pg_num_rows($tampil);
												var_dump($r);
													//$a=$r['jumlah'];
													
													?>
													<tr>
														<td><?php echo $rk['nama'];?></td>
														<td><?php echo  $r; ?></td>
														
													</tr>
													<?php
												
											}
											?>
										</tbody>
									</table>
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

}
?>



	<script>
		$('#btnbatalviewLab').click(function()
		{
			document.location.href = "lab-hasil";

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

                   if(isset($_POST['cari'])){
					$tgl_awal=DateToEng($_POST["tgl_awal"]);
					$tgl_akhir=DateToEng($_POST["tgl_akhir"]);
					$tampil=pg_query($dbconn,"SELECT  waktu_input::date FROM kunjungan   where waktu_input::date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");
					//var_dump("SELECT count(waktu_input) as \"jumlah\", waktu_input:date FROM kunjungan   where waktu_input BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");
					}
					else{
						$tampil=pg_query($dbconn,"SELECT  waktu_input::date FROM kunjungan GROUP BY waktu_input");
						}
                    $row_cnt = pg_num_rows($tampil);
                    $i=1;
                    while($dataSelect=pg_fetch_array($tampil))
                    {
                        if($row_cnt==$i){
                            echo "'".$dataSelect['waktu_input']."'";
                        }else {
                        echo "'".$dataSelect['waktu_input']."'".",";
                        }
                        $i++;
                    }
                    ?>],
    	            datasets: [
    	            {
    	              label: "Analisis Kunjungan",
    	              data: [<?php

    	             if(isset($_POST['cari'])){
					$tgl_awal=DateToEng($_POST["tgl_awal"]);
					$tgl_akhir=DateToEng($_POST["tgl_akhir"]);
					$tampil=pg_query($dbconn,"SELECT  count(waktu_input) as \"jumlah\" FROM kunjungan   where waktu_input::date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");
					//var_dump("SELECT count(waktu_input) as \"jumlah\", waktu_input:date FROM kunjungan   where waktu_input BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY waktu_input");
					}
					else{
						$tampil=pg_query($dbconn,"SELECT  count(waktu_input) as \"jumlah\" FROM kunjungan GROUP BY waktu_input");
						}
                    $row_cnt = pg_num_rows($tampil);
                    $i=1;

    	            while($r=pg_fetch_array($tampil))
    	            {										
						    
	                    $i=1;
	                    
	                        if($row_cnt==$i){
	                            echo "'". $r['jumlah']."'";
	                        }else {
	                        echo "'". $r['jumlah']."'".",";
	                        }
	                        $i++;
	                   

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
    	            type: 'line',
    	            data: data,
    	            options: {
                    responsive: true
    	          }
    	        });
		
	</script>