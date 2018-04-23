<?php
pg_query($dbconn,"UPDATE billing_paket_penawaran_log SET dilihat='Y' WHERE id_users='$_SESSION[login_user]' AND id_billing_paket='$_GET[id]'");
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="mcu-perusahaan">Event/MCU</a></li>
	<li class="breadcrumb-item active">Detail</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			
			
			<div class="col-md-7">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data Event MCU
					</div>
					<div class="card-block">
					  <?php
				        $q= "Select status, nama_paket,  harga_net, harga_gross, disc_amount, disc_persen, created_unit, id_perusahaan from billing_paket where id='$_GET[id]' ";
				       // var_dump($q);
				         $res=pg_query($dbconn,$q);
				         $r=pg_fetch_array($res);
				         $status= $r['status'];

				         $result =pg_fetch_array(pg_query($dbconn, "SELECT nama FROM master_kategori_harga  where id= '$r[id_perusahaan]' "));
				          ?>
					<table class="table">
							<tr><td width="150px">Nama</td><td width="10px">:</td><td><?php echo $r['nama_paket'];?></td></tr>
							<tr><td>Perusahaan</td><td>:</td><td><?php echo $result['nama'];?></td></tr>
							<tr><td>Keterangan/Catatan</td><td>:</td><td><?php echo $result['keterangan'];?></td></tr>
							<tr><td>Harga</td><td>:</td><td><?php echo formatRupiah($r['harga_gross']);?></td></tr>
							<tr><td>Diskon</td><td>:</td><td><?php if($r['disc_persen']!=0){ echo "$r[disc_persen] %";} else echo formatRupiah($r['disc_amount']);?></td></tr>
							<tr><td>Harga Net</td><td>:</td><td><b><?php echo formatRupiah($r['harga_net']);?></b></td></tr>
							
							
					</table>
				<table id="myTable" class="table ">
	                <thead>
	                <tr>
		                <th width="10px">No.</th>
		                <th width="">Nama Pemeriksaan</th>
		                <th width="">Harga</th>
	                  
	                </tr>
	                </thead>
                <tbody>
            	 <?php
             	$id_users =$_SESSION['login_user'];
           
                  $q= "Select * from billing_paket_detail  
                       where id_billing_paket= '$_GET[id]' ORDER BY id ASC";
                              
            
            
                 $res=pg_query($dbconn,$q);
                 $no=1;
                 $total_harga=0;

                 while ($row=pg_fetch_assoc($res)) {
                    $total_harga+=$row["harga"];

                     ?>
                       <tr>     
                       <td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td> 


                        <?php
                          if($row['jenis']=='L'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Single  ".$nama_transaksi="$a[nama]";
                        echo '</td>'; 
                      
                      } 
                       else if($row['jenis']=='G'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Multi ".$a['nama'];
                        echo '</td>'; 
                      
                      } else if($row['jenis']=='T'){
                        $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
                        
                        echo '<td>';
                          echo "Non Lab ".$a[nama];
                        echo '</td>'; 
                      
                      } 

                        ?>
                        <td class="text-right"><?php echo formatRupiah3($row["harga"]);?></td>
                       
                        
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
               

              </table>
					</div>
				<div class="card-footer">
					<?php 
					//echo $row['status'] ;
					if ($status== '1'){
					?>
					<button type="button" id="<?php echo $_GET['id']?>" class="btn btn-success btn-sm btn-flat btnKirim">Kirim ke Perusahaan</button>
					<?php 
						}
					if($r['status']<4){
					?>
                	<a href="media.php?content=mcu&modul=update&id=<?php echo $_GET['id']?>" class="btn btn-warning btn-sm btn-flat">Edit</a>
					<?php
					}
					if($r['status']==8){
					?>
                	<a href="media.php?content=mcu&modul=revisi&id=<?php echo $_GET['id']?>" class="btn btn-warning btn-sm btn-flat">Revisi</a>
					<?php
					}
					?>
                	<a href="mcu-penawaran" class="btn btn-danger btn-sm  btn-flat">Kembali</a>
              </div>
				</div>
			</div>

			<div class="col-md-5">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Log
					</div>
					<div class="card-block">
					 <?php
				        $q= "Select  * from billing_paket_penawaran_log where id_billing_paket='$_GET[id]' ORDER BY waktu_input ASC ";
				         $res=pg_query($dbconn,$q);
				          ?>
						<table class="table">
						<thead>
		                <tr>
		                <th width="10px">No.</th>
		                <th width="">Waktu</th>
						<th width="">Status</th>
		                <th>Catatan/Keterangan</th> 
		                <th width="">Oleh</th>
		                </tr>
		                </thead>
		                <?php 
		                  $n=1;
		                 while ($row=pg_fetch_assoc($res)) {
		                 	$result =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_status_penawaran  where id= '$row[id_status_penawaran]' "));
							
							if($row['created_by']=='P'){
								$who=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$row[id_perusahaan]'"));
							}
							else{
								$who =pg_fetch_array(pg_query($dbconn, "SELECT b.nama FROM auth_users a, master_karyawan b where a.id_karyawan=b.id AND a.id_users= '$row[id_users]' "));
							}
							$a=explode(" ",$row['waktu_input']);
							$tanggal_input=DateToIndo2($a[0]);
							$jam_input=$a[1];
							$status="<span class='badge badge-$result[warna]'>$result[nama]</span>";
		                 ?>
							<tr>
							<td><?php echo $n++;?></td>
							<td><?php echo "$tanggal_input $jam_input";?></td>
							<td><?php echo $status;?></td>
							<td><?php echo $row['catatan'];?></td>
							<td><?php echo $who['nama'];?></td>
							</tr>
							<?php } ?>
						</table>

					</div>
				</div>
			</div>
			
			
		</div>
		<!--/.row-->
		
	</div>
</div>
<script type="text/javascript">
	
	$('.btnKirim').click(function()
	{
		
		var id=$(this).attr('id');
		var dataString2 = 'id='+id;
		$.ajax({
			type: 'POST',
			url: 'content/mcu/penawaran/komentar.php',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});	
	});
</script>