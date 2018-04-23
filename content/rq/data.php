<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Permintaan Penawaran</li>

</ol>

	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Data
						</div>



            <div class="box-header">
                <div class="row">
                  <div class="col-md-6 text-left">
                    
                  </div>
                  <div class="col-md-6 text-right">
                          <button type="button" onclick="location.href='media.php?inventori=rq&modul=new'" class="btn btn-primary btn-xs"> <i class="fa fa-dot-circle-o"></i> Tambah Data</button>   
                  </div>
                </div>
            </div>
						<div class="card-block">


						
							<table class="table " id="myTable">
								<thead class="table-dark">
				                <tr>
				                   <th >Doc No</th>
				                  <th >Doc Date</th>
				                  <th >Supplier</th>
				                  <th >Nama Brand</th>
				                   <th >Kuantiti</th>
				                   <th >Satuan</th>
				                   <th ></th>				                  
				                </tr>
				                </thead>
				                <tbody>
				             <?php
				             session_start();
				             unset($_SESSION['id_rq_hdr']);
				                 $res=pg_query($dbconn,"Select rq_hdr.*, inv_info_supplier.nama as \"nama_supplier\", auth_users.username \"nama_admin\", rq_ln.nama_brand, rq_ln.jumlah, inv_satuan.nama as \"nama_satuan\" from rq_hdr
				                   INNER JOIN inv_info_supplier on inv_info_supplier.id= rq_hdr.id_supplier
				                   INNER JOIN auth_users on auth_users.id_users= rq_hdr.createdby
				                   INNER JOIN rq_ln on rq_ln.id_rq= rq_hdr.id
				                   INNER JOIN inv_satuan on inv_satuan.id = rq_ln.id_satuan 
				                   	where rq_hdr.unit_id='$_SESSION[id_units]'");

				                 while ($row=pg_fetch_assoc($res)) {
				                     ?>
				                       <tr>
				                        <td><?php echo $row['doc_no'] ?></td>
				                        <td><?php echo $row['doc_date'] ?></td>
				                        <td><?php echo $row['nama_supplier'] ?></td>
				                        <td><?php echo $row['nama_brand'] ?></td>
				                        <td><?php echo $row['jumlah'] ?></td>
				                        <td><?php echo $row['nama_satuan'] ?></td>
				                        <td>
				                            <a href="media.php?inventori=rq&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><i class="icon-note"></i></a>
				                            <a href="media.php?inventori=rq&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
				                        </td>
				                       
				                        </tr>
				                    
				                 
				                 <?php } ?> 
				                </tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>