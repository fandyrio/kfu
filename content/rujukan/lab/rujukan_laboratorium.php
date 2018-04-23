<?php

switch($_GET['act']){
	
default:

if(isset($_POST['tanggal_awal'])){
	$tanggal_awal=$_POST['tanggal_awal'];
	$tanggal_akhir=$_POST['tanggal_akhir'];
}
else{
	$tanggal_awal="01-$bln_sekarang-$thn_sekarang";
	$tanggal_akhir="$tgl_skrg-$bln_sekarang-$thn_sekarang";
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Rujukan Laboratorium</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Rujukan Laboratorium
							<span class="pull-right">
								<a href="tambah-rujukan-laboratorium" class="btn btn-primary btn-xs">Tambah</a>
							</span>
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
							<div class="form-group row">
                        	<label class="col-md-1">Cabang</label>
                         <div class="col-md-6">
                            <?php 
                          
                             $result =pg_query($dbconn, "SELECT id, nama FROM master_unit");
                         
                          ?>
                          <select name='id_unit' id="id_unit" class='form-control' required>
                          
                          <option value=''>Pilih Perusahaan</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                          	 if(isset($_POST['cari'])){
                          	 	if($_POST['id_unit']==$row['id']){
								echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                          	 	}
                          	 	else{
                            		echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                            	}
                        	}
                        	else{
                        		echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                        	}
                          }
                          ?>
                          </select>
                          </div>
                    </div>
								<div class="form-group row">
									<label class="col-md-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">
									<input type="text" class="form-control" id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>">
									</div>
									
									<label class="col-md-2 form-control-label">Sampai Tanggal</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								</div>
							</form>

							<table class="table" id="myTable">
								<thead>
									
										<th>Kode</th>
										<th>Cabang</th>
										<th>Cabang Rujukan</th>
										<th>Tanggal</th>
										<th>Status</th>	
										<th>Catatan</th>										
										<th width="120px">#</th>
									
								</thead>
								<tbody>
									 <?php
									 $que="Select pr.id, pr.tanggal,pr.id_cabang_rujuk, pr.id_cabang_dirujuk, pr.catatan, pr.status_diterima from pasien_rujukan pr";
									
									 if($_SESSION[id_units]!=1){
									 	$que.=" where pr.id_cabang_rujuk='$_SESSION[id_units]' AND ";
									 }else{
									 	$que.=" where  ";
									 }

									 if(isset($_POST[cari])){
									 	$que.="  pr.id_cabang_dirujuk='$_POST[id_unit]' AND ";
									 }

									 $que.="  pr.tanggal BETWEEN '$tanggal_awal2' AND '$tanggal_akhir2' order by pr.id";
									 //var_dump($que);
									
									
					                 $res=pg_query($dbconn,$que);
					                 while ($row=pg_fetch_assoc($res)) {
					                 	$q="Select nama, kode from master_unit where id='$row[id_cabang_dirujuk]'";
					                 $hasil=pg_fetch_array(pg_query($dbconn,$q));
					                 $qry="Select nama, kode from master_unit where id='$row[id_cabang_rujuk]'";
					                 $hasil_q=pg_fetch_array(pg_query($dbconn,$qry));
					                     ?>
					                       <tr>
					                       <td style="vertical-align:middle;"><?php echo $hasil["kode"] ?></td>
					                        <td style="vertical-align:middle;"><?php echo $hasil_q["nama"] ?></td>
					                         <td style="vertical-align:middle;"><?php echo $hasil["nama"] ?></td>
					                         <td style="vertical-align:middle;"><?php echo DateToIndo2($row["tanggal"]); ?></td> <td>
                        					<?php
                        					$disabled="";
	                        					if($row['status_diterima']==2){
	                        						$disabled="disabled";
												echo $status="<button class='btn btn-xs btn-success' title='diterima'>
																diterima</button>";
											
											}elseif($row['status_diterima']==3){
												echo $status="<button class='btn btn-xs btn-danger' title='ditolak'>
													 ditolak</button>";
													

											}
											else{
												echo $status="<button class='btn btn-xs btn-warning' title='belum proses'>proses</button>";
											}?>
                        					</td>
                        					<td><?php echo $row["catatan"] ?></td>
                        					
					                         <td class="text-center" style="vertical-align:middle;">
				                       <a href="update-rujukan-laboratorium-<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat <?php echo $disabled; ?>" title="edit"  ><i class="fa fa-edit"></i></a>
				                            <a href="content/rujukan/lab/print.php?id=<?php echo $row[id];?>" target="_blank" class="btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
				                            <a href="content/rujukan/lab/hapus.php?id=<?php echo $row[id];?>" class="btn btn-danger btn-xs <?php echo $disabled; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
                        					</td>          
					                        </tr>              
					                 <?php }
					                  ?>
								</tbody>
							</table>
							<!--<h6>TOTAL : <b><?php echo $total; ?></b></h6>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;

case "tambah":
 include "tambah.php";
break;

case "update":
	include "update.php";
break;

case "simpan":
 include "simpan.php";
break;

case "hapus_detail_rujukan":
 include "hapus_child.php";
break;


}
?>