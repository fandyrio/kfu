
		<div class="row" style="padding-top:5px " id="show_our_packet">
			<div class="col-lg-6">
							<table id="myTable13" class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Nama</th>
                  <th>Harga</th>
									<th width="60px">#</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$unit = $_SESSION['id_units'];
							$res=pg_query($dbconn,"Select distinct id_billing_paket from billing_paket_kategori_harga_unit where id_unit='$unit' and id_kategori_harga='$_SESSION[id_perusahaan]' order by id_billing_paket asc");
							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket where id='".$row["id_billing_paket"]."' "));
                $w=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket_kategori_harga_unit where id_billing_paket='".$row["id_billing_paket"]."' and id_unit='$unit'  and id_kategori_harga='$_SESSION[id_perusahaan]' "));
							?>
								<tr>
									<td><?php echo $data["nama_paket"] ?></td>
                  <td><?php echo number_format($data["harga_net"],'0','','.') ?></td>
									<td class="text-center">
									   <a id="<?php echo $row['id_billing_paket'] ?>" class="btn btn-warning btn-xs btn-flat btnEditPaket"><i class="fa fa-edit"></i></a>
									   <a id="<?php echo $row['id_billing_paket'] ?>" class="btn btn-danger btn-xs btn-flat btnHapusPaket" ><i class="fa fa-trash"></i></a>
									  
									</td>
						
							   
								</tr>
							<?php 
							} 
							?> 
							</tbody>
						</table>
					
            </div>
            

		</div>
     <script>
    $(document).ready(function(){
          $('#myTable13').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
        });

    </script>